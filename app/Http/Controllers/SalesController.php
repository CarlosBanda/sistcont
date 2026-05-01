<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Quotation;
use App\Models\Cliente;
use App\Models\User;
use App\Models\Product;

class SalesController extends Controller
{

    public function getNextFolio() //pinche banda si preguntas esta madre genera el folio  que pediste
    {
        $last = Quotation::latest()->first();

        if(!$last){
            $number = 1;
        } else {
            $lastNumber = (int) str_replace('COT-', '', $last->folio);
            $number = $lastNumber + 1;
        }

        $folio = 'COT-' . str_pad($number, 3, '0', STR_PAD_LEFT);

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
        // return $request;
        $quotation = Quotation::create([
            'serie' => $request-> serie,
            'user_id' => auth()->id(),
            'client_id' => $request->client_id,
            'contact_name' => $request->contact_name,
            'folio' => $request->folio,
            'quotation_date' => $request->quotation_date,
            'currency' => $request-> currency
        ]);

        return response()->json([
            'quotation' => $quotation
        ]);
    }
}
