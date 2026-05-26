<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\SalesController;
use App\Http\Controllers\PosController;
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

  
Route::get('/login', function () {
    return view('template.auth.login');
})->name('login');


Route::get("/clients", [CLientController::class, 'getClients'])->name('clients');

/*Route::get('/clients', function (){
    return view('template.clients.index');
})->name('clients');*/

Route::get('/create-clients', function () {
    return view('template.clients.create-clients');
})->name('create-clients');

Route::get('/register', function() {
    return view('template.auth.register');
})->name('register');

Route::get('/', function () {
    return view('template.index');
});

Route::get('/products', function (){
    return view('template.products.index');
})->name('products');

Route::get('/create-products', function () {
    return view('template.products.create-products');
})->name('create-products');

//crea una nota de venta
Route::get("/venta", [SalesController::class, 'index'])->name('create-venta');


Route::get('/crear-cotizacion', function () {
    return view('template.sales.quotation');
})->name('create-quotation');


//BUSCAR PRODUCTOS
Route::get('/pos', [PosController::class, 'index']);
Route::get('/buscar-producto', [PosController::class, 'buscar']);

// Providers

Route::get("/providers", [ProviderController::class, 'index'])->name('providers');


Route::post('/leer-pdf', [ProviderController::class, 'leerPdf']);


Route::get('/cotizacion', function () {
    return view('template.sales.viewQuotation');
})->name('quotation');

Route::get('/crear-usuario', function() {
    return view('template.users.create-users');
})->name('create-users');

Route::get('/users', function(){
    return view('template.users.index');
})->name('users');
