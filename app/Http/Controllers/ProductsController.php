<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ProductsController extends Controller
{
    public function store(Request $request){
        return response()->json([
            'message' => 'Producto creado'
        ]);
    }
}
