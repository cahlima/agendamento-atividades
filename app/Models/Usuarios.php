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

    /**
     * Retorna a senha que deve ser usada para autenticação.
     */
    public function getAuthPassword()
    {
        return $this->senha;
    }

    /**
     * Relacionamento com o modelo Tipos.
     */
    public function tipo()
    {
        return $this->belongsTo(Tipos::class, 'tipo_id');
    }

    /**
     * Verifica se o usuário é um administrador.
     */
    public function isAdmin()
    {
        return $this->tipo_id == 1;
    }

    /**
     * Verifica se o usuário é um professor.
     */
    public function isProfessor()
    {
        return $this->tipo_id == 3;
    }

    /**
     * Verifica se o usuário é um aluno.
     */
    public function isAluno()
    {
        return $this->tipo_id == 2;
    }

    /**
     * Relacionamento com o modelo Professor.
     */
    public function professor()
    {
        return $this->hasOne(Professor::class, 'usuario_id');
    }

    /**
     * Relacionamento com o modelo Aluno.
     */
    public function aluno()
    {
        return $this->hasOne(Aluno::class, 'usuario_id');
    }

    /**
     * Relacionamento com as atividades matriculadas pelo usuário.
     */
    public function atividades()
    {
        return $this->belongsToMany(Atividades::class, 'matriculas', 'usuario_id', 'atividade_id')
                    ->withPivot('status')
                    ->withTimestamps();
    }

    /**
     * Alias para o relacionamento de atividades matriculadas.
     */
    public function atividadesMatriculadas()
    {
        return $this->belongsToMany(Atividades::class, 'matriculas', 'usuario_id', 'atividade_id')
                    ->withPivot('status')
                    ->withTimestamps();
    }

    /**
     * Relacionamento com as atividades alocadas ao usuário (como instrutor).
     */
    public function atividadesAlocadas()
    {
        return $this->hasMany(Atividades::class, 'instrutor_id', 'id');
    }

    /**
     * Mutator para garantir que a senha seja sempre hashada antes de ser salva.
     */
    public function setSenhaAttribute($value)
    {
        if (!empty($value)) {
            $this->attributes['senha'] = Hash::make($value);
        }
    }
}
