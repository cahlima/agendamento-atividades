<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Aluno extends Model
{
    protected $table = 'alunos';

    public function usuario()
    {
        return $this->belongsTo(Usuarios::class);
    }

    public function atividades()
    {
        return $this->belongsToMany(Atividades::class, 'matriculas', 'aluno_id', 'atividade_id');
    }

 
}
