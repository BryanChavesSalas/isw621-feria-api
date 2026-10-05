<?php

use App\Http\Controllers\Api\V1\ApartadoController;
use Illuminate\Support\Facades\Route;

// M00 · Degustaciones del puesto: /api/v1/puestos/{puesto}/degustaciones
Route::controller(ApartadoController::class)
    ->prefix('puestos/{puesto}/apartados')
    ->name('puestos.apartados.')
    ->scopeBindings()
    ->group(function () {
        Route::get('/', 'index')->name('index');
        Route::post('/', 'store')->name('store');
        Route::get('{apartado}', 'show')->name('show');
        Route::patch('{apartado}', 'update')->name('update');
        Route::delete('{apartado}', 'destroy')->name('destroy');
    });
