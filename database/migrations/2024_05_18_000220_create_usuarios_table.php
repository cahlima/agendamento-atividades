<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsuariosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('usuarios', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('tipo_id');
            $table->string('nome');
            $table->string('sobrenome');
            $table->string('login');
            $table->string('senha');
            $table->string('email');
            $table->date('data_nascimento');
            $table->string('telefone');
            $table->string('remember_token')->nullable();
            $table->timestamps();

            // Definindo a chave estrangeira
            $table->foreign('tipo_id')->references('id')->on('tipos'); // Ajustar para a tabela correta
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('usuarios');
    }
}
