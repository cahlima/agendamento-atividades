<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use App\Models\Usuarios;
use App\Models\Tipos;
use App\Services\UserTypeManager;
use Illuminate\Support\Facades\Validator;
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
        $usuarios = Usuarios::paginate(10);
        return view('administrador.usuarios.listar', compact('usuarios'));
    }

    public function adicionar()
    {
        $this->authorize('create', Usuarios::class);
        $tipos = Tipos::all();
        return view('administrador.usuarios.criar', compact('tipos'));
    }

    public function salvar(UserStoreRequest $request)
    {
        $dados = $request->validated();
        \Log::info('Dados recebidos para criar usuário', $dados);

        $dados['senha'] = bcrypt($dados['senha']);
        $usuario = Usuarios::create($dados);

        \Log::info('Usuário criado com sucesso', ['usuario_id' => $usuario->id]);

        $this->userTypeManager->assignType($usuario, $dados['tipo_id']);

        Session::flash('flash_message', 'Registro adicionado com sucesso!');
        return redirect()->route('usuarios.index');
    }

    public function editar($id)
    {
        $usuario = Usuarios::findOrFail($id);
        $this->authorize('update', $usuario);
        $tipos = Tipos::all();
        return view('administrador.usuarios.editar', compact('usuario', 'tipos'));
    }

    public function atualizar(UserUpdateRequest $request, $id)
    {
        $usuario = Usuarios::findOrFail($id);
        $this->authorize('update', $usuario);

        $dados = $request->validated();
        \Log::info('Dados recebidos para atualizar usuário', $dados);

        if (isset($dados['senha']) && $dados['senha']) {
            $dados['senha'] = bcrypt($dados['senha']);
        } else {
            unset($dados['senha']);
        }

        $usuario->update($dados);
        \Log::info('Usuário atualizado com sucesso', ['usuario_id' => $usuario->id, 'dados_atualizados' => $dados]);

        $this->userTypeManager->updateType($usuario, $dados['tipo_id']);

        Session::flash('flash_message', 'Registro atualizado com sucesso!');
        return redirect()->route('usuarios.index');
    }

    public function deletar($id)
    {
        $usuario = Usuarios::findOrFail($id);
        $this->authorize('delete', $usuario);
        \Log::info('Deletando usuário', ['usuario_id' => $usuario->id]);

        $usuario->delete();

        \Log::info('Usuário deletado com sucesso', ['usuario_id' => $usuario->id]);

        Session::flash('flash_message', 'Registro excluído com sucesso!');
        return redirect()->route('usuarios.index');
    }
}
