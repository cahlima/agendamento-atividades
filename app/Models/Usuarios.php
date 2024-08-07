<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Hash;

class Usuarios extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $table = 'usuarios';
    protected $primaryKey = 'id';
    public $timestamps = true;

    protected $fillable = [
        'tipo_id', 'nome', 'sobrenome', 'login', 'senha', 'email', 'data_nascimento', 'telefone'
    ];

    protected $hidden = ['senha', 'remember_token'];

    public function getAuthPassword()
    {
        return $this->senha;
    }

    public function tipo()
    {
        return $this->belongsTo(Tipos::class, 'tipo_id');
    }

    public function isAdmin()
    {
        return $this->tipo_id == 1;
    }

    public function isProfessor()
    {
        return $this->tipo_id == 3;
    }

    public function isAluno()
    {
        return $this->tipo_id == 2;
    }

    public function professor()
    {
        return $this->hasOne(Professor::class, 'usuario_id');
    }

    public function aluno()
    {
        return $this->hasOne(Aluno::class, 'usuario_id');
    }

    public function atividades()
    {
        return $this->belongsToMany(Atividades::class, 'matriculas', 'usuario_id', 'atividade_id');
    }

    public function atividadesAlocadas()
    {
        return $this->hasMany(Atividades::class, 'instrutor_id', 'id');
    }

    // Método update personalizado
    public function update(array $attributes = [], array $options = [])
    {
        if (isset($attributes['senha'])) {
            $attributes['senha'] = Hash::make($attributes['senha']);
        }

        return parent::update($attributes, $options);
    }
}
