<?php

namespace Database\Seeders;


use AtividadesSeeder;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        $this->call(TiposTableSeeder::class);
        $this->call(InstrutoresSeeder::class);
        $this->call(AtividadesSeeder::class);
    }
}
