<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /** Crea la tabla de puestos de la feria. */
    public function up(): void
    {
        Schema::create('puestos', function (Blueprint $table) {
            $table->id();
            $table->string('nombre', 80);
            $table->string('telefono', 20)->nullable();
            $table->timestamps();
        });
    }

    /** Elimina la tabla de puestos. */
    public function down(): void
    {
        Schema::dropIfExists('puestos');
    }
};
