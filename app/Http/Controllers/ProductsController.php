<?php

namespace App\Http\Controllers;
use App\Models\Product;
use App\Models\ProductPrice;
use Illuminate\Http\Request;

class ProductsController extends Controller
{
    public function create(Request $request){

        // return $request->all();
        $product = Product::create([
            'modelo' => $request->product_model,
            'nombre' => $request->product_name,
            'unidad_medida_id' => $request->product_unit,
            'user_id' => auth()->id()
        ]);

        foreach ($request->prices as $price) {
            $productPrices = ProductPrice::create([
                'product_id' => $product->id,
                'tipo_precio' => $price['type'],
                'precio' => $price['price'],
            ]);
        };

        return response()->json([
            'product' => $product,
            'productPrices' => $productPrices
        ]);
    }

    public function getProducts(Request $request){
        // $prodcut = Product::all();
        $products = Product::with(['prices','inventories'])
                ->where('user_id', auth()->id())
                ->get();
        return response()->json($products);
    }

    public function buscarProducto(Request $request)
    {
        $texto = $request->texto;

        $productos = DB::table('products')
            ->where('name', 'like', "%$texto%")
            ->orWhere('code', 'like', "%$texto%")
            ->where('description', 'Activo')
            ->limit(10)
            ->get();

        return response()->json($productos);
    }
}
