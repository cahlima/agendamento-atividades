<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class RemoveDescricaoAndTituloFromAtividadesTable extends Migration
{
    public function up()
    {
        Schema::table('atividades', function (Blueprint $table) {
            $table->dropColumn(['descricao', 'titulo']);
        });
    }

    public function down()
    {
        Schema::table('atividades', function (Blueprint $table) {
            $table->text('descricao')->nullable();
            $table->string('titulo')->nullable();
        });
    }
}

