<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductosTable extends Migration
{
    public function up()
    {
        Schema::create('productos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('puesto_id')->constrained()->cascadeOnDelete();
            $table->string('nombre', 80);
 $table->integer('precio_colones');
 $table->string('unidad', 20);
 $table->boolean('disponible')->default(true);
 $table->timestamps();
 $table->unique(['puesto_id', 'nombre']);
});


DB::statement('ALTER TABLE productos ADD CONSTRAINT productos_precio_colones_check CHECK (precio_colones BETWEEN
50 AND 200000)');
DB::statement("ALTER TABLE productos ADD CONSTRAINT productos_unidad_check CHECK (unidad IN ('kg', 'unidad',
'manojo', 'docena', 'paquete'))");

    }

}