<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddTipoIdToMatriculasTable extends Migration
{
    public function up()
    {
        Schema::table('matriculas', function (Blueprint $table) {
            $table->unsignedBigInteger('tipo_id')->nullable();
        });
    }

    public function down()
    {
        Schema::table('matriculas', function (Blueprint $table) {
            $table->dropColumn('tipo_id');
        });
    }
}

