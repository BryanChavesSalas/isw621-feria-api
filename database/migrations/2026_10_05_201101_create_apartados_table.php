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
        Schema::create('apartados', function (Blueprint $table) {
            $table->id();
            $table->foreignId('puesto_id')->constrained()->cascadeOnDelete();
            $table->string('cliente', 60);
            $table->integer('cantidad');
            $table->string('entrega', 20);
            $table->boolean('confirmado')->default(true);
            $table->timestamps();

            $table->unique(['puesto_id', 'cliente']);
        });

        DB::statement('ALTER TABLE apartados ADD CONSTRAINT apartados_cantidad_check CHECK (cantidad BETWEEN 1 AND 
        50)');
        DB::statement("ALTER TABLE apartados ADD CONSTRAINT apartados_entrega_check CHECK (entrega IN ('sabado_manana', 
        'sabado_tarde', 'domingo_manana'))");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('apartados');
    }
};
