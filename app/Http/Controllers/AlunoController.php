<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Atividades;
use App\Models\Usuarios;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AlunoController extends Controller
{
    public function index()
    {
        $usuario = Auth::user();
        $atividades = $usuario->atividades; // Minhas atividades
        return view('aluno.painelaluno', compact('usuario', 'atividades'));
    }

    public function alunoAtividadesIndex()
    {
        $this->authorize('viewAny', Usuarios::class);
        $atividades = Atividades::paginate(10);
        return view('aluno.atividades.listar', compact('atividades'));
    }

    public function atividadesMatriculadas()
    {
        $usuario = Auth::user();
        $atividades = $usuario->atividades()->paginate(10);
        return view('aluno.atividades.matriculadas', compact('atividades'));
    }

    public function matricular($id)
    {
        $usuario = Auth::user();
        $atividade = Atividades::findOrFail($id);
        $usuario->atividades()->attach($atividade);
        return redirect()->route('aluno.atividades.matriculadas')->with('success', 'Matriculado com sucesso.');
    }

    public function desmatricular($id)
{
    $usuario = Auth::user(); // Certifique-se de que o usuário está logado

    if (!$usuario) {
        return redirect()->route('login')->with('error', 'Você precisa estar logado para desmatricular.');
    }

    $atividade = Atividades::findOrFail($id);

    // Remover a atividade da lista de atividades do usuário logado
    $usuario->atividades()->detach($atividade);

    return redirect()->route('aluno.atividades.matriculadas')->with('success', 'Desmatriculado com sucesso');
}
    public function perfilEdit()
    {
        $usuario = Auth::user();
        return view('aluno.perfil.edit', compact('usuario'));
    }

    public function perfilUpdate(Request $request)
    {
        $usuario = Auth::user();
        $this->authorize('update', $usuario);

        $data = $request->validate([
            'nome' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:usuarios,email,' . $usuario->id,
            'password' => 'nullable|string|min:8|confirmed',
        ]);

        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }

        $usuario->update($data);

        return redirect()->route('aluno.perfil.edit')->with('success', 'Perfil atualizado com sucesso.');
    }
}
