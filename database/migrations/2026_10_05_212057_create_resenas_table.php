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
        Schema::create('resenas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('puesto_id')->constrained()->cascadeOnDelete();
            $table->string('autor', 40);
            $table->integer('calificacion');
            $table->string('canal', 20);
            $table->boolean('visible')->default(true);
            $table->timestamps();
            $table->unique(['puesto_id', 'autor']);
        });

        DB::statement(
            'ALTER TABLE resenas
            ADD CONSTRAINT resenas_calificacion_check
            CHECK (calificacion BETWEEN 1 AND 5)'
        );

        DB::statement(
            "ALTER TABLE resenas
            ADD CONSTRAINT resenas_canal_check
            CHECK (canal IN ('presencial', 'whatsapp', 'web'))"
        );
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('resenas');
    }
};
