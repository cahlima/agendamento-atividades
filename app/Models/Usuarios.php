<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Usuarios extends Authenticatable
{
    use HasFactory, Notifiable;

    // Definindo a tabela associada ao modelo
    protected $table = 'usuarios';

    // Definindo a chave primária da tabela
    protected $primaryKey = 'id_usuario';

    // Habilitando timestamps
    public $timestamps = true;

    // Definindo os campos que podem ser preenchidos
    protected $fillable = ['tipo_id', 'nome', 'sobrenome', 'login', 'senha'];
    protected $hidden = ['senha', 'remember_token'];


    // Função para retornar o campo da senha
    public function getAuthPassword()
    {
        return $this->senha;
    }

    // Relação com a tabela `tipos`
    public function tipos()
    {
        return $this->belongsTo('App\Models\Tipos', 'tipo_id');
    }

    // Verifica se o usuário é admin
    public function isAdmin()
    {
        return $this->tipo_id == 1;
    }

    // Verifica se o usuário é professor
    public function isProfessor()
    {
        return $this->tipo_id == 2;
    }

    // Verifica se o usuário é aluno
    public function isAluno()
    {
        return $this->tipo_id == 3;
    }
}
