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
            $table->id(); // Chave primária
            $table->foreignId('tipo_id')->constrained('tipos')->onDelete('cascade');
            $table->string('nome');
            $table->string('sobrenome');
            $table->string('login')->unique();
            $table->string('senha');
            $table->string('email')->unique();
            $table->date('data_nascimento');
            $table->string('telefone');
            $table->rememberToken(); // Adicionando campo para remember token
            $table->timestamps(); // Campos created_at e updated_at
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
