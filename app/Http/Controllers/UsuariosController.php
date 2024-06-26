<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use App\Models\Usuarios;
use App\Models\Tipos;
use App\Models\Aluno;
use App\Models\Professor;
use Illuminate\Support\Facades\Validator;

class UsuariosController extends Controller
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
        $tipos = Tipos::all();
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
        $usuario = Usuarios::create($dados);

        // Adiciona um aluno ou professor conforme o tipo selecionado
        if ($request->tipo_id == Tipos::where('nome', 'Aluno')->first()->id) {
            Aluno::create(['usuario_id' => $usuario->id]);
        } elseif ($request->tipo_id == Tipos::where('nome', 'Professor')->first()->id) {
            Professor::create(['usuario_id' => $usuario->id]);
        }

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
        $tipos = Tipos::all();
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

        $validator = Validator::make($request->all(), [
            'nome' => 'required|string|max:255',
            'email' => 'required|email|unique:usuarios,email,'.$usuario->id,
            'tipo_id' => 'required|exists:tipos,id'
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $usuario->update($request->only(['nome', 'email', 'tipo_id']));

        // Atualiza o tipo de usuário (aluno ou professor)
        if ($request->tipo_id == Tipos::where('nome', 'Aluno')->first()->id) {
            if (!$usuario->aluno) {
                Aluno::create(['usuario_id' => $usuario->id]);
            }
        } elseif ($request->tipo_id == Tipos::where('nome', 'Professor')->first()->id) {
            if (!$usuario->professor) {
                Professor::create(['usuario_id' => $usuario->id]);
            }
        }

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
            $this->authorize('delete', $usuario);
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
