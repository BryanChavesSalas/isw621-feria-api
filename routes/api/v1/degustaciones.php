<?php

use App\Http\Controllers\Api\V1\DegustacionController;
use Illuminate\Support\Facades\Route;

// M00 · Degustaciones del puesto: /api/v1/puestos/{puesto}/degustaciones
Route::controller(DegustacionController::class)
    ->prefix('puestos/{puesto}/degustaciones')
    ->name('puestos.degustaciones.')
    ->scopeBindings()
    ->group(function () {
        Route::get('/', 'index')->name('index');
        Route::post('/', 'store')->name('store');
        Route::get('{degustacion}', 'show')->name('show');
        Route::patch('{degustacion}', 'update')->name('update');
        Route::delete('{degustacion}', 'destroy')->name('destroy');
    });
