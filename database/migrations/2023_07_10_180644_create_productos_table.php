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
            $table->increments('id_producto');
            $table->string('nombre_producto');
            $table->string('marca');
            $table->string('imagen');
            $table->string('descripcion');
            $table->string('ficha_tecnica');
            $table->float('precio');
            $table->integer('cantidad_disponible');
            $table->enum('tipo_producto', ['comida', 'accesorio', 'medicamento', 'vacunas', 'peluqueria']);
            $table->timestamps();
            $table->softDeletes();
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
