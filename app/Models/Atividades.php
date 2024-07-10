<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Atividades extends Model
{
    protected $table = 'atividades';

    // Atualizado para incluir 'professor_id' e remover campos desatualizados
    protected $fillable = [
        'titulo', 'descricao', 'professor_id', 'data', 'hora', 'local'
    ];

    // 'data' e 'hora' como instâncias de Carbon
    protected $dates = ['data', 'hora'];

    // Relação com a tabela de professores (inicialmente Usuarios pode ser ajustado para Professores se aplicável)
    public function professor()
    {
        // Asegure-se de que 'Professores' é o modelo correto se houver um específico
        return $this->belongsTo(Usuarios::class, 'professor_id');
    }

    // Alunos matriculados na atividade
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

    // Usuários matriculados na atividade
    public function usuariosMatriculados()
    {
        return $this->belongsToMany(Usuarios::class, 'matriculas', 'atividade_id', 'usuario_id');
    }
}
