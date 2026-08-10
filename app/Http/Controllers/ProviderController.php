<?php

namespace App\Http\Controllers;

use App\Models\Provider;
use App\Http\Requests\StoreProviderRequest;
use Illuminate\Http\Request;
use Smalot\PdfParser\Parser;

/**
 * ProviderController
 * 
 * Controlador encargado de la gestión de proveedores.
 * Permite crear, listar, actualizar proveedores y extraer datos
 * de una constancia de situación fiscal (PDF del SAT).
 */
class ProviderController extends Controller
{
    public function __construct()
    {
        $this->middleware('tenant');
    }

    /**
     * Crear un nuevo proveedor.
     * 
     * Recibe los datos validados por StoreProviderRequest y crea
     * el registro asociado a la empresa del usuario autenticado.
     *
     * @param StoreProviderRequest $request Datos validados del proveedor
     * @return \Illuminate\Http\JsonResponse Proveedor creado
     */
    public function create(StoreProviderRequest $request)
    {
        $companyId = $request->tenant_company_id;

        $provider = Provider::create([
            'company_id'     => $companyId,
            'name_comercial' => $request->name_comercial,
            'rfc'            => $request->rfc,
            'razon_social'   => $request->razon_social,
            'status'         => $request->status,
            'cp'             => $request->cp,
            'ciudad'         => $request->ciudad,
            'num_ext'        => $request->num_ext,
            'municipio'      => $request->municipio,
            'colonia'        => $request->colonia,
            'address'        => $request->address,
            'pais'           => $request->pais,
        ]);

        return response()->json([
            'provider' => $provider
        ]);
    }

    /**
     * Mostrar vista de proveedores con el listado completo.
     * 
     * Filtra proveedores por company_id y los pasa a la vista Blade.
     *
     * @param Request $request
     * @return \Illuminate\View\View Vista de proveedores
     */
    public function index(Request $request)
    {
        $companyId = $request->tenant_company_id;

        $providers = Provider::where('company_id', $companyId)->get();

        return view('template.providers.index', compact('providers'));
    }

    /**
     * Actualizar datos de un proveedor existente.
     * 
     * Busca el proveedor asegurándose que pertenezca a la empresa
     * del usuario autenticado y actualiza todos los campos enviados.
     *
     * @param Request $request Datos a actualizar
     * @param int $id ID del proveedor
     * @return \Illuminate\Http\JsonResponse Proveedor actualizado
     */
    public function update(Request $request, $id)
    {
        $companyId = $request->tenant_company_id;

        // Verificar que el proveedor pertenece a la empresa del usuario
        $provider = Provider::where('company_id', $companyId)->findOrFail($id);

        $provider->update([
            'name_comercial' => $request->name_comercial,
            'rfc'            => $request->rfc,
            'razon_social'   => $request->razon_social,
            'status'         => $request->status,
            'cp'             => $request->cp,
            'ciudad'         => $request->ciudad,
            'num_ext'        => $request->num_ext,
            'municipio'      => $request->municipio,
            'colonia'        => $request->colonia,
            'address'        => $request->address,
            'pais'           => $request->pais,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Proveedor actualizado correctamente',
            'provider' => $provider
        ]);
    }

    /**
     * Leer y extraer datos de una constancia de situación fiscal (PDF del SAT).
     * 
     * Utiliza la librería smalot/pdfparser para parsear el PDF,
     * luego aplica expresiones regulares para extraer campos clave como:
     * RFC, Razón Social, Código Postal, Estado, Localidad, Nombre Comercial,
     * Colonia, Número Exterior, Estatus en el padrón y Dirección.
     *
     * @param Request $request Archivo PDF subido
     * @return \Illuminate\Http\JsonResponse Datos extraídos del PDF
     */
    public function leerPdf(Request $request)
    {
        // Validar que se envió un archivo PDF
        $request->validate([
            'pdf' => 'required|mimes:pdf'
        ]);

        $file = $request->file('pdf');

        // Parsear el contenido del PDF
        $parser = new Parser();
        $pdf = $parser->parseFile($file->getPathname());
        $texto = $pdf->getText();

        // Extraer campos mediante expresiones regulares
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
            'rfc'            => $rfc[1] ?? '',
            'razon'          => $razon[1] ?? '',
            'cp'             => $cp[1] ?? '',
            'estado'         => $estado[1] ?? '',
            'localidad'      => $localidad[1] ?? '',
            'comercial'      => $comercial[1] ?? '',
            'colonia'        => $colonia[1] ?? '',
            'numeroExterior' => $numeroExterior[1] ?? '',
            'estatus'        => $estatus[1] ?? '',
            'direccion'      => $direccion[1] ?? ''
        ]);
    }
}
