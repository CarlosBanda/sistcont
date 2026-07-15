<?php

namespace App\Http\Controllers;

use App\Models\Cliente;
use App\Models\Company;
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
            'tax_regime' => '065',
            'cfdi_use' => 'G03',
            'zip_code' => $request->zip_code,
            'address' => $request->address,
            'number_ext' => $request->number_ext,
            'number_int' => $request->number_int,
            'colony' => $request->colony,
            'city' => $request->city,
            'state' => $request->state,
            'country' => $request->country,
        ]);

        return response()->json([
            'user' => $client,
        ]);
    }

    public function getClients()
    {
        if (!auth()->check()) {
            return response()->json(['message' => 'Unauthenticated'], 401);
        }

        $company = Company::where('user_id', auth()->id())->first();

        if (!$company) {
            return response()->json([]);
        }

        $quotations = Cliente::where('company_id', $company->id)->get();

        return response()->json($quotations);
    }
}
