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
        Schema::create('ofertas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('puesto_id')->constrained()->cascadeOnDelete();
            $table->string('titulo', 60);
            $table->integer('descuento_porcentaje');
            $table->string('tipo', 20);
            $table->boolean('vigente')->default(true);
            $table->timestamps();
            $table->unique(['puesto_id', 'titulo']);
            

        });
        DB::statement('ALTER TABLE ofertas ADD CONSTRAINT ofertas_descuento_porcentaje_check CHECK (descuento_porcentaje BETWEEN 5 AND 50)');
        DB::statement("ALTER TABLE ofertas ADD CONSTRAINT ofertas_tipo_check CHECK (tipo IN ('por_unidad', 'por_kilo', 'combo'))");

        
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ofertas');
    }
};
