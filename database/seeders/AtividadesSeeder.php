<?php

namespace Database\Seeders;


use Illuminate\Database\Seeder;
use App\Models\Atividades;
use App\Models\Usuarios;
use Carbon\Carbon;
use Faker\Factory as Faker;

class AtividadesSeeder extends Seeder
{
    public function run()
    {
        $faker = Faker::create('pt_BR');
        $instrutores = Usuarios::where('tipo_id', 3)->pluck('id')->toArray();

        // Lista de atividades que serão criadas
        $atividades = ['Balé', 'Karatê', 'Dança', 'Xadrez', 'Futebol', 'Judô', 'Yoga', 'Zumba', 'Pilates', 'Ginástica'];

        for ($i = 0; $i < 100; $i++) {
            $atividade = $faker->randomElement($atividades);
            $instrutorId = $faker->randomElement($instrutores);
            $dataInicio = Carbon::create(2024, 9, 15);
            $dataFim = Carbon::create(2024, 11, 11);
            $hora = $faker->time('H:i');
            $diasSemana = ['segunda', 'terça', 'quarta', 'quinta', 'sexta', 'sábado', 'domingo'];
            $dias = $faker->randomElements($diasSemana, rand(1, 3)); // Escolher de 1 a 3 dias aleatórios

            Atividades::create([
                'atividade' => $atividade,
                'instrutor_id' => $instrutorId,
                'data_inicio' => $dataInicio,
                'data_fim' => $dataFim,
                'hora' => $hora,
                'local' => $faker->randomElement(['Sala 1', 'Sala 2', 'Estúdio 3', 'Ginásio', 'Quadra']),
                'dias' => implode(',', $dias),
            ]);
        }
    }
}
