<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TiposTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('tipos')->insert([
            ['nome' => 'Administrador'],
            ['nome' => 'Professor'],
            ['nome' => 'Aluno'],
        ]);
    }
}
