<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Atividades extends Model
{
    protected $table = 'atividades';

    protected $fillable = [
        'titulo', 'descricao', 'usuario_id', 'atividade', 'data', 'hora', 'instrutor', 'local'
    ];

    public function alunos()
    {
        return $this->belongsToMany(Usuarios::class, 'matriculas', 'atividade_id', 'usuario_id')
                    ->wherePivot('tipo_id', 3);
    }

    public function professores()
    {
        return $this->belongsToMany(Usuarios::class, 'matriculas', 'atividade_id', 'usuario_id')
                    ->wherePivot('tipo_id', 2);
    }

    public function instrutor()
    {
        return $this->belongsTo(Usuarios::class, 'instrutor');
    }

    public function usuariosMatriculados()
    {
        return $this->belongsToMany(Usuario::class, 'matriculas', 'atividade_id', 'usuario_id');
    }
}
