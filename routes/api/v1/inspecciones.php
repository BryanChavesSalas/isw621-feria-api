<?php

use App\Http\Controllers\Api\V1\InspeccionController;
use Illuminate\Support\Facades\Route;

// M00 · Degustaciones del puesto: /api/v1/puestos/{puesto}/degustaciones
Route::controller(InspeccionController::class)
    ->prefix('puestos/{puesto}/inspecciones')
    ->name('puestos.inspecciones.')
    ->scopeBindings()
    ->group(function () {
        Route::get('/', 'index')->name('index');
        Route::post('/', 'store')->name('store');
        Route::get('{inspeccion}', 'show')->name('show');
        Route::patch('{inspeccion}', 'update')->name('update');
        Route::delete('{inspeccion}', 'destroy')->name('destroy');

    });
