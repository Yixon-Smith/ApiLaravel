<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

//Productos
Route::resource('productos', 'App\Http\Controllers\Api\ProductosController')->names('productos');

//Productos Variaciones
Route::resource('productos-variaciones', 'App\Http\Controllers\Api\ProductosVariacionesController')->names('productos.variaciones');
