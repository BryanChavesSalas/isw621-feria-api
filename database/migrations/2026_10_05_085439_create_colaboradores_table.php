<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /** Crea la tabla de colaboradores con sus reglas como restricciones de la base. */
    public function up(): void
    {
        Schema::create('colaboradores', function (Blueprint $table) {
            $table->id();
            $table->foreignId('puesto_id')->constrained()->cascadeOnDelete();
            $table->string('nombre', 60);
            $table->integer('horas_semanales');
            $table->string('rol', 20);
            $table->boolean('activo')->default(true);
            $table->timestamps();

            $table->unique(['puesto_id', 'nombre']);
        });

        DB::statement('ALTER TABLE colaboradores ADD CONSTRAINT colaboradores_horas_semanales_check CHECK (horas_semanales BETWEEN 4 AND 48)');
        DB::statement("ALTER TABLE colaboradores ADD CONSTRAINT colaboradores_rol_check CHECK (rol IN ('vendedor', 'cajero', 'cargador'))");
    }

    /** Elimina la tabla de colaboradores. */
    public function down(): void
    {
        Schema::dropIfExists('colaboradores');
    }
};
