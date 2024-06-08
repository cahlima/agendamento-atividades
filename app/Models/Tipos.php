<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tipos extends Model
{
    protected $table = 'tipos';

    protected $fillable = ['nome'];

    public function usuarios()
    {
        return $this->hasMany(Usuarios::class, 'tipo_id');
    }
}
