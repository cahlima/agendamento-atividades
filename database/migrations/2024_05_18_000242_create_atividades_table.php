<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAtividadesTable extends Migration
{
    public function up()
    {
        Schema::create('atividades', function (Blueprint $table) {
            $table->id();
            $table->string('atividade');
            $table->date('data_inicio');
            $table->date('data_fim');
            $table->time('hora');
            $table->unsignedBigInteger('instrutor_id');
            $table->string('instrutor'); // Campo para armazenar o nome do instrutor
            $table->string('local');
            $table->string('dias'); // Armazenar os dias como uma string separada por vírgulas
            $table->timestamps();

            $table->foreign('instrutor_id')->references('id')->on('usuarios')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('atividades');
    }
}
