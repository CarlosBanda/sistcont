<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;

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

/*RUTAS PARA VISTAS AUTENTICACION*/    
Route::get('/login', function () {
    return view('template.auth.login');
})->name('login');

/*RUTAS PARA VISTAS CLIENTES*/
Route::get('/clients', function () {
    return view('template.clients.index');
})->name('clients');


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


/*RUTAS PARA VISTAS CLIENTES*/ /* RUTAS PROTEGIDAS  */
Route::middleware('jwt.auth')->group(function() {
    
    Route::get('/', function () {
        return view('template.index');
    });
    
    Route::get('/clients', function () {
        return view('template.clients.index');
    })->name('clients');;

    Route::get('/create-clients', function () {
        return view('template.clients.create-clients');
    })->name('create-clients');


    Route::get('/create-sales', function () {
        return view('template.sales.create-sale');
    })->name('create-sales');
    Route::get('/clients', [ClientController::class, 'getClients'])->name('clients');; // ✅ correcta

    Route::get('/create-clients', function () {
        return view('template.clients.create-clients');
    })->name('create-clients');


});
