<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UsuariosTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('usuarios')->insert([
            [
                'tipo_id' => 1,
                'nome' => 'Administrador',
                'sobrenome' => 'SobrenomeAdm',
                'login' => 'admin',
                'senha' => Hash::make('senha123'),
                'email' => 'admin@example.com',
                'data_nascimento' => '1980-01-01',
                'telefone' => '123456789',
                'remember_token' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'tipo_id' => 3,
                'nome' => 'Aluno1',
                'sobrenome' => 'SobrenomeAlun1',
                'login' => 'aluno1',
                'senha' => Hash::make('senha123'),
                'email' => 'aluno1@example.com',
                'data_nascimento' => '1990-01-01',
                'telefone' => '123456789',
                'remember_token' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'tipo_id' => 3,
                'nome' => 'Aluno2',
                'sobrenome' => 'SobrenomeAlun2',
                'login' => 'aluno2',
                'senha' => Hash::make('senha123'),
                'email' => 'aluno2@example.com',
                'data_nascimento' => '1990-01-02',
                'telefone' => '123456789',
                'remember_token' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'tipo_id' => 3,
                'nome' => 'Aluno3',
                'sobrenome' => 'SobrenomeAlun3',
                'login' => 'aluno3',
                'senha' => Hash::make('senha123'),
                'email' => 'aluno3@example.com',
                'data_nascimento' => '1990-01-03',
                'telefone' => '123456789',
                'remember_token' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'tipo_id' => 2,
                'nome' => 'Professor1',
                'sobrenome' => 'SobrenomeProf1',
                'login' => 'professor1',
                'senha' => Hash::make('senha123'),
                'email' => 'professor1@example.com',
                'data_nascimento' => '1985-01-01',
                'telefone' => '123456789',
                'remember_token' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'tipo_id' => 2,
                'nome' => 'Professor2',
                'sobrenome' => 'SobrenomeProf2',
                'login' => 'professor2',
                'senha' => Hash::make('senha123'),
                'email' => 'professor2@example.com',
                'data_nascimento' => '1985-01-02',
                'telefone' => '123456789',
                'remember_token' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
