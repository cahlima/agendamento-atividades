<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateAtividadesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('atividades', function (Blueprint $table) {
            // Caso precise adicionar novos campos
            // $table->string('novo_campo')->nullable();

            // Certificando-se de que o campo 'atividade' existe e está correto
            $table->string('atividade')->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('atividades', function (Blueprint $table) {
            // Reverta as mudanças feitas no método up, se necessário
            // $table->dropColumn('novo_campo');

            // Reverter a alteração do campo 'atividade' se necessário
            $table->string('atividade')->change();
        });
    }
}
