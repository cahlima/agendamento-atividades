<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Matricula extends Model
{
    use HasFactory,Notifiable;

    protected $fillable = ['atividade_id','usuario_id','status'];
    protected $primaryKey = 'id_matricula';

    public function usuarios()
    {
        return $this->belongsTo('App\Models\Usuarios', 'usuario_id');
    }
    public function atividades()
    {
        return $this->belongsTo('App\Models\Atividades', 'atividades_id');
    }

    // app/Models/Matricula.php

public function aluno()
{
    return $this->belongsTo(Aluno::class);
}

}

