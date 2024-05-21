<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Usuarios;
use App\Models\Atividades;
use App\Models\Matricula;

class PainelAdmController extends Controller
{
    public function index()
    {
        $alunos = Usuarios::where('tipo_id', 3)->get(); // Filtra e busca todos os alunos
        $matriculas = Matricula::all(); // Busca todas as matrículas cadastradas
        $atividades = Atividades::all(); // Busca todas as atividades cadastradas

        // Verificação de dados para debug
        // dd($alunos, $matriculas, $atividades);

        // Passa as variáveis para a view
        return view('administrador.paineladm', compact('matriculas', 'alunos', 'atividades'));
    }
}
