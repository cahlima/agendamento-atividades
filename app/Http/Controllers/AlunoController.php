<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class AlunoController extends Controller
{


public function index()
{
    $usuario = Auth::guard('web')->user();

    if (!$usuario || is_null($usuario->email)) {
        Log::error('Usuário não autenticado ou sem e-mail ao acessar o painel', ['user' => $usuario]);
        return redirect()->route('login')->with('error', 'Você precisa estar autenticado para acessar essa página.');
    }

    // Supondo que 'atividades' é uma relação definida no modelo do usuário
    $atividades = $usuario->atividades()->get();

    Log::info('Usuário autenticado', ['user_id' => $usuario->id, 'email' => $usuario->email]);
    Log::info('Atividades recuperadas', ['atividades' => $atividades]);

    // Garanta que a variável 'atividades' não seja nula ao passar para a view
    return view('aluno.painelaluno', compact('usuario', 'atividades'));
}

    public function perfilEdit()
    {
        $usuario = Auth::guard('web')->user();
        return view('aluno.perfil.edit', compact('usuario'));
    }

    public function perfilUpdate(Request $request)
    {
        $usuario = Auth::guard('web')->user();

        $data = $request->validate([
            'nome' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:usuarios,email,' . $usuario->id,
            'password' => 'nullable|string|min:8|confirmed',
        ]);

        if ($request->filled('password')) {
            $data['password'] = bcrypt($request->password);
        } else {
            unset($data['password']);
        }

        $usuario->update($data);

        return redirect()->route('aluno.perfil.edit')->with('success', 'Perfil atualizado com sucesso.');
    }
}
