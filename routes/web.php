<?php

use Illuminate\Support\Facades\Route;

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

Route::get('/', function () {
    return view('template.index');
});

/*RUTAS PARA VISTAS AUTENTICACION*/    
Route::get('/login', function () {
    return view('template.auth.login');
});

/*RUTAS PARA VISTAS CLIENTES*/
Route::get('/clients', function () {
    return view('template.clients.index');
})->name('clients');

Route::get('/create-clients', function () {
    return view('template.clients.create-clients');
})->name('create-clients');