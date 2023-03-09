<?php

use App\Http\Controllers\FacturaController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UsuarioController;
use Illuminate\Support\Facades\Auth;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::resource('usuarios', UsuarioController::class)->names('usuarios')->middleware('auth');
Route::get('usuarios-datatables', [UsuarioController::class, 'usuarioDatatables'])->name('usuarios-datatables');
Route::resource('facturas', FacturaController::class)->names('facturas')->middleware('auth');
Route::get('facturas-datatables', [FacturaController::class, 'facturaDatables'])->name('facturas-datatables');