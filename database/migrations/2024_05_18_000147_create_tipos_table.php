<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class CreateTiposTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tipos', function (Blueprint $table) {
            $table->id(); // Chave primária
            $table->string('nome', 255)->unique(); // Nome do tipo com restrição de unicidade
            $table->timestamps(); // Campos created_at e updated_at
        });

        // Inserindo tipos padrão (Aluno e Professor)
        DB::table('tipos')->insert([
            ['nome' => 'Aluno'],
            ['nome' => 'Professor'],
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tipos');
    }
}
