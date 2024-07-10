<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddProfessorIdToAtividadesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('atividades', function (Blueprint $table) {
            // Adiciona a coluna professor_id
            $table->unsignedBigInteger('professor_id')->nullable()->after('id');
            // Define a chave estrangeira
            $table->foreign('professor_id')->references('id')->on('professores')->onDelete('set null');
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
            // Remove a chave estrangeira primeiro
            $table->dropForeign(['professor_id']);
            // Remove a coluna
            $table->dropColumn('professor_id');
        });
    }
}
