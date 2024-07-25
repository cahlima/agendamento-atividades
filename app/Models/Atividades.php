<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Atividades extends Model
{
    protected $table = 'atividades';

    protected $fillable = [
        'titulo', 'descricao', 'professor_id', 'data', 'hora', 'local'
    ];

    protected $dates = ['data', 'hora'];

    // Relação com o professor
    public function professor()
    {
        return $this->belongsTo(Usuarios::class, 'professor_id');
    }

    // Relação com os alunos matriculados na atividade
    public function alunos()
    {
        return $this->belongsToMany(Usuarios::class, 'matriculas', 'atividade_id', 'usuario_id')
                    ->wherePivot('tipo_id', 3);  // Confirme o tipo_id correto para alunos
    }

    // Pode ser removido se não for mais usado
    public function professores()
    {
        return $this->belongsToMany(Usuarios::class, 'matriculas', 'atividade_id', 'usuario_id')
                    ->wherePivot('tipo_id', 2);  // Confirme o tipo_id correto para professores
    }

    // Usuários matriculados na atividade (incluindo alunos e professores)
    public function usuariosMatriculados()
    {
        return $this->belongsToMany(Usuarios::class, 'matriculas', 'atividade_id', 'usuario_id');
    }

    // Relação com os horários da atividade
    public function horarios()
    {
        return $this->hasMany(Horarios::class); // Ajuste conforme necessário, certifique-se de que há um modelo Horarios
    }
}
