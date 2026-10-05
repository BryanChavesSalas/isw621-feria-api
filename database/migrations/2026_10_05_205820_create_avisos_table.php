<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('avisos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('puesto_id')->constrained()->cascadeOnDelete();
            $table->string('titulo', 80);
            $table->integer('dias_vigencia');
            $table->string('categoria', 20);
            $table->boolean('activo')->default(true);
            $table->timestamps();
            $table->unique(['puesto_id', 'titulo']);
        });

        DB::statement('ALTER TABLE avisos ADD CONSTRAINT avisos_dias_vigencia_check CHECK (dias_vigencia BETWEEN 1 AND 30)');
        DB::statement("ALTER TABLE avisos ADD CONSTRAINT avisos_categoria_check CHECK (categoria IN ('horario', 'precio', 'producto', 'general'))");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('avisos');
    }
};
