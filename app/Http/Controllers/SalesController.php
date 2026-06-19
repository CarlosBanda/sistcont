<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;
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

class SalesController extends Controller
{

    public function getNextFolio(Request $request)
    {

        $type = $request->type;

        $company = Company::where('user_id', auth()->id())->first();
        $companyName = $company->name;

        $companyPrefix = strtoupper(substr($companyName, 0, 2));


        $last = Folio::where('folio_type',$type)
            ->where('company_id', $company->id)
            ->latest()
            ->first();

        if(!$last){
            $number = 1;
        } else {
            $parts = explode('-', $last->folio);
            $lastNumber = (int) end($parts);
            $number = $lastNumber + 1;
        }

        $folio = $companyPrefix . '-' . $type . '-' . str_pad($number, 3, '0', STR_PAD_LEFT);

        return response()->json([
            'folio' => $folio
        ]);
    }

    public function index(){
        $clientes = Cliente::all(); // obtiene todos los registros
        $users = User::all(); // obtiene todos los registros
        $productos = Product::all(); // obtiene todos los registros

        //return response()->json($data);
        return view('template.sales.create-sale', compact('clientes', 'users', 'productos'));

    }

    public function create(Request $request){

        $userId = $request->user_id;

        $company = Company::where('user_id', $userId)->first();
        $prefix = strtoupper(substr($company->name, 0, 2));
        $type = 'COT';

        $last = Folio::where('folio_type', $type)
            ->where('company_id', $company->id)
            ->latest()
            ->first();

        $number = $last ? ((int) explode('-', $last->folio)[2] +1) : 1;
        
        $folioText = $prefix . '-' . $type . '-' . str_pad($number, 3, '0', STR_PAD_LEFT);

        $folio =  Folio::create([
            'user_id' => $userId,
            'company_id' => $company->id,
            'folio_type' => $type,
            'folio' => $folioText
        ]);

        $quotation = Quotation::create([
            'company_id' => $company->id,
            'client_id' => $request->client_id,
            'contact_name' => $request->contact_name,
            'quotation_date' => $request->quotation_date,
            'folio_id' => $folio->id,
            'currency' => $request-> currency
        ]);

        foreach ($request->products as $item) {
            $quotationItem = QuotationItem::create([
                'quotation_id' => $quotation->id,
                'product_id' => $item['product_id'],
                'qty' => $item['qty'],
                'price' => $item['price'],
                'discount' => $item['discount'],
                'tax' => $item['tax'],
                'total' => $item['total']
            ]);
        }

        return response()->json([
            'quotation' => $quotation,
            'folio' => $folioText,
            'quotationItem' => $quotationItem
        ]);
    }

