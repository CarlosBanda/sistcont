<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProductsController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\SalesController;
use App\Http\Controllers\ProviderController;
use App\Http\Controllers\InventoryController;
use App\Http\Controllers\DashboardController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::post('register', [AuthController::class, 'register']);
Route::post('login', [AuthController::class, 'login']);

Route::middleware(['jwt.auth', 'tenant'])->group(function () {

    // Auth / Usuarios
    Route::get('me', [AuthController::class, 'me']);
    Route::post('logout', [AuthController::class, 'logout']);
    Route::get('users', [AuthController::class, 'getUsers']);
    Route::post('create-users', [AuthController::class, 'create']);

    // Productos
    Route::post('create-products', [ProductsController::class, 'create']);
    Route::get('products', [ProductsController::class, 'getProducts']);
    Route::put('products/{id}', [ProductsController::class, 'update']);

    // Clientes
    Route::post('create-clients', [ClientController::class, 'create']);
    Route::get('clients', [ClientController::class, 'getClients']);
    Route::put('clients/{id}', [ClientController::class, 'update']);

    // Ventas y Cotizaciones
    Route::get('next-folio', [SalesController::class, 'getNextFolio']);
    Route::post('create-quotation', [SalesController::class, 'create']);
    Route::post('create-sale', [SalesController::class, 'storeSale']);
    Route::get('quotations', [SalesController::class, 'getQuotations']);
    Route::get('quotation/{id}', [SalesController::class, 'getQuotation']);

    // Proveedores
    Route::post('create-provider', [ProviderController::class, 'create']);
    Route::put('providers/{id}', [ProviderController::class, 'update']);

    // Inventario
    Route::post('add-product-inventory', [InventoryController::class, 'store']);

    // Dashboard
    Route::get('dashboard-stats', [DashboardController::class, 'stats']);
});
