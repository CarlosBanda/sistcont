<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\ProductPrice;
use App\Http\Requests\StoreProductRequest;
use Illuminate\Http\Request;

/**
 * ProductsController
 * 
 * Controlador encargado de la gestión del catálogo de productos.
 * Permite crear, listar y actualizar productos (incluyendo sus precios)
 * filtrados por la empresa del usuario autenticado.
 */
class ProductsController extends Controller
{
    public function __construct()
    {
        $this->middleware('tenant');
    }

    /**
     * Crear un nuevo producto con sus precios.
     * 
     * Recibe los datos validados por StoreProductRequest.
     * Crea el producto asignando el company_id del tenant y
     * luego itera sobre el array de precios para crearlos asociados al producto.
     *
     * @param StoreProductRequest $request Datos validados (modelo, nombre, unidad, precios[])
     * @return \Illuminate\Http\JsonResponse Producto y sus precios creados
     */
    public function create(StoreProductRequest $request)
    {
        $companyId = $request->tenant_company_id;

        // Crear el producto con los datos básicos
        $product = Product::create([
            'company_id'      => $companyId,
            'modelo'          => $request->product_model,
            'nombre'          => $request->product_name,
            'unidad_medida_id' => $request->product_unit,
            'user_id'         => auth('api')->id()
        ]);

        // Crear cada precio asociado al producto
        $productPrices = null;
        foreach ($request->prices as $price) {
            $productPrices = ProductPrice::create([
                'product_id'   => $product->id,
                'tipo_precio'  => $price['type'],
                'precio'       => $price['price'],
            ]);
        }

        return response()->json([
            'product' => $product,
            'productPrices' => $productPrices
        ]);
    }

    /**
     * Listar todos los productos de la empresa con sus precios e inventarios.
     * 
     * Carga las relaciones 'prices' e 'inventories' mediante eager loading
     * para evitar el problema N+1 de consultas.
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse Lista de productos con relaciones
     */
    public function getProducts(Request $request)
    {
        $companyId = $request->tenant_company_id;

        $products = Product::with(['prices', 'inventories'])
            ->where('company_id', $companyId)
            ->get();

        return response()->json($products);
    }

    /**
     * Actualizar un producto existente y sus precios.
     * 
     * Busca el producto verificando que pertenezca a la empresa del tenant.
     * Actualiza los campos básicos y, si se envían precios, elimina los
     * anteriores y los recrea (estrategia de reemplazo completo).
     *
     * @param Request $request Datos a actualizar (modelo, nombre, unidad, prices[])
     * @param int $id ID del producto
     * @return \Illuminate\Http\JsonResponse Producto actualizado con precios
     */
    public function update(Request $request, $id)
    {
        $companyId = $request->tenant_company_id;

        // Buscar producto que pertenezca a la empresa
        $product = Product::where('company_id', $companyId)->findOrFail($id);

        // Actualizar campos básicos del producto
        $product->update([
            'modelo'          => $request->modelo,
            'nombre'          => $request->nombre,
            'unidad_medida_id' => $request->unidad_medida_id,
        ]);

        // Si se envían precios, reemplazar todos los existentes
        if ($request->has('prices')) {
            // Eliminar precios anteriores
            ProductPrice::where('product_id', $product->id)->delete();

            // Crear los nuevos precios
            foreach ($request->prices as $price) {
                ProductPrice::create([
                    'product_id'  => $product->id,
                    'tipo_precio' => $price['type'],
                    'precio'      => $price['price'],
                ]);
            }
        }

        return response()->json([
            'success' => true,
            'message' => 'Producto actualizado correctamente',
            'product' => $product->load('prices')
        ]);
    }
}
