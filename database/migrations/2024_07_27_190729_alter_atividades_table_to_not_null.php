<?php

// database/migrations/xxxx_xx_xx_xxxxxx_alter_atividades_table_to_not_null.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterAtividadesTableToNotNull extends Migration
{
    public function up()
    {
        Schema::table('atividades', function (Blueprint $table) {
            $table->string('atividade')->nullable(false)->change();
            $table->date('data_inicio')->nullable(false)->change();
            $table->date('data_fim')->nullable(false)->change();
            $table->time('hora')->nullable(false)->change();
            $table->string('instrutor')->nullable(false)->change();
            $table->string('local')->nullable(false)->change();
            $table->string('dias')->nullable(false)->change();
        });
    }

    public function down()
    {
        Schema::table('atividades', function (Blueprint $table) {
            $table->string('atividade')->nullable()->change();
            $table->date('data_inicio')->nullable()->change();
            $table->date('data_fim')->nullable()->change();
            $table->time('hora')->nullable()->change();
            $table->string('instrutor')->nullable()->change();
            $table->string('local')->nullable()->change();
            $table->string('dias')->nullable()->change();
        });
    }
}
