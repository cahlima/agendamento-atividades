<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;

class AlunoController extends Controller
{

    public function index()
    {
        $usuario = Auth::guard('web')->user();

        if (!$usuario || is_null($usuario->email)) {
            Log::error('Usuário não autenticado ou sem e-mail ao acessar o painel', ['user' => $usuario]);
            return redirect()->route('login')->with('error', 'Você precisa estar autenticado para acessar essa página.');
        }

        // Adicionando um log para verificar o tipo de usuário
        Log::info('Usuário autenticado acessando o painel do aluno', ['user_id' => $usuario->id, 'tipo_id' => $usuario->tipo_id]);

        if (!$usuario->isAluno()) {
            Log::warning('Usuário não autorizado a acessar o painel do aluno', ['user_id' => $usuario->id, 'tipo_id' => $usuario->tipo_id]);
            abort(403, 'Acesso negado. Você não tem permissão para acessar esta página.');
        }

        // Carregar as atividades do aluno e garantir que o instrutor seja carregado
        $atividades = $usuario->atividades()->with('instrutor')->get();
        Log::debug('Atividades recuperadas', ['atividades' => $atividades]);
        Log::info('Usuário autenticado', ['user_id' => $usuario->id, 'email' => $usuario->email]);

        return view('aluno.painelaluno', compact('usuario', 'atividades'));
    }




    public function showPerfil()
    {
        $usuario = Auth::guard('web')->user();
        Log::info('Exibindo perfil do usuário', ['user_id' => $usuario->id]);
        return view('aluno.perfil.index', compact('usuario'));
    }

    public function editPerfil()
    {
        $usuario = Auth::guard('web')->user();
        Log::info('Exibindo formulário de edição de perfil', ['user_id' => $usuario->id]);
        return view('aluno.perfil.edit', compact('usuario'));
    }

    public function updatePerfil(Request $request)
    {
        $usuario = Auth::guard('web')->user();
        Log::info('Iniciando atualização de perfil', ['user_id' => $usuario->id, 'request_data' => $request->all()]);

        $data = $request->validate([
            'nome' => 'required|string|max:255',
            'sobrenome' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:usuarios,email,' . $usuario->id,
            'login' => 'required|string|max:255|unique:usuarios,login,' . $usuario->id,
            'data_nascimento' => 'required|date',
            'telefone' => 'required|string|max:20',
            'senha' => 'nullable|string|min:8|confirmed',
        ]);

        Log::info('Dados validados', ['data' => $data]);

        if ($request->filled('senha')) {
            $data['senha'] = bcrypt($request->senha);
        } else {
            unset($data['senha']);
        }

        Log::info('Dados a serem atualizados', ['data' => $data]);

        try {
            $usuario->update($data);
            Log::info('Perfil atualizado com sucesso', ['user_id' => $usuario->id, 'updated_data' => $data]);

            Session::flash('flash_message', [
                'msg' => "Perfil atualizado com sucesso!",
                'class' => "alert-success"
            ]);

            return redirect()->route('aluno.perfil.index');
        } catch (\Exception $e) {
            Log::error('Erro ao atualizar perfil do usuário', ['user_id' => $usuario->id, 'error' => $e->getMessage()]);
            return redirect()->route('aluno.perfil.edit')->with('error', 'Erro ao atualizar o perfil.');
        }
    }
}
