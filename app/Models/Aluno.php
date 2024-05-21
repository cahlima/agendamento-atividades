<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Aluno extends Model
{
    use HasFactory;

    protected $fillable = [
        'nome',
        'sobrenome',
        // Adicione outros campos necessários
    ];

    public function matriculas()
{
    return $this->hasMany(Matricula::class);
}
}
