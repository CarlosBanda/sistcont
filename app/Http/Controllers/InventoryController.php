<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Inventory;
use App\Models\ProductPrice;
use App\Models\InventoryMovement;
use App\Http\Requests\StoreInventoryRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

/**
 * InventoryController
 * 
 * Controlador encargado de la gestión del inventario.
 * Permite agregar productos al inventario (con número de serie),
 * registrar ventas individuales, consultar historial de movimientos
 * y verificar stock disponible. Todos los datos se filtran por empresa.
 */
class InventoryController extends Controller
{
    public function __construct()
    {
        $this->middleware('tenant');
    }

    /**
     * Mostrar la vista del inventario con formulario y listado.
     * 
     * Carga los productos de la empresa para el select del formulario
     * y el listado de inventarios con el nombre del producto (via JOIN).
     *
     * @param Request $request
     * @return \Illuminate\View\View
     */
    public function index(Request $request)
    {
        $companyId = $request->tenant_company_id;

        // Obtener inventarios con el nombre del producto mediante JOIN
        $productos_inventory = Inventory::join('products', 'inventories.product_id', '=', 'products.id')
            ->where('products.company_id', $companyId)
            ->select('products.nombre as product_name', 'inventories.numero_serie', 'inventories.garantia', 'inventories.estatus')
            ->get();

        // Productos para el select del formulario de ingreso
        $productos = Product::where('company_id', $companyId)->get();

        return view('template.inventory.index', compact('productos_inventory', 'productos'));
    }

    /**
     * Agregar un producto al inventario.
     * 
     * Crea un registro de inventario con estatus "disponible" y
     * registra el movimiento inicial de tipo "entrada".
     * Todo dentro de una transacción para garantizar consistencia.
     *
     * @param StoreInventoryRequest $request Datos validados (product_id, numero_serie, codigo_barras, garantia)
     * @return \Illuminate\Http\JsonResponse Inventario creado
     */
    public function store(StoreInventoryRequest $request)
    {
        try {
            DB::beginTransaction();

            // Crear registro de inventario con estatus inicial "disponible"
            $inventory = Inventory::create([
                'product_id'    => $request->product_id,
                'numero_serie'  => $request->numero_serie,
                'codigo_barras' => $request->codigo_barras,
                'garantia'      => $request->garantia ?? 0,
                'estatus'       => 'disponible'
            ]);

            // Registrar movimiento de entrada
            InventoryMovement::create([
                'inventory_id' => $inventory->id,
                'tipo'         => 'entrada',
                'descripcion'  => 'Ingreso inicial al inventario',
                'user_id'      => auth('api')->id()
            ]);

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Inventario agregado correctamente',
                'data'    => $inventory
            ]);

        } catch (\Exception $e) {
            DB::rollBack();

            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Vender una unidad de inventario directamente por su ID.
     * 
     * Verifica que la unidad esté disponible, cambia su estatus a "vendido"
     * y registra el movimiento correspondiente.
     *
     * @param int $id ID del registro de inventario
     * @return \Illuminate\Http\JsonResponse Resultado de la operación
     */
    public function sell($id)
    {
        try {
            DB::beginTransaction();

            $inventory = Inventory::findOrFail($id);

            // Verificar disponibilidad antes de vender
            if ($inventory->estatus !== 'disponible') {
                return response()->json([
                    'success' => false,
                    'message' => 'La serie no está disponible'
                ], 422);
            }

            // Cambiar estatus a vendido
            $inventory->update(['estatus' => 'vendido']);

            // Registrar movimiento de venta
            InventoryMovement::create([
                'inventory_id' => $inventory->id,
                'tipo'         => 'venta',
                'descripcion'  => 'Venta del producto',
                'user_id'      => auth('api')->id()
            ]);

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Producto vendido correctamente'
            ]);

        } catch (\Exception $e) {
            DB::rollBack();

            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Obtener el historial completo de una unidad de inventario.
     * 
     * Retorna el registro de inventario con su producto asociado
     * y todos los movimientos registrados (entradas, ventas, etc.).
     *
     * @param int $id ID del registro de inventario
     * @return \Illuminate\Http\JsonResponse Inventario con relaciones
     */
    public function history($id)
    {
        $inventory = Inventory::with(['product', 'movements'])->findOrFail($id);

        return response()->json($inventory);
    }

    /**
     * Consultar el stock disponible de un producto específico.
     * 
     * Cuenta cuántas unidades tienen estatus "disponible"
     * para el product_id dado.
     *
     * @param int $productId ID del producto
     * @return \Illuminate\Http\JsonResponse product_id y cantidad en stock
     */
    public function stock($productId)
    {
        $stock = Inventory::where('product_id', $productId)
            ->where('estatus', 'disponible')
            ->count();

        return response()->json([
            'product_id' => $productId,
            'stock' => $stock
        ]);
    }
}
