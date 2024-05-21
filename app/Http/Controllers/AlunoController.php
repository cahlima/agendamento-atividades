<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AlunoController extends Controller
{



    public function index()
    {
        return view('aluno.home');
    }

    public function editProfile()
    {
        // Lógica para editar o perfil do aluno
    }

    public function minhasAtividades()
    {
        $atividades = Atividades::where('aluno_id', Auth::id())->get();
        return view('aluno.minhas_atividades', compact('atividades'));
    }

    public function meMatricular()
    {
        // Lógica para permitir que o aluno se matricule em atividades
    }





    //
}
