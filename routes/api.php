<?php

use App\Http\Controllers\Api\V1\PuestoController;
use Illuminate\Support\Facades\Route;

Route::name('v1.')->group(function () {
    Route::get('puestos', [PuestoController::class, 'index'])->name('puestos.index');
    Route::get('puestos/{puesto}', [PuestoController::class, 'show'])->name('puestos.show');

    // Cada recurso de la feria tiene su propio archivo de rutas en routes/api/v1/.
    foreach (glob(__DIR__.'/api/v1/*.php') ?: [] as $archivo) {
        require $archivo;
    }
});
