<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Usuarios;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run()
    {
        Usuarios::create([
            'name' => 'Admin',
            'email' => 'admin@example.com',
            'password' => Hash::make('password'),
            'role' => 'admin',
        ]);

        Usuarios::create([
            'name' => 'Aluno',
            'email' => 'aluno@example.com',
            'password' => Hash::make('password'),
            'role' => 'aluno',
        ]);

        Usuarios::create([
            'name' => 'Professor',
            'email' => 'professor@example.com',
            'password' => Hash::make('password'),
            'role' => 'professor',
        ]);
    }
}
