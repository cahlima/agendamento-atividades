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
                'senha' => bcrypt('senha123')
            ],
            [
                'nome' => 'Joana',
                'sobrenome' => 'Profe',
                'tipo_id' => 3,
                'email' => 'joana@exemplo.com',
                'login' => 'joanaprofe',
                'senha' => bcrypt('senha123')
            ],
            [
                'nome' => 'Juarez',
                'sobrenome' => 'Teste',
                'tipo_id' => 3,
                'email' => 'juarez@exemplo.com',
                'login' => 'juarexteste',
                'senha' => bcrypt('senha123')
            ],
            [
                'nome' => 'Simone',
                'sobrenome' => 'Profe',
                'tipo_id' => 3,
                'email' => 'simone@exemplo.com',
                'login' => 'simoneprofe',
                'senha' => bcrypt('senha123')
            ],
            [
                'nome' => 'Ana Paula',
                'sobrenome' => 'de Lima',
                'tipo_id' => 3,
                'email' => 'anapaula@exemplo.com',
                'login' => 'anapauladelima',
                'senha' => bcrypt('senha123')
            ],
            [
                'nome' => 'Carlos',
                'sobrenome' => 'Professor',
                'tipo_id' => 3,
                'email' => 'carlos@exemplo.com',
                'login' => 'carlosprof',
                'senha' => bcrypt('senha123')
            ],
            [
                'nome' => 'Mariana',
                'sobrenome' => 'Instructora',
                'tipo_id' => 3,
                'email' => 'mariana@exemplo.com',
                'login' => 'marianainstructora',
                'senha' => bcrypt('senha123')
            ],
            [
                'nome' => 'Fernando',
                'sobrenome' => 'Instrutor',
                'tipo_id' => 3,
                'email' => 'fernando@exemplo.com',
                'login' => 'fernandoinstrutor',
                'senha' => bcrypt('senha123')
            ],
        ];

        foreach ($instrutores as $instrutor) {
            Usuarios::create($instrutor);
        }
    }
}
