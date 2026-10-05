<?php

use App\Http\Controllers\Api\V1\CertificacionController;
use Illuminate\Support\Facades\Route;

// M06 · Certificaciones del puesto: /api/v1/puestos/{puesto}/certificaciones
Route::controller(CertificacionController::class)
    ->prefix('puestos/{puesto}/certificaciones')
    ->name('puestos.certificaciones.')
    ->scopeBindings()
    ->group(function () {
        Route::get('/', 'index')->name('index');
        Route::post('/', 'store')->name('store');
        Route::get('{certificacion}', 'show')->name('show');
        Route::patch('{certificacion}', 'update')->name('update');
        Route::delete('{certificacion}', 'destroy')->name('destroy');
    });
