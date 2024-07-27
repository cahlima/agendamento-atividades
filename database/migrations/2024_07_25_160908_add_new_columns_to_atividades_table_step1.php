<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddNewColumnsToAtividadesTableStep1 extends Migration
{
    public function up()
    {
        Schema::table('atividades', function (Blueprint $table) {
            $table->date('data_inicio')->nullable()->after('atividade');
            $table->date('data_fim')->nullable()->after('data_inicio');
            $table->string('dias')->nullable()->after('local');
        });
    }

    public function down()
    {
        Schema::table('atividades', function (Blueprint $table) {
            $table->dropColumn('data_inicio');
            $table->dropColumn('data_fim');
            $table->dropColumn('dias');
        });
    }
}
