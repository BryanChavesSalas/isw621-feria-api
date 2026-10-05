<?php

use App\Http\Controllers\Api\V1\ColaboradorController;
use Illuminate\Support\Facades\Route;

// M10 · Colaboradores del puesto: /api/v1/puestos/{puesto}/colaboradores
Route::controller(ColaboradorController::class)
    ->prefix('puestos/{puesto}/colaboradores')
    ->name('puestos.colaboradores.')
    ->scopeBindings()
    ->group(function () {
        Route::get('/', 'index')->name('index');
        Route::post('/', 'store')->name('store');
        Route::get('{colaborador}', 'show')->name('show');
        Route::patch('{colaborador}', 'update')->name('update');
        Route::delete('{colaborador}', 'destroy')->name('destroy');
    });
