<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateInstrutorIdForeignKeyInAtividadesTable extends Migration
{
    public function up()
    {
        Schema::table('atividades', function (Blueprint $table) {
            // Se ainda existir a chave estrangeira de professor_id, remova-a
            if (Schema::hasColumn('atividades', 'professor_id')) {
                $table->dropForeign(['professor_id']);
                $table->dropColumn('professor_id');
            }

            // Adicione a coluna instrutor_id se não existir
            if (!Schema::hasColumn('atividades', 'instrutor_id')) {
                $table->unsignedBigInteger('instrutor_id')->nullable();

                // Adicione a chave estrangeira
                $table->foreign('instrutor_id')->references('id')->on('usuarios')->onDelete('cascade');
            }
        });
    }

    public function down()
    {
        Schema::table('atividades', function (Blueprint $table) {
            $table->dropForeign(['instrutor_id']);
            $table->dropColumn('instrutor_id');

            // Adicione a coluna professor_id de volta se necessário
            $table->unsignedBigInteger('professor_id')->nullable();
            $table->foreign('professor_id')->references('id')->on('professores')->onDelete('cascade');
        });
    }
}
