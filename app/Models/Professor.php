<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Professor extends Model
{
    use HasFactory;

    protected $fillable = ['usuario_id'];

    // Definindo a relação com o modelo Usuario
    public function usuario()
    {
        return $this->belongsTo(Usuarios::class);
    }
}

