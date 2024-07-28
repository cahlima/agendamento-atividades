<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Atividades extends Model
{
    protected $table = 'atividades';

    protected $fillable = [
        'atividade', 'instrutor', 'instrutor_id', 'data_inicio', 'data_fim', 'hora', 'local', 'dias'
    ];

    protected $dates = ['data_inicio', 'data_fim'];

    // Relação com o professor (usuário)
    public function instrutor()
    {
        return $this->belongsTo(Usuarios::class, 'instrutor_id');
    }

    // Relação com os alunos matriculados na atividade
    public function alunos()
    {
        return $this->belongsToMany(Usuarios::class, 'matriculas', 'atividade_id', 'usuario_id')
                    ->wherePivot('tipo_id', 3);  // Confirme o tipo_id correto para alunos
    }

    // Usuários matriculados na atividade (incluindo alunos e professores)
    public function usuariosMatriculados()
    {
        return $this->belongsToMany(Usuarios::class, 'matriculas', 'atividade_id', 'usuario_id');
    }

    // Relação com os horários da atividade
    public function horarios()
    {
        return $this->hasMany(Horarios::class, 'atividade_id'); // Ajuste conforme necessário, certifique-se de que há um modelo Horarios
    }
}
