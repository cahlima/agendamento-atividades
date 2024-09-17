<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Atividades extends Model
{
    protected $table = 'atividades';

    protected $fillable = [
        'atividade', 'instrutor_id', 'data_inicio', 'data_fim', 'hora', 'local', 'dias'
    ];

    protected $dates = ['data_inicio', 'data_fim'];

    /**
     * Relação com o professor (usuário).
     */
    public function instrutor()
    {
        return $this->belongsTo(Usuarios::class, 'instrutor_id');
    }

    /**
     * Relação com os alunos matriculados na atividade.
     */

    public function alunos()
{
    return $this->belongsToMany(Usuarios::class, 'matriculas', 'atividade_id', 'usuario_id')
                ->withPivot('tipo_id')
                ->wherePivot('tipo_id', 2); // Certifique-se de que tipo_id = 2 é para alunos
}


    /**
     * Usuários matriculados na atividade (incluindo alunos e professores).
     */
    public function usuariosMatriculados()
    {
        return $this->belongsToMany(Usuarios::class, 'matriculas', 'atividade_id', 'usuario_id');
    }

    /**
     * Relação com os horários da atividade.
     */
    public function horarios()
    {
        return $this->hasMany(Horarios::class, 'atividade_id');
    }

    /**
     * Verifica se a atividade ocorre no dia da semana atual.
     *
     * @return bool
     */
    public function ocorreHoje()
    {
        $diasSemana = explode(',', $this->dias);
        $diaSemanaHoje = strtolower(Carbon::now()->locale('pt_BR')->isoFormat('dddd')); // Exemplo: 'segunda'

        // Verifica se o dia da semana atual está nos dias definidos para a atividade
        return in_array($diaSemanaHoje, $diasSemana);
    }
}
