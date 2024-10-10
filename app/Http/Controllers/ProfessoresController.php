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

    // Filtra atividades onde a data de fim é maior ou igual a hoje
    $minhasAtividades = Atividades::where('instrutor_id', $usuario->id)
                                  ->where('data_fim', '>=', now()) // Filtra atividades que não expiraram
                                  ->with('alunos') // Se precisar exibir os alunos também
                                  ->paginate(10);

    Log::info('Usuário autenticado acessando o painel do professor', [
        'user_id' => $usuario->id,
        'email' => $usuario->email
    ]);

    return view('professor.painelprof', compact('usuario', 'minhasAtividades'));
}
public function profAtividadesMatriculadas()
{
    $usuario = Auth::user();

    // Filtra atividades onde o professor é o instrutor e traz os alunos relacionados
    $atividades = Atividades::where('instrutor_id', $usuario->id)
                            ->where('data_fim', '>=', now()) // Filtra atividades que não expiraram
                            ->with('alunos') // Carrega a relação de alunos para cada atividade
                            ->paginate(10);

    Log::info('Listando atividades matriculadas pelo professor', ['user_id' => $usuario->id]);

    return view('professor.atividades.matriculadas', compact('atividades'));
}

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
        'login' => 'required|string|max:255|unique:usuarios,login,' . $usuario->id,
        'telefone' => 'nullable|string|max:20',
        'senha' => 'nullable|string|min:8|confirmed',
    ]);

    // Verifica se a senha foi fornecida para ser atualizada
    if ($request->filled('senha')) {
        $data['senha'] = bcrypt($request->senha);  // bcrypt para garantir a segurança
    } else {
        unset($data['senha']);
    }

    try {
        $usuario->update($data);

        return redirect()->route('professor.perfil.index')->with('success', 'Perfil atualizado com sucesso.');
    } catch (\Exception $e) {
        return redirect()->route('professor.perfil.edit')->with('error', 'Erro ao atualizar o perfil.');
    }
}


    public function showPerfil()
    {
        $usuario = Auth::user();
        return view('professor.perfil.index', compact('usuario'));
    }
}
