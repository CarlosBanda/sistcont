<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;
use App\Http\Requests\StoreQuotationRequest;
use App\Http\Requests\StoreSaleRequest;
use App\Models\Quotation;
use App\Models\Cliente;
use App\Models\User;
use App\Models\Product;
use App\Models\Folio;
use App\Models\Company;
use App\Models\QuotationItem;
use App\Models\Sale;
use App\Models\SaleItem;
use App\Models\Inventory;
use App\Models\InventoryMovement;
use Barryvdh\DomPDF\Facade\Pdf;

/**
 * SalesController
 * 
 * Controlador principal del módulo de ventas y cotizaciones.
 * Gestiona la generación de folios, creación de cotizaciones,
 * registro de ventas con control de inventario, listados y generación de PDFs.
 * Todas las operaciones están aisladas por empresa (tenant).
 */
class SalesController extends Controller
{
    public function __construct()
    {
        $this->middleware('tenant');
    }

    /**
     * Generar el siguiente folio disponible para un tipo dado.
     * 
     * El folio sigue el formato: [PREFIJO_EMPRESA]-[TIPO]-[NUMERO]
     * Ejemplo: SI-COT-001, SI-NV-015
     * 
     * Busca el último folio del mismo tipo y empresa, extrae el número
     * secuencial y lo incrementa.
     *
     * @param Request $request Debe incluir 'type' (COT, NV, etc.)
     * @return \Illuminate\Http\JsonResponse Folio generado
     */
    public function getNextFolio(Request $request)
    {
        $type = $request->type;
        $companyId = $request->tenant_company_id;

        $company = Company::findOrFail($companyId);
        // Usar las primeras 2 letras del nombre de la empresa como prefijo
        $companyPrefix = strtoupper(substr($company->name, 0, 2));

        // Buscar el último folio de este tipo para esta empresa
        $last = Folio::where('folio_type', $type)
            ->where('company_id', $companyId)
            ->latest()
            ->first();

        // Calcular el siguiente número secuencial
        if (!$last) {
            $number = 1;
        } else {
            $parts = explode('-', $last->folio);
            $lastNumber = (int) end($parts);
            $number = $lastNumber + 1;
        }

        // Formato final: XX-TIPO-001
        $folio = $companyPrefix . '-' . $type . '-' . str_pad($number, 3, '0', STR_PAD_LEFT);

        return response()->json([
            'folio' => $folio
        ]);
    }

    /**
     * Mostrar la vista de creación de venta/cotización.
     * 
     * Carga los clientes, usuarios y productos de la empresa
     * para poblar los selects del formulario.
     *
     * @param Request $request
     * @return \Illuminate\View\View
     */
    public function index(Request $request)
    {
        $companyId = $request->tenant_company_id;

        $clientes = Cliente::where('company_id', $companyId)->get();
        $users = User::where('company_id', $companyId)->get();
        $productos = Product::where('company_id', $companyId)->get();

        return view('template.sales.create-sale', compact('clientes', 'users', 'productos'));
    }

    /**
     * Crear una nueva cotización con sus ítems.
     * 
     * Proceso:
     * 1. Genera un folio secuencial tipo COT para la empresa
     * 2. Crea el registro de folio en la tabla folios
     * 3. Crea la cotización con totales generales
     * 4. Itera sobre los productos para crear los QuotationItems
     *
     * @param StoreQuotationRequest $request Datos validados de la cotización
     * @return \Illuminate\Http\JsonResponse Cotización, folio y último ítem
     */
    public function create(StoreQuotationRequest $request)
    {
        $companyId = $request->tenant_company_id;
        $company = Company::findOrFail($companyId);

        // Generar folio de cotización
        $prefix = strtoupper(substr($company->name, 0, 2));
        $type = 'COT';

        $last = Folio::where('folio_type', $type)
            ->where('company_id', $companyId)
            ->latest()
            ->first();

        $number = $last ? ((int) explode('-', $last->folio)[2] + 1) : 1;
        $folioText = $prefix . '-' . $type . '-' . str_pad($number, 3, '0', STR_PAD_LEFT);

        // Registrar el folio en la base de datos
        $folio = Folio::create([
            'user_id'      => $request->user_id,
            'company_id'   => $companyId,
            'folio_type'   => $type,
            'folio'        => $folioText
        ]);

        // Crear la cotización
        $quotation = Quotation::create([
            'company_id'     => $companyId,
            'client_id'      => $request->client_id,
            'contact_name'   => $request->contact_name,
            'quotation_date' => $request->quotation_date,
            'folio_id'       => $folio->id,
            'currency'       => $request->currency ?? 'MXN',
            'subtotal'       => $request->subtotal ?? 0,
            'discount'       => $request->discount_total ?? 0,
            'tax'            => $request->tax_total ?? 0,
            'total'          => $request->grand_total ?? 0,
        ]);

        // Crear los ítems (líneas) de la cotización
        $quotationItem = null;
        foreach ($request->products as $item) {
            $quotationItem = QuotationItem::create([
                'quotation_id' => $quotation->id,
                'product_id'   => $item['product_id'],
                'barcode'      => $item['barcode'] ?? null,
                'qty'          => $item['qty'],
                'price'        => $item['price'],
                'discount'     => $item['discount'] ?? 0,
                'tax'          => $item['tax'] ?? 0,
                'total'        => $item['total'],
            ]);
        }

        return response()->json([
            'quotation'     => $quotation,
            'folio'         => $folioText,
            'quotationItem' => $quotationItem
        ]);
    }

