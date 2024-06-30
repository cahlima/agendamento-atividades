<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Atividades;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class AlunoController extends Controller
{
    public function index()
    {
        $usuario = Auth::guard('web')->user();
        $atividades = $usuario->atividades()->wherePivot('tipo_id', 3)->get(); // Obtém apenas as atividades onde o tipo_id é 3 (Aluno)

        return view('aluno.painelaluno', compact('usuario', 'atividades'));
    }

    public function alunoAtividadesIndex(Request $request)
    {
        $query = Atividades::query();

        if ($request->filled('atividade_id')) {
            $query->where('id', $request->atividade_id);
        }

        if ($request->filled('hora')) {
            $query->where('hora', $request->hora);
        }

        $atividades = $query->paginate(10);
        $atividadesDisponiveis = Atividades::select('id', 'atividade')->distinct()->get();
        $horariosDisponiveis = Atividades::select('hora')->distinct()->pluck('hora');

        return view('aluno.atividades.listar', compact('atividades', 'atividadesDisponiveis', 'horariosDisponiveis'));
    }

    public function atividadesMatriculadas()
    {
        $usuario = Auth::guard('web')->user();

        if (!$usuario || is_null($usuario->email)) {
            Log::error('Usuário não autenticado ou sem e-mail ao acessar atividades matriculadas', ['user' => $usuario]);
            return redirect()->route('login')->with('error', 'Você precisa estar autenticado para acessar essa página.');
        }

        Log::info('Usuário autenticado', ['user_id' => $usuario->id, 'email' => $usuario->email]);

        $atividades = $usuario->atividades()->paginate(10);
        Log::info('Atividades recuperadas', ['atividades' => $atividades]);

        // Buscar atividades disponíveis
        $atividadesDisponiveis = Atividades::select('id', 'atividade')->distinct()->get();
        $horariosDisponiveis = Atividades::select('hora')->distinct()->pluck('hora');

        return view('aluno.atividades.matriculadas', compact('atividades', 'atividadesDisponiveis', 'horariosDisponiveis'));
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
