<?php

namespace App\Http\Controllers;
use App\Models\Product;
use App\Models\Inventory;
use App\Models\ProductPrice;
use Illuminate\Http\Request;
use App\Http\Requests\StoreInventoryRequest;
use Illuminate\Support\Facades\DB;
use App\Models\InventoryMovement;

class InventoryController extends Controller
{

    public function index()
    {
        $productos_inventory = Inventory::join('products', 'inventories.product_id', '=', 'products.id')
            ->select('products.nombre as product_name', 'inventories.numero_serie', 'inventories.garantia', 'inventories.estatus')
            ->get();
        
            
        $productos = Product::all();
        //return $productos_inventory;
        return view('template.inventory.index', compact('productos_inventory', 'productos'));
    }


    public function store(StoreInventoryRequest $request)
    {
        // print_r($request->product_id);
        // return $request->all();
        try {

            DB::beginTransaction();

            $inventory = Inventory::create([
                'product_id'    => $request->product_id,
                'numero_serie'  => $request->numero_serie,
                'codigo_barras' => $request->codigo_barras,
                'garantia'      => $request->garantia ?? 0,
                'estatus'       => 'disponible'
            ]);

            InventoryMovement::create([
                'inventory_id' => $inventory->id,
                'tipo'         => 'entrada',
                'descripcion'  => 'Ingreso inicial al inventario',
                'user_id'      => auth()->id()
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

    public function sell($id)
    {
        try {

            DB::beginTransaction();

            $inventory = Inventory::findOrFail($id);

            if ($inventory->estatus !== 'disponible') {

                return response()->json([
                    'success' => false,
                    'message' => 'La serie no está disponible'
                ], 422);
            }

            $inventory->update([
                'estatus' => 'vendido'
            ]);

            InventoryMovement::create([
                'inventory_id' => $inventory->id,
                'tipo'         => 'venta',
                'descripcion'  => 'Venta del producto',
                'user_id'      => auth()->id()
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

    public function history($id)
    {
        $inventory = Inventory::with([
            'product',
            'movements'
        ])->findOrFail($id);

        return response()->json($inventory);
    }

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

    public function getStockAttribute()
    {
        return $this->inventories()
            ->where('estatus', 'disponible')
            ->count();
    }
}
