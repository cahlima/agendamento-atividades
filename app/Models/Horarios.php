<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Horarios extends Model
{
    protected $table = 'horarios';

    protected $fillable = [
        'atividade_id', 'hora'
    ];

    // Relacionamento com a tabela Atividades
    public function atividade()
    {
        return $this->belongsTo(Atividades::class, 'atividade_id');
    }
}


