<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use App\Models\Usuarios;
use App\Models\Tipos;
use Illuminate\Support\Facades\Validator;

class UsuarioController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    // Exibe uma lista paginada de usuários
    public function index()
    {
        $usuarios = Usuarios::paginate(10);
        return view('usuario.index', compact('usuarios'));
    }

    // Exibe o formulário para adicionar um novo usuário
    public function adicionar()
    {
        $this->authorize('create', Usuarios::class);
        $tipos = Tipos::all(); // Assume que a lista de tipos é gerenciável sem paginação
        return view('usuario.adicionar', compact('tipos'));
    }

    // Salva um novo usuário no banco de dados
    public function salvar(Request $request)
    {
        $this->authorize('create', Usuarios::class);

        $validator = Validator::make($request->all(), [
            'nome' => 'required|string|max:255',
            'email' => 'required|email|unique:usuarios,email',
            'senha' => 'required|string|min:6',
            'tipo_id' => 'required|exists:tipos,id'
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $dados = $request->only(['nome', 'email', 'tipo_id']);
        $dados['senha'] = bcrypt($request->senha);
        Usuarios::create($dados);

        Session::flash('flash_message', [
            'msg' => "Registro adicionado com sucesso!",
            'class' => "alert-success"
        ]);
        return redirect()->route('usuario.adicionar');
    }

    // Exibe o formulário para editar um usuário existente
    public function editar($id)
    {
        $usuario = Usuarios::find($id);
        if (!$usuario) {
            return redirect()->back()->withErrors('Usuário não encontrado.');
        }
        $this->authorize('update', $usuario);
        $tipos = Tipos::all(); // Sem paginação
        return view('usuario.editar', compact('usuario', 'tipos'));
    }

    // Atualiza um usuário no banco de dados
    public function atualizar(Request $request, $id)
    {
        $usuario = Usuarios::find($id);
        if (!$usuario) {
            return redirect()->back()->withErrors('Usuário não encontrado.');
        }
        $this->authorize('update', $usuario);
        $usuario->update($request->only(['nome', 'email', 'tipo_id']));
        Session::flash('flash_message', [
            'msg' => "Registro atualizado com sucesso!",
            'class' => "alert-success"
        ]);

        return redirect()->route('usuario.index');
    }

    // Deleta um usuário do banco de dados
    public function deletar($id)
    {
        $usuario = Usuarios::find($id);
        if ($usuario) {
            $usuario->delete();
            Session::flash('flash_message', [
                'msg' => "Registro excluído com sucesso!",
                'class' => "alert-success"
            ]);
        } else {
            Session::flash('flash_message', [
                'msg' => "Usuário não encontrado.",
                'class' => "alert-danger"
            ]);
        }
        return redirect()->route('usuario.index');
    }
}
