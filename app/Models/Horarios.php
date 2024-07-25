<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Horarios extends Model
{
    protected $fillable = [
        'atividade_id', 'hora'
    ];

    public function atividade()
    {
        return $this->belongsTo(Atividades::class, 'atividade_id');
    }
}

