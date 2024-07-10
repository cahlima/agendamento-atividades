<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnsToAtividadesTable extends Migration
{
    public function up()
    {
        Schema::table('atividades', function (Blueprint $table) {
            $table->string('atividade')->nullable();
            $table->date('data')->nullable();
            $table->time('hora')->nullable();
            $table->string('professor')->nullable();
            $table->string('local')->nullable();
        });
    }

    public function down()
    {
        Schema::table('atividades', function (Blueprint $table) {
            $table->dropColumn(['atividade', 'data', 'hora', 'professor', 'local']);
        });
    }
}

