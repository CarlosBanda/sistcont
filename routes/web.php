<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ClientController;

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
/*Route::get('/clients', function () {
    return view('template.clients.index');
})->name('clients');

<<<<<<< HEAD
=======
Route::get('/create-clients', function () {
    return view('template.clients.create-clients');
})->name('create-clients');

>>>>>>> LR-Login
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


