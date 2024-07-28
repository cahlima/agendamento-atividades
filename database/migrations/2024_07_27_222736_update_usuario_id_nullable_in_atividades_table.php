<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateUsuarioIdNullableInAtividadesTable extends Migration
{
    public function up()
    {
        Schema::table('atividades', function (Blueprint $table) {
            $table->unsignedBigInteger('usuario_id')->nullable()->change();
        });
    }

    public function down()
    {
        Schema::table('atividades', function (Blueprint $table) {
            $table->unsignedBigInteger('usuario_id')->nullable(false)->change();
        });
    }
}
