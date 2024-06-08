<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Atividades extends Model
{
    protected $table = 'atividades';

    protected $fillable = ['nome', 'descricao', 'data_inicio', 'data_termino'];

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
    public function atividadesIndex()
    {
     return $this->belongsToAMny(Atividades::class,
     'matriculas', 'usuario_id', 'atividade_id');
    }
}
