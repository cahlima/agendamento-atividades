<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Atividades extends Model
{
    use HasFactory;

    protected $fillable = ['usuario_id', 'titulo', 'descricao'];
    protected $primaryKey = 'id';

    public function usuarios()
    {
        return $this->belongsTo('App\Models\Usuarios', 'usuario_id');
    }

    public function matricula()
    {
        return $this->hasMany('App\Models\Matricula', 'atividades_id');
    }
}

