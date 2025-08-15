<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateInstrutorIdForeignKeyInAtividadesTable extends Migration
{
    public function up()
    {
        if (env('DB_CONNECTION') === 'sqlite') {
            // SQLite não suporta dropForeign/dropColumn
            Schema::table('atividades', function (Blueprint $table) {
                // Adicione instrutor_id se não existir
                if (!Schema::hasColumn('atividades', 'instrutor_id')) {
                    $table->unsignedBigInteger('instrutor_id')->nullable();
                    // FK será ignorada no SQLite
                }
            });
            return;
        }

        // Para outros DBs (MySQL/Postgres)
        Schema::table('atividades', function (Blueprint $table) {
            if (Schema::hasColumn('atividades', 'professor_id')) {
                $table->dropForeign(['professor_id']);
                $table->dropColumn('professor_id');
            }

            if (!Schema::hasColumn('atividades', 'instrutor_id')) {
                $table->unsignedBigInteger('instrutor_id')->nullable();
                $table->foreign('instrutor_id')->references('id')->on('usuarios')->onDelete('cascade');
            }
        });
    }

    public function down()
    {
        if (env('DB_CONNECTION') === 'sqlite') {
            // SQLite ignora
            return;
        }

        Schema::table('atividades', function (Blueprint $table) {
            $table->dropForeign(['instrutor_id']);
            $table->dropColumn('instrutor_id');

            $table->unsignedBigInteger('professor_id')->nullable();
            $table->foreign('professor_id')->references('id')->on('professores')->onDelete('cascade');
        });
    }
}
