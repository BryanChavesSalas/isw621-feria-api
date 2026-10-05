<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /** Crea la tabla de cosechas con sus reglas como restricciones de la base. */
    public function up(): void
    {
        Schema::create('cosechas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('puesto_id')->constrained()->cascadeOnDelete();
            $table->string('cultivo', 60);
            $table->integer('kilos_estimados');
            $table->string('temporada', 20);
            $table->boolean('confirmada')->default(true);
            $table->timestamps();

            $table->unique(['puesto_id', 'cultivo']);
        });

        DB::statement('ALTER TABLE cosechas ADD CONSTRAINT cosechas_kilos_estimados_check CHECK (kilos_estimados BETWEEN 1 AND 5000)');
        DB::statement("ALTER TABLE cosechas ADD CONSTRAINT cosechas_temporada_check CHECK (temporada IN ('seca', 'lluviosa', 'todo_el_ano'))");
    }

    /** Elimina la tabla de cosechas. */
    public function down(): void
    {
        Schema::dropIfExists('cosechas');
    }
};
