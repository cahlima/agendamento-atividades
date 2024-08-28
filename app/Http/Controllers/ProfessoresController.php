<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Hash;
use App\Models\Atividades;

class ProfessoresController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth'); // Garante que o usuário esteja autenticado para todas as rotas
    }

    // Exibe o painel do professor com suas atividades matriculadas
    public function index()
    {
        $usuario = Auth::user();

        // Supondo que 'atividades' é uma relação definida no modelo do usuário
        $atividades = $usuario->atividades()->paginate(10); // Usando paginate para garantir a paginação

        Log::info('Usuário autenticado acessando o painel do professor', [
            'user_id' => $usuario->id,
            'email' => $usuario->email
        ]);

        Log::info('Atividades recuperadas', ['atividades' => $atividades]);

        return view('professor.painelprof', compact('usuario', 'atividades'));
    }

    // Método para exibir as atividades matriculadas pelo professor
    public function profAtividadesMatriculadas()
    {
        $usuario = Auth::user();

          $atividades = Atividades::where('instrutor_id', $usuario->id)
    ->with('alunos')
    ->paginate(10);





        Log::info('Listando atividades matriculadas pelo professor', ['user_id' => $usuario->id]);

        return view('professor.atividades.matriculadas', compact('atividades'));
    }

    // Exibe a página para editar o perfil do professor
    public function perfilEdit()
    {
        $usuario = Auth::user();
        return view('professor.perfil.edit', compact('usuario'));
    }

    // Atualiza os dados do perfil do professor
    public function perfilUpdate(Request $request)
    {
        $usuario = Auth::user();

        $data = $request->validate([
            'nome' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:usuarios,email,' . $usuario->id,
            'password' => 'nullable|string|min:8|confirmed',
        ]);

        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        } else {
            unset($data['password']);
        }

        $usuario->update($data);

        return redirect()->route('professor.perfil.edit')->with('success', 'Perfil atualizado com sucesso.');
    }

    public function showPerfil()
    {
        $usuario = Auth::user();
        return view('professor.perfil.index', compact('usuario'));
    }
}
