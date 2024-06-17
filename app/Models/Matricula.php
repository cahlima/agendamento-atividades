<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Matricula extends Model
{
    protected $table = 'matriculas';

    protected $fillable = ['usuario_id', 'atividade_id', 'status'];

    public function usuario()
    {
        return $this->belongsTo(Usuarios::class);
    }

    public function atividade()
    {
        return $this->belongsTo(Atividades::class);
    }
}
