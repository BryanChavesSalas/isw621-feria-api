<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('inspecciones', function (Blueprint $table) {
            $table->id();
            $table->foreignId('puesto_id')->constrained()->cascadeOnDelete();
            $table->string('acta', 20);
            $table->integer('puntaje');
            $table->string('resultado', 20);
            $table->boolean('publicada')->default(true);
            $table->unique(['puesto_id', 'acta']);
            $table->timestamps();
        });
        DB::statement('ALTER TABLE inspecciones ADD CONSTRAINT inspecciones_puntaje_check CHECK (puntaje BETWEEN 0 AND 
        100)');
        DB::statement("ALTER TABLE inspecciones ADD CONSTRAINT inspecciones_resultado_check CHECK (resultado IN 
        ('aprobada', 'con_observaciones', 'rechazada'))");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('inspecciones');
    }
};
