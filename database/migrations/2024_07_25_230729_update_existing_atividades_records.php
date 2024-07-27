<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateColumnsToNotNullInAtividadesTable extends Migration
{
    public function up()
    {
        Schema::table('atividades', function (Blueprint $table) {
            $table->date('data_inicio')->nullable(false)->change();
            $table->date('data_fim')->nullable(false)->change();
            $table->string('dias')->nullable(false)->change();
        });
    }

    public function down()
    {
        Schema::table('atividades', function (Blueprint $table) {
            $table->date('data_inicio')->nullable()->change();
            $table->date('data_fim')->nullable()->change();
            $table->string('dias')->nullable()->change();
        });
    }
}
