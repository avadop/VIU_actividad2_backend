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
        Schema::create('compras', function (Blueprint $table) {
            $table->unsignedInteger('id_producto');
            $table->string('dni', 9);
            $table->string('compras_dni', 9)->nullable();
            $table->date('fecha_compra');
            $table->primary(['id_producto', 'dni']);
            $table->foreign('compras_dni')->references('dni')->on('clientes')->onDelete('set null')->onUpdate('cascade');
            $table->foreign('id_producto')->references('id_producto')->on('productos')->onDelete('cascade')->onUpdate('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('compras');
    }
};