    public function storeSale(Request $request)
    {
        $data = $request->validate([
            'client_id' => ['required', 'exists:clients,id'],
            'user_id' => ['required', 'exists:users,id'],
            'sale_date' => ['nullable', 'date'],
            'folio' => ['nullable', 'string', 'max:255'],
            'currency' => ['nullable', 'string', 'size:3'],
            'products' => ['required', 'array', 'min:1'],
            'products.*.product_id' => ['required', 'exists:products,id'],
            'products.*.qty' => ['required', 'integer', 'min:1'],
            'products.*.price' => ['required', 'numeric', 'min:0'],
            'products.*.discount' => ['nullable', 'numeric', 'min:0', 'max:100'],
            'products.*.tax' => ['nullable', 'numeric', 'min:0', 'max:100'],
            'products.*.inventory_ids' => ['required', 'array'],
            'products.*.inventory_ids.*' => ['integer', 'exists:inventories,id'],
        ]);

        $sale = DB::transaction(function () use ($data) {
            $sellerId = (int) $data['user_id'];
            $company = Company::where('user_id', $sellerId)->first()
                ?? Company::where('user_id', auth()->id())->first();

            if (!$company) {
                throw ValidationException::withMessages([
                    'company' => 'No se encontro una empresa relacionada con el vendedor seleccionado.',
                ]);
            }

            $folioText = $data['folio'] ?? null;
            if (!$folioText) {
                $folioText = $this->buildNextFolio('NV', $company);
            }

            if (Folio::where('folio', $folioText)->exists()) {
                throw ValidationException::withMessages([
                    'folio' => 'El folio ya existe. Genera uno nuevo antes de guardar.',
                ]);
            }

            $folio = Folio::create([
                'user_id' => $sellerId,
                'company_id' => $company->id,
                'folio_type' => 'NV',
                'folio' => $folioText,
            ]);

            $sale = Sale::create([
                'company_id' => $company->id,
                'client_id' => $data['client_id'],
                'user_id' => $sellerId,
                'folio_id' => $folio->id,
                'sale_date' => $data['sale_date'] ?? now()->toDateString(),
                'currency' => $data['currency'] ?? 'MXN',
                'subtotal' => 0,
                'discount' => 0,
                'tax' => 0,
                'total' => 0,
            ]);

            $subtotalGeneral = 0;
            $descuentoGeneral = 0;
            $ivaGeneral = 0;
            $totalGeneral = 0;

            foreach ($data['products'] as $index => $item) {
                $qty = (int) $item['qty'];
                $inventoryIds = array_values(array_unique($item['inventory_ids']));

                if (count($inventoryIds) !== $qty) {
                    throw ValidationException::withMessages([
                        "products.{$index}.inventory_ids" => 'La cantidad debe coincidir con los codigos de inventario seleccionados.',
                    ]);
                }

                $inventories = Inventory::whereIn('id', $inventoryIds)
                    ->where('product_id', $item['product_id'])
                    ->lockForUpdate()
                    ->get();

                if ($inventories->count() !== $qty || $inventories->contains(fn ($inventory) => $inventory->estatus !== 'disponible')) {
                    throw ValidationException::withMessages([
                        "products.{$index}.inventory_ids" => 'Uno o mas codigos ya no estan disponibles para venta.',
                    ]);
                }

                $price = (float) $item['price'];
                $discountPercent = (float) ($item['discount'] ?? 0);
                $taxPercent = (float) ($item['tax'] ?? 0);

                $subtotal = $qty * $price;
                $discountAmount = $subtotal * ($discountPercent / 100);
                $taxBase = $subtotal - $discountAmount;
                $taxAmount = $taxBase * ($taxPercent / 100);
                $total = $taxBase + $taxAmount;

                SaleItem::create([
                    'sale_id' => $sale->id,
                    'product_id' => $item['product_id'],
                    'qty' => $qty,
                    'price' => $price,
                    'discount' => $discountPercent,
                    'tax' => $taxPercent,
                    'subtotal' => $subtotal,
                    'discount_amount' => $discountAmount,
                    'tax_amount' => $taxAmount,
                    'total' => $total,
                    'inventory_ids' => $inventoryIds,
                ]);

                foreach ($inventories as $inventory) {
                    $inventory->update([
                        'estatus' => 'vendido',
                    ]);

                    InventoryMovement::create([
                        'inventory_id' => $inventory->id,
                        'tipo' => 'venta',
                        'descripcion' => 'Venta ' . $folioText,
                        'user_id' => auth()->id() ?? $sellerId,
                    ]);
                }

                $subtotalGeneral += $subtotal;
                $descuentoGeneral += $discountAmount;
                $ivaGeneral += $taxAmount;
                $totalGeneral += $total;
            }

            $sale->update([
                'subtotal' => $subtotalGeneral,
                'discount' => $descuentoGeneral,
                'tax' => $ivaGeneral,
                'total' => $totalGeneral,
            ]);

            return $sale->load(['folio', 'items']);
        });

        return response()->json([
            'success' => true,
            'message' => 'Venta guardada correctamente',
            'sale' => $sale,
        ]);
    }

    public function getQuotations(){
        $company = Company::where('user_id',auth()->id())->first();

        $quotations = Quotation::with(['client','folio'])
            ->where('company_id', $company->id)
            ->get();
        return response()->json($quotations);
    }

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
