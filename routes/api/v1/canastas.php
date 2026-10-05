<?php

use App\Http\Controllers\Api\V1\CanastaController;
use Illuminate\Support\Facades\Route;

// M00 · Canastas del puesto: /api/v1/puestos/{puesto}/canastas
Route::controller(CanastaController::class)
    ->prefix('puestos/{puesto}/canastas')
    ->name('puestos.canastas.')
    ->scopeBindings()

    ->group(function () {
        Route::get('/', 'index')->name('index');
        Route::post('/', 'store')->name('store');
        Route::get('{canasta}', 'show')->name('show');
        Route::patch('{canasta}', 'update')->name('update');
        Route::delete('{canasta}', 'destroy')->name('destroy');
    });
