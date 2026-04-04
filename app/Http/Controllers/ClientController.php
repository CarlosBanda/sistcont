<?php

namespace App\Http\Controllers;
use App\Models\Cliente;
use Illuminate\Http\Request;

class ClientController extends Controller
{
    

    public function create(Request $request)
    {
        $client = Cliente::create([
            'company_id' => 1,
            'name' => $request->name." ".$request->lastname,
            'rfc' => $request->rfc,
            'email' => $request->email,
            'phone' => $request->phone,
            //'tax_regime' => $request->tax_regime,
            'tax_regime' => "065",
            'cfdi_use' => "G03",
            'zip_code' => $request->zip_code,
            'address' => $request->address,
            'number_ext' => $request->number_ext,
            'number_int' => $request->number_int,
            'colony' => $request->colony,
            'city' => $request->city,
            'state' => $request->state,
            'country' => $request->country
        ]);
        return response()->json([
            'user' => $client
        ]);
    }

    public function getClients()
    {
        $clientes = Cliente::all(); // obtiene todos los registros
        return view('template.clients.index', compact('clientes'));
    }

}
