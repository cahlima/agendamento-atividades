<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Usuarios;

class InstrutoresSeeder extends Seeder
{
    public function run()
    {
        $instrutores = [
            [
                'nome' => 'Lucas',
                'sobrenome' => 'Profe',
                'tipo_id' => 3,
                'email' => 'lucas@exemplo.com',
                'login' => 'lucasprofe',
                'senha' => bcrypt('senha123'),
                'data_nascimento' => '1990-01-01',
                'telefone' => '(63) 99111-1111'
            ],
            [
                'nome' => 'Joana',
                'sobrenome' => 'Profe',
                'tipo_id' => 3,
                'email' => 'joana@exemplo.com',
                'login' => 'joanaprofe',
                'senha' => bcrypt('senha123'),
                'data_nascimento' => '1989-02-01',
                'telefone' => '(63) 99222-2222'
            ],
            [
                'nome' => 'Juarez',
                'sobrenome' => 'Teste',
                'tipo_id' => 3,
                'email' => 'juarez@exemplo.com',
                'login' => 'juarexteste',
                'senha' => bcrypt('senha123'),
                'data_nascimento' => '1980-05-12',
                'telefone' => '(63) 99333-3333'
            ],
            [
                'nome' => 'Simone',
                'sobrenome' => 'Profe',
                'tipo_id' => 3,
                'email' => 'simone@exemplo.com',
                'login' => 'simoneprofe',
                'senha' => bcrypt('senha123'),
                'data_nascimento' => '1992-03-11',
                'telefone' => '(63) 99444-4444'
            ],
            [
                'nome' => 'Ana Paula',
                'sobrenome' => 'de Lima',
                'tipo_id' => 3,
                'email' => 'anapaula@exemplo.com',
                'login' => 'anapauladelima',
                'senha' => bcrypt('senha123'),
                'data_nascimento' => '1995-07-09',
                'telefone' => '(63) 99555-5555'
            ],
            [
                'nome' => 'Carlos',
                'sobrenome' => 'Professor',
                'tipo_id' => 3,
                'email' => 'carlos@exemplo.com',
                'login' => 'carlosprof',
                'senha' => bcrypt('senha123'),
                'data_nascimento' => '1985-11-23',
                'telefone' => '(63) 99666-6666'
            ],
            [
                'nome' => 'Mariana',
                'sobrenome' => 'Instructora',
                'tipo_id' => 3,
                'email' => 'mariana@exemplo.com',
                'login' => 'marianainstructora',
                'senha' => bcrypt('senha123'),
                'data_nascimento' => '1993-09-15',
                'telefone' => '(63) 99777-7777'
            ],
            [
                'nome' => 'Fernando',
                'sobrenome' => 'Instrutor',
                'tipo_id' => 3,
                'email' => 'fernando@exemplo.com',
                'login' => 'fernandoinstrutor',
                'senha' => bcrypt('senha123'),
                'data_nascimento' => '1979-04-18',
                'telefone' => '(63) 99888-8888'
            ],
        ];

        foreach ($instrutores as $instrutor) {
            Usuarios::create($instrutor);
        }
    }
}

