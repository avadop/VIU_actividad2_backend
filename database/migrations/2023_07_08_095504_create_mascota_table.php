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
        Schema::create('mascota', function (Blueprint $table) {
            $table->integer('num_chip')->unsigned();
            $table->string('nombre_mascota');
            $table->integer('edad');
            $table->char('sexo');
            $table->string('especie');
            $table->text('vacunas');
            $table->json('informes_de_mascota');
            $table->text('historial_clinico')->nullable();
            $table->string('dni', 9);
            $table->primary('num_chip');
            $table->foreign('dni')->references('dni')->on('cliente')->onDelete('cascade')->onUpdate('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('mascota');
    }
};
