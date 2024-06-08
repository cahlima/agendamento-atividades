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
        return view('aluno.painelaluno');
    }

    public function AlunoatividadesIndex()
{
    $this->authorize('viewAny', Usuarios::class);
    $atividades = Atividades::paginate(10);
    return view('aluno.atividades.index', compact('atividades'));
}

    public function atividadesMatriculadas()
    {
        $atividades = Auth::usuario()->atividades()->paginate(10);
        return view('aluno.atividades.matriculadas', compact('atividades'));
    }

    public function perfilEdit()
    {
        $usuario = Auth::usuario();
        return view('aluno.perfil.edit', compact('usuario'));
    }


public function perfilUpdate(Request $request)
{
    $usuario = Auth::usuario();
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
