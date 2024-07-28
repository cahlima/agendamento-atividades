<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Instrutor extends Model
{
    use HasFactory;

    protected $fillable = ['usuario_id'];

    public function usuario()
    {
        return $this->belongsTo(Usuarios::class, 'usuario_id');
    }

    public static function instrutores()
    {
        return Usuarios::where('tipo_id', 3)->get();
    }
}
