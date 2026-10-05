<?php

use App\Http\Controllers\Api\V1\CosechaController;
use Illuminate\Support\Facades\Route;

// M07 · Cosechas del puesto: /api/v1/puestos/{puesto}/cosechas
Route::controller(CosechaController::class)
    ->prefix('puestos/{puesto}/cosechas')
    ->name('puestos.cosechas.')
    ->scopeBindings()
    ->group(function () {
        Route::get('/', 'index')->name('index');
        Route::post('/', 'store')->name('store');
        Route::get('{cosecha}', 'show')->name('show');
        Route::patch('{cosecha}', 'update')->name('update');
        Route::delete('{cosecha}', 'destroy')->name('destroy');
    });
