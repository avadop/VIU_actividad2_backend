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
        Schema::create('productos', function (Blueprint $table) {
            $table->integer('id_producto')->unsigned();
            $table->string('nombre_producto');
            $table->string('marca');
            $table->binary('imagen');
            $table->string('descripcion');
            $table->string('ficha_tecnica');
            $table->float('precio');
            $table->integer('cantidad_disponible');
            $table->string('nombre_mascota');
            $table->enum('tipo_producto',['comida', 'accesorios', 'medicamento', 'vacunas', 'peluqueria']);
            $table->primary('id_producto');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('productos');
    }
};
