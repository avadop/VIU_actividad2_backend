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
        Schema::create('recordatorios', function (Blueprint $table) {
            $table->increments('id_recordatorio');
            $table->date('fecha_inicio');
            $table->integer('periodicidad');
            $table->string('motivo');
            $table->enum('metodo_envio', ['correo_electronico', 'sms']);
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
        Schema::dropIfExists('recordatorios');
    }
};
