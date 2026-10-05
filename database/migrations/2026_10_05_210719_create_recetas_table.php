<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('recetas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('puesto_id')->constrained()->cascadeOnDelete();
            $table->string('titulo', 80);
            $table->integer('minutos');
            $table->string('dificultad', 20);
            $table->boolean('publicada')->default(true);
            $table->timestamps();

            $table->unique(['puesto_id', 'titulo']);
        });

        DB::statement('ALTER TABLE recetas ADD CONSTRAINT recetas_minutos_check CHECK (minutos BETWEEN 5 AND 240)');
        DB::statement("ALTER TABLE recetas ADD CONSTRAINT recetas_dificultad_check CHECK (dificultad IN ('facil', 'media', 'dificil'))");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('recetas');
    }
};
