<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Instrutor extends Model
{
    use HasFactory;

    protected $fillable = ['usuario_id'];

    /**
     * Relação entre Instrutor e Usuário.
     *
     * Um instrutor pertence a um usuário.
     */
    public function usuario()
    {
        return $this->belongsTo(Usuarios::class, 'usuario_id'); // Verifique se a model é realmente "Usuarios"
    }

    /**
     * Método estático para obter todos os instrutores.
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public static function instrutores()
    {
        return Usuarios::where('tipo_id', 3)->get();
    }
}
