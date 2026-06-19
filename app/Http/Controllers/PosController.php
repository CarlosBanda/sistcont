<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;

class PosController extends Controller
{
    public function index()
    {
        return view('pos.index');
    }

    public function buscar(Request $request)
    {
        $texto = trim($request->texto);

        if (strlen($texto) < 2) {
            return response()->json([]);
        }

        $productos = Product::with([
                'prices',
                'inventories' => function ($query) {
                    $query->where('estatus', 'disponible')
                        ->orderBy('id');
                },
            ])
            ->where(function ($query) use ($texto) {
                $query->where('modelo', 'like', "%{$texto}%")
                    ->orWhere('nombre', 'like', "%{$texto}%")
                    ->orWhereHas('inventories', function ($inventoryQuery) use ($texto) {
                        $inventoryQuery->where('codigo_barras', 'like', "%{$texto}%")
                            ->orWhere('numero_serie', 'like', "%{$texto}%");
                    });
            })
            ->limit(10)
            ->get()
            ->map(function ($producto) {
                $precio = $producto->prices->first();

                return [
                    'id' => $producto->id,
                    'code' => $producto->modelo,
                    'name' => $producto->nombre,
                    'description' => $producto->nombre,
                    'price' => $precio ? (float) $precio->precio : 0,
                    'price_type' => $precio ? $precio->tipo_precio : null,
                    'stock' => $producto->inventories->count(),
                    'barcodes' => $producto->inventories
                        ->pluck('codigo_barras')
                        ->filter()
                        ->values(),
                    'inventory_ids' => $producto->inventories->pluck('id')->values(),
                ];
            });

        return response()->json($productos);
    }
}
