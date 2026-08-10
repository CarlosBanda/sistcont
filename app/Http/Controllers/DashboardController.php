<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Sale;
use App\Models\Cliente;
use App\Models\Product;
use App\Models\Quotation;
use App\Models\Inventory;
use App\Models\SaleItem;
use Carbon\Carbon;

/**
 * DashboardController
 * 
 * Controlador encargado de generar las estadísticas y datos
 * necesarios para los widgets del dashboard principal.
 * Todos los datos se filtran por la empresa (tenant) del usuario autenticado.
 */
class DashboardController extends Controller
{
    public function __construct()
    {
        $this->middleware('tenant');
    }

    /**
     * Obtiene todas las estadísticas del dashboard para la empresa del usuario.
     * 
     * Retorna:
     * - cards: Resumen numérico (ventas del mes, clientes, productos, cotizaciones)
     * - ventas_mensuales: Total de ventas agrupado por mes (últimos 6 meses)
     * - estatus_inventario: Conteo de inventarios por estatus (disponible, vendido, etc.)
     * - top_productos: Los 5 productos más vendidos por cantidad de unidades
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function stats(Request $request)
    {
        $companyId = $request->tenant_company_id;
        $now = Carbon::now();

        // ─── Cards de resumen rápido ──────────────────────────────────

        // Suma total de ventas del mes actual
        $ventasMes = Sale::where('company_id', $companyId)
            ->whereMonth('sale_date', $now->month)
            ->whereYear('sale_date', $now->year)
            ->sum('total');

        // Cantidad total de clientes registrados en la empresa
        $totalClientes = Cliente::where('company_id', $companyId)->count();

        // Cantidad total de productos en el catálogo de la empresa
        $totalProductos = Product::where('company_id', $companyId)->count();

        // Cantidad de cotizaciones generadas en el mes actual
        $cotizacionesMes = Quotation::where('company_id', $companyId)
            ->whereMonth('quotation_date', $now->month)
            ->whereYear('quotation_date', $now->year)
            ->count();

        // ─── Ventas mensuales (últimos 6 meses) ──────────────────────
        // Recorre los últimos 6 meses y suma el total de ventas de cada uno
        $ventasMensuales = [];
        for ($i = 5; $i >= 0; $i--) {
            $date = $now->copy()->subMonths($i);
            $total = Sale::where('company_id', $companyId)
                ->whereMonth('sale_date', $date->month)
                ->whereYear('sale_date', $date->year)
                ->sum('total');

            $ventasMensuales[] = [
                'mes'   => $date->translatedFormat('M Y'),
                'total' => (float) $total,
            ];
        }

        // ─── Distribución de estatus del inventario ──────────────────
        // Agrupa los inventarios por estatus (disponible, vendido, etc.)
        // Solo considera productos que pertenecen a la empresa
        $estatusInventario = Inventory::join('products', 'inventories.product_id', '=', 'products.id')
            ->where('products.company_id', $companyId)
            ->select('inventories.estatus', DB::raw('COUNT(*) as cantidad'))
            ->groupBy('inventories.estatus')
            ->get()
            ->map(function ($item) {
                return [
                    'estatus'  => $item->estatus,
                    'cantidad' => (int) $item->cantidad,
                ];
            });

        // ─── Top 5 productos más vendidos ────────────────────────────
        // Une sale_items con sales y products para sumar la cantidad vendida
        // y ordenar descendientemente, limitando a 5 resultados
        $topProductos = SaleItem::join('sales', 'sale_items.sale_id', '=', 'sales.id')
            ->join('products', 'sale_items.product_id', '=', 'products.id')
            ->where('sales.company_id', $companyId)
            ->select('products.nombre', DB::raw('SUM(sale_items.qty) as total_vendido'))
            ->groupBy('products.id', 'products.nombre')
            ->orderByDesc('total_vendido')
            ->limit(5)
            ->get()
            ->map(function ($item) {
                return [
                    'nombre'       => $item->nombre,
                    'total_vendido' => (int) $item->total_vendido,
                ];
            });

        return response()->json([
            'cards' => [
                'ventas_mes'      => (float) $ventasMes,
                'total_clientes'  => $totalClientes,
                'total_productos' => $totalProductos,
                'cotizaciones_mes' => $cotizacionesMes,
            ],
            'ventas_mensuales'   => $ventasMensuales,
            'estatus_inventario' => $estatusInventario,
            'top_productos'      => $topProductos,
        ]);
    }
}
