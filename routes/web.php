<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\SalesController;
use App\Http\Controllers\PosController;
use App\Http\Controllers\InventoryController;
use App\Http\Controllers\ProviderController;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

/*
|--------------------------------------------------------------------------
| Rutas públicas (sin autenticación)
|--------------------------------------------------------------------------
*/
Route::get('/login', function () {
    return view('template.auth.login');
})->name('login');

Route::get('/register', function() {
    return view('template.auth.register');
})->name('register');

/*
|--------------------------------------------------------------------------
| Rutas protegidas (requieren JWT por cookie)
|--------------------------------------------------------------------------
*/
Route::middleware(['jwt.auth'])->group(function () {

    Route::get('/', function () {
        return view('template.home');
    })->name('home');

    // Clientes
    Route::get('/clients', function () {
        return view('template.clients.index', ['clientes' => []]);
    })->name('clients');

    Route::get('/create-clients', function () {
        return view('template.clients.create-clients');
    })->name('create-clients');

    // Productos
    Route::get('/products', function () {
        return view('template.products.index');
    })->name('products');

    Route::get('/create-products', function () {
        return view('template.products.create-products');
    })->name('create-products');

    // Ventas
    Route::get("/venta", [SalesController::class, 'index'])->name('create-venta');
    Route::get('/sales/create-sale', [SalesController::class, 'index'])->name('sales.create');
    Route::get('/sales/quotationPDF/{id}', [SalesController::class, 'generatePDF']);

    // Cotizaciones
    Route::get('/crear-cotizacion', function () {
        return view('template.sales.quotation');
    })->name('create-quotation');

    Route::get('/cotizacion', function () {
        return view('template.sales.viewQuotation');
    })->name('quotation');

    // POS
    Route::get('/pos', [PosController::class, 'index']);
    Route::get('/buscar-producto', [PosController::class, 'buscar']);

    // Proveedores
    Route::get("/providers", [ProviderController::class, 'index'])->name('providers');
    Route::post('/leer-pdf', [ProviderController::class, 'leerPdf']);

    // Inventario
    Route::get("/inventory", [InventoryController::class, 'index'])->name('inventario');

    // Usuarios
    Route::get('/crear-usuario', function() {
        return view('template.users.create-users');
    })->name('create-users');

    Route::get('/users', function(){
        return view('template.users.index');
    })->name('users');
});
