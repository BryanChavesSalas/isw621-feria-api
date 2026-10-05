<?php

use App\Http\Controllers\Api\V1\AvisoController;
use Illuminate\Support\Facades\Route;

// M09 · Avisos del puesto: /api/v1/puestos/{puesto}/avisos
Route::controller(AvisoController::class)
    ->prefix('puestos/{puesto}/avisos')
    ->name('puestos.avisos.')
    ->scopeBindings()
    ->group(function () {
        Route::get('/', 'index')->name('index');
        Route::post('/', 'store')->name('store');
        Route::get('{aviso}', 'show')->name('show');
        Route::patch('{aviso}', 'update')->name('update');
        Route::delete('{aviso}', 'destroy')->name('destroy');
    });
