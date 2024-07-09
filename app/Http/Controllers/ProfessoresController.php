<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Atividades;
use App\Models\Usuarios;

class ProfessoresController extends Controller
{
    // Listar todas as atividades
    public function profAtividadesIndex()
    {
        $atividades = Atividades::all();
        return view('professor.atividades.listar', compact('atividades'));
    }

    // Listar atividades do professor autenticado
    public function minhasAtividades()
    {
        $professorId = auth()->user()->id;
        $minhasAtividades = Atividades::whereHas('professores', function($query) use ($professorId) {
            $query->where('usuario_id', $professorId);
        })->get();
        return view('professor.atividades.matriculadas', compact('minhasAtividades'));
    }

    // Editar perfil
    public function perfilEdit()
    {
        $professor = auth()->user();
        return view('professor.perfil.edit', compact('professor'));
    }

    // Atualizar perfil
    public function perfilUpdate(Request $request)
    {
        $professor = auth()->user();
        $professor->update($request->all());
        return redirect()->route('professor.perfil.edit')->with('success', 'Perfil atualizado com sucesso.');
    }

    // Painel do professor
    public function index()
    {
        $professorId = auth()->user()->id;
        $minhasAtividades = Atividades::whereHas('professores', function($query) use ($professorId) {
            $query->where('usuario_id', $professorId);
        })->get();

        return view('professor.painelprof', compact('minhasAtividades'));
    }
}
