<?php

namespace App\Http\Controllers;

use App\Models\Cliente;
use App\Http\Requests\StoreClientRequest;
use Illuminate\Http\Request;

/**
 * ClientController
 * 
 * Controlador encargado de la gestión de clientes.
 * Permite crear, listar y actualizar clientes pertenecientes
 * a la empresa (tenant) del usuario autenticado.
 */
class ClientController extends Controller
{
    public function __construct()
    {
        $this->middleware('tenant');
    }

    /**
     * Crear un nuevo cliente.
     * 
     * Recibe los datos validados por StoreClientRequest, asigna automáticamente
     * el company_id del tenant y crea el registro en la tabla clients.
     * Para persona moral, el campo 'name' viene con la razón social directamente.
     * Para persona física, se concatena nombre + apellido.
     *
     * @param StoreClientRequest $request Datos validados del cliente
     * @return \Illuminate\Http\JsonResponse El cliente creado
     */
    public function create(StoreClientRequest $request)
    {
        $companyId = $request->tenant_company_id;

        // Construir nombre: si hay apellido se concatena, si no se usa solo name
        $name = $request->name;
        if ($request->lastname) {
            $name = $request->name . ' ' . $request->lastname;
        }

        $client = Cliente::create([
            'company_id'  => $companyId,
            'name'        => trim($name),
            'rfc'         => $request->rfc,
            'email'       => $request->email,
            'phone'       => $request->phone,
            'tax_regime'  => '065',
            'cfdi_use'    => 'G03',
            'zip_code'    => $request->zip_code,
            'address'     => $request->address,
            'number_ext'  => $request->number_ext,
            'number_int'  => $request->number_int,
            'colony'      => $request->colony,
            'city'        => $request->city,
            'state'       => $request->state,
            'country'     => $request->country ?? 'MX',
        ]);

        return response()->json([
            'client' => $client,
        ]);
    }

    /**
     * Listar todos los clientes de la empresa.
     * 
     * Retorna un JSON con todos los clientes que pertenecen
     * al company_id del usuario autenticado.
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse Lista de clientes
     */
    public function getClients(Request $request)
    {
        $companyId = $request->tenant_company_id;

        $clients = Cliente::where('company_id', $companyId)->get();

        return response()->json($clients);
    }

    /**
     * Actualizar datos de un cliente existente.
     * 
     * Busca el cliente por ID asegurándose que pertenezca a la empresa
     * del usuario. Si no existe o no pertenece, retorna 404.
     *
     * @param Request $request Datos a actualizar
     * @param int $id ID del cliente a editar
     * @return \Illuminate\Http\JsonResponse Cliente actualizado
     */
    public function update(Request $request, $id)
    {
        $companyId = $request->tenant_company_id;

        // Buscar cliente que pertenezca a la empresa del usuario
        $client = Cliente::where('company_id', $companyId)->findOrFail($id);

        // Actualizar solo los campos enviados
        $client->update([
            'name'       => $request->name,
            'rfc'        => $request->rfc,
            'email'      => $request->email,
            'phone'      => $request->phone,
            'zip_code'   => $request->zip_code,
            'address'    => $request->address,
            'number_ext' => $request->number_ext,
            'number_int' => $request->number_int,
            'colony'     => $request->colony,
            'city'       => $request->city,
            'state'      => $request->state,
            'country'    => $request->country,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Cliente actualizado correctamente',
            'client'  => $client
        ]);
    }
}
