<?php

namespace App\Http\Controllers;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductsController extends Controller
{
    public function create(Request $request){
        // return $request->all();
        $product = Product::create([
            'name' => $request-> product_name,
            'category' => $request-> product_category,
            'code' => $request -> product_code,
            'price' => $request -> product_price,
            'barcode' => $request -> product_bar,
            'description' => $request -> product_description,
            'sat_key' => $request -> product_sat,
            'sat_unit' => $request -> product_unit,
            'stock'=> 0,
            'user_id' => auth()->id()
        ]);

        return response()->json([
            'product' => $product
        ]);
    }

    public function getProducts(Request $request){
        // $prodcut = Product::all();
        $products = Product::where('user_id', auth()->id())->get();
        return response()->json($products);
    }
}
