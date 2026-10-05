<?php

use App\Http\Controllers\Api\V1\RecetaController;
use Illuminate\Support\Facades\Route;

Route::controller(RecetaController::class)
    ->prefix('puestos/{puesto}/recetas')
    ->name('puestos.recetas.')
    ->scopeBindings()
    ->group(function () {
        Route::get('/', 'index')->name('index');
        Route::post('/', 'store')->name('store');
        Route::get('{receta}', 'show')->name('show');
        Route::patch('{receta}', 'update')->name('update');
        Route::delete('{receta}', 'destroy')->name('destroy');
    });