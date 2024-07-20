<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use App\Models\Usuarios;
use App\Models\Tipos;
use Illuminate\Support\Facades\Validator;

class UsuariosController extends Controller
{
    private $userTypeManager;

    public function __construct(UserTypeManager $userTypeManager)
    {
        $this->middleware('auth');
        $this->userTypeManager = $userTypeManager;
    }

    // Exibe uma lista paginada de usuários
    public function index()
    {
        $usuarios = Usuarios::paginate(10);
        return view('administrador.usuarios.listar', compact('usuarios'));
    }

    // Exibe o formulário para adicionar um novo usuário
    public function adicionar()
    {
        $this->authorize('create', Usuarios::class);
        $tipos = Tipos::all();
        return view('administrador.usuarios.criar', compact('tipos'));
    }

    // Salva um novo usuário no banco de dados
    public function salvar(UserStoreRequest $request)
    {
        $dados = $request->validated();
        $dados['senha'] = bcrypt($dados['senha']);
        $usuario = Usuarios::create($dados);

        $this->userTypeManager->assignType($usuario, $dados['tipo_id']);

        Session::flash('flash_message', 'Registro adicionado com sucesso!');
        return redirect()->route('usuarios.adicionar');
    }

    // Exibe o formulário para editar um usuário existente
    public function editar($id)
    {
        $usuario = Usuarios::findOrFail($id);
        $this->authorize('update', $usuario);
        $tipos = Tipos::all();
        return view('administrador.usuarios.editar', compact('usuario', 'tipos'));
    }

    // Atualiza os dados de um usuário existente
    public function atualizar(UserUpdateRequest $request, $id)
    {
        $usuario = Usuarios::findOrFail($id);
        $this->authorize('update', $usuario);
        $dados = $request->validated();

        if (isset($dados['senha']) && $dados['senha']) {
            $dados['senha'] = bcrypt($dados['senha']); // Criptografa a nova senha, se fornecida
        } else {
            unset($dados['senha']); // Remove a senha do array de dados se estiver vazia
        }

        $usuario->update($dados);

        $this->userTypeManager->updateType($usuario, $dados['tipo_id']);

        Session::flash('flash_message', 'Registro atualizado com sucesso!');
        return redirect()->route('usuarios.index');
    }

    // Exclui um usuário existente
    public function deletar($id)
    {
        $usuario = Usuarios::findOrFail($id);
        $this->authorize('delete', $usuario);
        $usuario->delete();
        Session::flash('flash_message', 'Registro excluído com sucesso!');
        return redirect()->route('usuarios.index');
    }
}
