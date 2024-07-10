<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class ProfessoresController extends Controller
{
    // Exibe o painel do professor com suas atividades matriculadas
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

        return view('professor.painelprof', compact('usuario', 'atividades'));
    }

    // Exibe a página para editar o perfil do professor
    public function perfilEdit()
    {
        $usuario = Auth::guard('web')->user();
        if (!$usuario) {
            return redirect()->route('login')->with('error', 'Você precisa estar autenticado para acessar essa página.');
        }

        return view('professor.perfil.edit', compact('usuario'));
    }

    // Atualiza os dados do perfil do professor
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

        return redirect()->route('professor.perfil.edit')->with('success', 'Perfil atualizado com sucesso.');
    }
}
