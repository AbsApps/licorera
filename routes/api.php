<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// Laravel 8 cambio la configuracion de sus namespace para las rutas por eso ahora hay que importarlas
use App\Http\Controllers\ClientController;
use App\Http\Controllers\ProductoController;
use App\Http\Controllers\ExchageRateController;
use App\Http\Controllers\InvoiceController;

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


// Route::resource('client', ClientController::class)->names('client');

Route::controller(ClientController::class)->group(function () {

    Route::get('/client', 'index');
    Route::get('/client/search', 'search');
    Route::post('/client/store', 'store');
    Route::put('/client/store', 'update');
    Route::delete('/client/store', 'destroy');
});


Route::controller(ProductoController::class)->group(function () {

    Route::get('/product', 'index');
    Route::post('/product/store', 'store');
    Route::put('/product/store', 'update');
    Route::delete('/product/store', 'destroy');
    Route::get('/product/search', 'search');
});



Route::controller(ExchageRateController::class)->group(function () {

    Route::get('/exchage', 'index');
    Route::post('/exchage/store', 'store');
    Route::put('/exchage/store', 'update');
    Route::delete('/exchage/store', 'destroy');
});


Route::controller(InvoiceController::class)->group(function () {

    Route::get('/invoice', 'index');
    Route::get('/invoice/detail', 'detail');
    Route::post('/invoice/store', 'store');
    Route::put('/invoice/add', 'update');
    Route::delete('/invoice/store', 'destroy');
});
