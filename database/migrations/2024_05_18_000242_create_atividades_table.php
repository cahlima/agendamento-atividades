<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('atividades', function (Blueprint $table) {
            $table->id();
            $table->string('atividade'); // nome ou título da atividade
            $table->unsignedBigInteger('instrutor_id'); // relação com tabela usuarios
            $table->date('data_inicio')->nullable();
            $table->date('data_fim')->nullable();
            $table->time('hora')->nullable();
            $table->string('local')->nullable();
            $table->string('dias')->nullable(); // dias da semana (ex: "segunda,quarta,sexta")
            $table->timestamps();

            $table->foreign('instrutor_id')->references('id')->on('usuarios')->onDelete('cascade');
        });
    }

    public function down(): void {
        Schema::dropIfExists('atividades');
    }
};