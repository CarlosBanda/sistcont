<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PosController extends Controller
{
    public function index()
    {
        return view('pos.index');
    }

    public function buscar(Request $request)
    {
        $texto = $request->texto;

        $productos = DB::table('products')
            ->where(function($q) use ($texto){
                $q->where('code', 'like', "%$texto%")
                  ->orWhere('name', 'like', "%$texto%")
                  ->orWhere('barcode', 'like', "%$texto%");
            })
            ->limit(10)
            ->get();

        return response()->json($productos);
    }
}