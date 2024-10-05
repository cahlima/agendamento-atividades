<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use App\Models\Usuarios;
use App\Models\Tipos;
use App\Services\UserTypeManager;
use Illuminate\Support\Facades\Log;
use App\Http\Requests\UserStoreRequest;
use App\Http\Requests\UserUpdateRequest;

class UsuariosController extends Controller
{
    private $userTypeManager;

    public function __construct(UserTypeManager $userTypeManager)
    {
        $this->middleware('auth');
        $this->userTypeManager = $userTypeManager;
    }

    public function index()
    {
        Log::info('Acessando a lista de usuários');
        $usuarios = Usuarios::paginate(50);
        return view('administrador.usuarios.listar', compact('usuarios'));
    }

    public function adicionar()
    {
        $this->authorize('create', Usuarios::class);
        $tipos = Tipos::all();
        Log::info('Acessando a página de adicionar usuário', ['tipos_disponiveis' => $tipos]);
        return view('administrador.usuarios.criar', compact('tipos'));
    }

    public function salvar(UserStoreRequest $request)
    {
        Log::info('Iniciando a criação de um novo usuário');

        // Validando os dados
        $dados = $request->validated();
        Log::info('Dados validados', $dados);

        // Criptografando a senha
        $dados['senha'] = bcrypt($dados['senha']);
        Log::info('Senha criptografada com sucesso');

        // Criando o usuário
        try {
            $usuario = Usuarios::create($dados);
            Log::info('Usuário criado com sucesso', ['usuario_id' => $usuario->id]);

            // Atribuindo o tipo de usuário
            $this->userTypeManager->assignType($usuario, $dados['tipo_id']);
            Log::info('Tipo de usuário atribuído com sucesso', ['usuario_id' => $usuario->id, 'tipo_id' => $dados['tipo_id']]);

            // Flash message de sucesso
            Session::flash('flash_message', 'Registro adicionado com sucesso!');
            return redirect()->route('usuarios.index');
        } catch (\Exception $e) {
            Log::error('Erro ao criar o usuário', ['erro' => $e->getMessage()]);
            return redirect()->back()->withErrors(['erro' => 'Erro ao criar o usuário. Por favor, tente novamente.'])->withInput();
        }
    }

    public function editar($id)
    {
        Log::info('Acessando a página de edição de usuário', ['usuario_id' => $id]);
        $usuario = Usuarios::findOrFail($id);
        $this->authorize('update', $usuario);
        $tipos = Tipos::all();
        return view('administrador.usuarios.editar', compact('usuario', 'tipos'));
    }

    public function atualizar(UserUpdateRequest $request, $id)
    {
        Log::info('Iniciando a atualização do usuário', ['usuario_id' => $id]);
        $usuario = Usuarios::findOrFail($id);
        $this->authorize('update', $usuario);

        $dados = $request->validated();
        Log::info('Dados validados para atualização', $dados);

        // Atualizando a senha apenas se for fornecida
        if (!empty($dados['senha'])) {
            $dados['senha'] = bcrypt($dados['senha']);
            Log::info('Senha atualizada e criptografada com sucesso');
        } else {
            unset($dados['senha']);
            Log::info('Senha não foi alterada');
        }

        try {
            $usuario->update($dados);
            Log::info('Usuário atualizado com sucesso', ['usuario_id' => $usuario->id]);

            $this->userTypeManager->updateType($usuario, $dados['tipo_id']);
            Log::info('Tipo de usuário atualizado com sucesso', ['usuario_id' => $usuario->id, 'tipo_id' => $dados['tipo_id']]);

            Session::flash('flash_message', 'Registro atualizado com sucesso!');
            return redirect()->route('usuarios.index');
        } catch (\Exception $e) {
            Log::error('Erro ao atualizar o usuário', ['erro' => $e->getMessage()]);
            return redirect()->back()->withErrors(['erro' => 'Erro ao atualizar o usuário. Por favor, tente novamente.'])->withInput();
        }
    }

    public function deletar($id)
    {
        Log::info('Iniciando a exclusão do usuário', ['usuario_id' => $id]);
        $usuario = Usuarios::findOrFail($id);
        $this->authorize('delete', $usuario);

        try {
            $usuario->delete();
            Log::info('Usuário deletado com sucesso', ['usuario_id' => $usuario->id]);

            Session::flash('flash_message', 'Registro excluído com sucesso!');
            return redirect()->route('usuarios.index');
        } catch (\Exception $e) {
            Log::error('Erro ao deletar o usuário', ['erro' => $e->getMessage()]);
            return redirect()->back()->withErrors(['erro' => 'Erro ao deletar o usuário. Por favor, tente novamente.']);
        }
    }
}
