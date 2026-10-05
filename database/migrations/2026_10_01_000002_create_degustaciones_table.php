<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /** Crea la tabla de degustaciones con sus reglas como restricciones de la base. */
    public function up(): void
    {
        Schema::create('degustaciones', function (Blueprint $table) {
            $table->id();
            $table->foreignId('puesto_id')->constrained()->cascadeOnDelete();
            $table->string('nombre', 60);
            $table->integer('porciones');
            $table->string('jornada', 20);
            $table->boolean('activa')->default(true);
            $table->timestamps();

            $table->unique(['puesto_id', 'nombre']);
        });

        DB::statement('ALTER TABLE degustaciones ADD CONSTRAINT degustaciones_porciones_check CHECK (porciones BETWEEN 10 AND 300)');
        DB::statement("ALTER TABLE degustaciones ADD CONSTRAINT degustaciones_jornada_check CHECK (jornada IN ('manana', 'tarde'))");
    }

    /** Elimina la tabla de degustaciones. */
    public function down(): void
    {
        Schema::dropIfExists('degustaciones');
    }
};
