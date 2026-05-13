<?php

namespace App\Http\Controllers;
use App\Models\Provider;
use Illuminate\Http\Request;
use Smalot\PdfParser\Parser;

class ProviderController extends Controller
{
    //

    public function create(Request $request){
        $provider = Provider::create([
            'name_comercial' => $request-> name_comercial,
            'rfc' => $request-> rfc,
            'razon_social' => $request -> razon_social,
            'status' => $request -> status,
            'cp' => $request -> cp,
            'ciudad' => $request -> ciudad,
            'num_ext' => $request -> num_ext,
            'municipio' => $request -> municipio,
            'colonia'=> $request->colonia,
            'address'=> $request->address,
            'pais'=> $request->pais
        ]);

        return response()->json([
            'provider' => $provider
        ]);

    }

    public function index(){
        $providers = Provider::all();
        return view('template.providers.index', compact('providers'));
    }

    public function leerPdf(Request $request)
    {
        $request->validate([
            'pdf' => 'required|mimes:pdf'
        ]);

        $file = $request->file('pdf');

        $parser = new \Smalot\PdfParser\Parser();

        $pdf = $parser->parseFile($file->getPathname());

        $texto = $pdf->getText();

        preg_match('/RFC:\s*([^\s]+)/', $texto, $rfc);

        preg_match('/Denominación\/RazónSocial:\s*([^\n\r\t]+)/', $texto, $razon);

        preg_match('/CódigoPostal:\s*([0-9]+)/', $texto, $cp);

        preg_match('/NombredelaEntidadFederativa:\s*([^\s]+)/', $texto, $estado);

        preg_match('/NombredelaLocalidad:\s*([^\s]+)/', $texto, $localidad);

        preg_match('/NombreComercial:\s*([^\n\r\t]+)/', $texto, $comercial);

        preg_match('/NombredelaColonia:\s*([^\s]+)/', $texto, $colonia);

        preg_match('/NúmeroExterior:\s*([^\s]+)/', $texto, $numeroExterior);
        preg_match('/Estatusenelpadrón:\s*([^\s]+)/', $texto, $estatus);
        preg_match('/NombredeVialidad:\s*([^\s]+)/', $texto, $direccion);

        return response()->json([
            'rfc' => $rfc[1] ?? '',
            'razon' => $razon[1] ?? '',
            'cp' => $cp[1] ?? '',
            'estado' => $estado[1] ?? '',
            'localidad' => $localidad[1] ?? '',
            'comercial' => $comercial[1] ?? '',
            'colonia' => $colonia[1] ?? '',
            'numeroExterior' => $numeroExterior[1] ?? '',
            'estatus' => $estatus[1] ?? '',
            'direccion' => $direccion[1] ?? ''
        ]);
    }

}