    /**
     * Registrar una nueva venta (nota de venta).
     * 
     * Proceso completo dentro de una transacción:
     * 1. Genera o valida el folio de venta (tipo NV)
     * 2. Crea el registro de la venta con totales en 0
     * 3. Por cada producto:
     *    - Valida que los inventory_ids coincidan con la cantidad
     *    - Bloquea los inventarios (lockForUpdate) para evitar ventas concurrentes
     *    - Calcula subtotal, descuento, IVA y total por línea
     *    - Crea el SaleItem
     *    - Marca cada inventario como "vendido"
     *    - Registra el movimiento de inventario
     * 4. Actualiza los totales generales de la venta
     *
     * @param StoreSaleRequest $request Datos validados de la venta
     * @return \Illuminate\Http\JsonResponse Venta con folio e ítems
     */
    public function storeSale(StoreSaleRequest $request)
    {
        $companyId = $request->tenant_company_id;

        $sale = DB::transaction(function () use ($request, $companyId) {
            $company = Company::findOrFail($companyId);
            $sellerId = (int) $request->user_id;

            // Generar folio si no se envió uno manualmente
            $folioText = $request->folio ?? null;
            if (!$folioText) {
                $folioText = $this->buildNextFolio('NV', $company);
            }

            // Verificar que el folio no esté duplicado
            if (Folio::where('folio', $folioText)->exists()) {
                throw ValidationException::withMessages([
                    'folio' => 'El folio ya existe. Genera uno nuevo antes de guardar.',
                ]);
            }

            // Registrar el folio
            $folio = Folio::create([
                'user_id'      => $sellerId,
                'company_id'   => $companyId,
                'folio_type'   => 'NV',
                'folio'        => $folioText,
            ]);

            // Crear la venta con totales en 0 (se actualizan al final)
            $sale = Sale::create([
                'company_id' => $companyId,
                'client_id'  => $request->client_id,
                'user_id'    => $sellerId,
                'folio_id'   => $folio->id,
                'sale_date'  => $request->sale_date ?? now()->toDateString(),
                'currency'   => $request->currency ?? 'MXN',
                'subtotal'   => 0,
                'discount'   => 0,
                'tax'        => 0,
                'total'      => 0,
            ]);

            // Acumuladores de totales generales
            $subtotalGeneral = 0;
            $descuentoGeneral = 0;
            $ivaGeneral = 0;
            $totalGeneral = 0;

            // Procesar cada línea de producto
            foreach ($request->products as $index => $item) {
                $qty = (int) $item['qty'];
                $inventoryIds = array_values(array_unique($item['inventory_ids']));

                // Validar que la cantidad coincida con los IDs de inventario
                if (count($inventoryIds) !== $qty) {
                    throw ValidationException::withMessages([
                        "products.{$index}.inventory_ids" => 'La cantidad debe coincidir con los códigos de inventario seleccionados.',
                    ]);
                }

                // Bloquear registros de inventario para evitar venta concurrente
                $inventories = Inventory::whereIn('id', $inventoryIds)
                    ->where('product_id', $item['product_id'])
                    ->lockForUpdate()
                    ->get();

                // Verificar disponibilidad
                if ($inventories->count() !== $qty || $inventories->contains(fn ($inventory) => $inventory->estatus !== 'disponible')) {
                    throw ValidationException::withMessages([
                        "products.{$index}.inventory_ids" => 'Uno o más códigos ya no están disponibles para venta.',
                    ]);
                }

                // Cálculos de montos por línea
                $price = (float) $item['price'];
                $discountPercent = (float) ($item['discount'] ?? 0);
                $taxPercent = (float) ($item['tax'] ?? 0);

                $subtotal = $qty * $price;                          // Subtotal = cantidad × precio
                $discountAmount = $subtotal * ($discountPercent / 100); // Descuento en pesos
                $taxBase = $subtotal - $discountAmount;             // Base para calcular IVA
                $taxAmount = $taxBase * ($taxPercent / 100);        // IVA en pesos
                $total = $taxBase + $taxAmount;                     // Total de la línea

                // Crear el ítem de la venta
                SaleItem::create([
                    'sale_id'         => $sale->id,
                    'product_id'      => $item['product_id'],
                    'qty'             => $qty,
                    'price'           => $price,
                    'discount'        => $discountPercent,
                    'tax'             => $taxPercent,
                    'subtotal'        => $subtotal,
                    'discount_amount' => $discountAmount,
                    'tax_amount'      => $taxAmount,
                    'total'           => $total,
                    'inventory_ids'   => $inventoryIds,
                ]);

                // Marcar cada unidad como vendida y registrar el movimiento
                foreach ($inventories as $inventory) {
                    $inventory->update(['estatus' => 'vendido']);

                    InventoryMovement::create([
                        'inventory_id' => $inventory->id,
                        'tipo'         => 'venta',
                        'descripcion'  => 'Venta ' . $folioText,
                        'user_id'      => auth('api')->id() ?? $sellerId,
                    ]);
                }

                // Acumular totales generales
                $subtotalGeneral += $subtotal;
                $descuentoGeneral += $discountAmount;
                $ivaGeneral += $taxAmount;
                $totalGeneral += $total;
            }

            // Actualizar los totales de la venta
            $sale->update([
                'subtotal' => $subtotalGeneral,
                'discount' => $descuentoGeneral,
                'tax'      => $ivaGeneral,
                'total'    => $totalGeneral,
            ]);

            return $sale->load(['folio', 'items']);
        });

        return response()->json([
            'success' => true,
            'message' => 'Venta guardada correctamente',
            'sale'    => $sale,
        ]);
    }

