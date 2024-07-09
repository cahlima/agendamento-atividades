<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TipoUsuariosTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('tipo_usuarios')->insert([
            ['id' => 1, 'nome' => 'Administrador'],
            ['id' => 2, 'nome' => 'Professor'],
            ['id' => 3, 'nome' => 'Aluno'],
        ]);
    }
}
