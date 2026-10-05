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
        Schema::create('certificaciones', function (Blueprint $table) {
            $table->id();
            $table->foreignId('puesto_id')->constrained()->cascadeOnDelete();
            $table->string('nombre', 80);
            $table->integer('vigencia_meses');
            $table->string('tipo', 20);
            $table->boolean('verificada')->default(true);
            $table->timestamps();
            $table->unique(['puesto_id', 'nombre']);
        });

        DB::statement('ALTER TABLE certificaciones ADD CONSTRAINT certificaciones_vigencia_meses_check CHECK (vigencia_meses BETWEEN 1 AND 36)');
        DB::statement("ALTER TABLE certificaciones ADD CONSTRAINT certificaciones_tipo_check CHECK (tipo IN ('organico', 'buenas_practicas', 'comercio_justo'))");

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('certificaciones');
    }
};