    /**
     * Listar todas las cotizaciones de la empresa con cliente y folio.
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse Lista de cotizaciones
     */
    public function getQuotations(Request $request)
    {
        $companyId = $request->tenant_company_id;

        $quotations = Quotation::with(['client', 'folio'])
            ->where('company_id', $companyId)
            ->get();

        return response()->json($quotations);
    }

    /**
     * Obtener el detalle de una cotización específica.
     * 
     * Incluye cliente, ítems y productos de cada ítem.
     * Verifica que la cotización pertenezca a la empresa del usuario.
     *
     * @param int $id ID de la cotización
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse Cotización con relaciones
     */
    public function getQuotation($id, Request $request)
    {
        $companyId = $request->tenant_company_id;

        $quotation = Quotation::with(['client', 'items.product'])
            ->where('company_id', $companyId)
            ->findOrFail($id);

        return response()->json($quotation);
    }

    /**
     * Generar y mostrar el PDF de una cotización.
     * 
     * Usa DomPDF para renderizar la vista quotationPDF con los datos
     * de la cotización. El PDF se muestra en el navegador (stream).
     *
     * @param int $id ID de la cotización
     * @param Request $request
     * @return \Illuminate\Http\Response PDF en streaming
     */
    public function generatePDF($id, Request $request)
    {
        $companyId = $request->tenant_company_id;

        $quotation = Quotation::with(['client', 'user', 'items.product'])
            ->where('company_id', $companyId)
            ->findOrFail($id);

        $pdf = Pdf::loadView('template.sales.quotationPDF', compact('quotation'));

        return $pdf->stream('cotizacion_' . $quotation->id . '.pdf');
    }

    /**
     * Construir el siguiente folio disponible (método privado auxiliar).
     * 
     * Utilizado internamente por storeSale cuando no se proporciona un folio.
     * Formato: [PREFIJO]-[TIPO]-[NUMERO_PADDED]
     *
     * @param string $type Tipo de folio (NV, COT, etc.)
     * @param Company $company Empresa para el prefijo y filtrado
     * @return string Folio generado
     */
    private function buildNextFolio(string $type, Company $company): string
    {
        $prefix = strtoupper(substr($company->name, 0, 2));
        $last = Folio::where('folio_type', $type)
            ->where('company_id', $company->id)
            ->latest()
            ->first();

        $number = 1;
        if ($last) {
            $parts = explode('-', $last->folio);
            $number = ((int) end($parts)) + 1;
        }

        return $prefix . '-' . $type . '-' . str_pad($number, 3, '0', STR_PAD_LEFT);
    }
}
