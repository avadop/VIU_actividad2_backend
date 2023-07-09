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
        Schema::create('citas', function (Blueprint $table) {
            $table->increments('id_cita');
            $table->time('hora');
            $table->date('fecha');
            $table->enum('modalidad_cita', ['presencial', 'online', 'a_domicilio']);
            $table->enum('tipo_cita',['consulta_general', 'vacunacion', 'cirugia', 'analitica', 'peluqueria']);
            $table->integer('id_clinica')->unsigned();
            $table->integer('num_chip')->unsigned();
            $table->foreign('id_clinica')->references('id_clinica')->on('clinicas')->onDelete('restrict')->onUpdate('restrict');
            $table->foreign('num_chip')->references('num_chip')->on('mascotas')->onDelete('cascade')->onUpdate('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('citas');
    }
};
