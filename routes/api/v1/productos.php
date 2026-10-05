<?php

use App\Http\Controllers\Api\V1\ProductoController;
use Illuminate\Support\Facades\Route;

// M01 · Productos del puesto: /api/v1/puestos/{puesto}/productos
Route::controller(ProductoController::class)
    ->prefix('puestos/{puesto}/productos')
    ->name('puestos.productos.')
    ->scopeBindings()
    ->group(function () {
        Route::get('/', 'index')->name('index');
        Route::post('/', 'store')->name('store');
        Route::get('{producto}', 'show')->name('show');
        Route::patch('{producto}', 'update')->name('update');
        Route::delete('{producto}', 'destroy')->name('destroy');
    });
