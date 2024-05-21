<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Auth;
use Laravel\Sanctum\HasApiTokens;


class User extends Authenticatable
{

    use HasApiTokens, HasFactory, Notifiable;

    protected $table = 'usuarios'; // Apontar para a tabela correta

    public function isAdmin()
    {
        return $this->tipo_id == 1; // Ajustar conforme a lógica da tabela `usuarios`
    }

    public function isProfessor()
    {
        return $this->tipo_id == 2;
    }

    public function isAluno()
    {
        return $this->tipo_id == 3;
    }
}

