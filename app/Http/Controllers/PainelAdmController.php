<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use App\Models\Usuarios;
use App\Models\Atividades;
use App\Models\Matricula;
use App\Models\Tipos;
use Illuminate\Support\Facades\Validator;

class PainelAdmController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    // Exibe o painel administrativo


    // Exibe uma lista paginada de usuários
    public function listarUsuarios()
    {
        $usuarios = Usuarios::paginate(10);
        return view('administrador.usuarios.index', compact('usuarios'));
    }

    // Exibe o formulário para adicionar um novo usuário
    public function adicionar()
    {
        $this->authorize('create', Usuarios::class);
        $tipos = Tipos::all();
        return view('administrador.usuarios.adicionar', compact('tipos'));
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
        $tipos = Tipos::all();
        return view('administrador.usuarios.editar', compact('usuario', 'tipos'));
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


    public function index()
    {
        $atividades = Atividades::all(); // Busca todas as atividades cadastradas
        return view('administrador.paineladm', compact('atividades'));
    }


    public function listarAtividades()
    {
        $atividades = Atividades::all(); // Busca todas as atividades cadastradas
        return view('administrador.paineladm', compact('atividades'));
    }

    // Exibe o formulário para adicionar uma nova atividade
    public function adicionarAtividade()
    {
        return view('administrador.atividades.adicionar');
    }

    // Salva uma nova atividade no banco de dados
    public function salvarAtividade(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'atividade' => 'required|string|max:255',
            'data' => 'required|date',
            'hora' => 'required|date_format:H:i',
            'instrutor' => 'required|string|max:255',
            'local' => 'required|string|max:255'
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        Atividades::create($request->only(['atividade', 'data', 'hora', 'instrutor', 'local']));

        Session::flash('flash_message', [
            'msg' => "Atividade adicionada com sucesso!",
            'class' => "alert-success"
        ]);
        return redirect()->route('atividades.listar');
    }

    // Exibe o formulário para editar uma atividade existente
    public function editarAtividade($id)
{
    $atividade = Atividades::find($id);
    if (!$atividade) {
        return redirect()->route('atividades.listar')->withErrors('Atividade não encontrada.');
    }
    return view('administrador.atividades.editar', compact('atividade'));
}
public function atualizarAtividade(Request $request, $id)
{
    $atividade = Atividades::find($id);
    if (!$atividade) {
        return redirect()->back()->withErrors('Atividade não encontrada.');
    }

    $validator = Validator::make($request->all(), [
        'atividade' => 'required|string|max:255',
        'data' => 'required|date',
        'hora' => 'required|date_format:H:i',
        'instrutor' => 'required|string|max:255',
        'local' => 'required|string|max:255'
    ]);

    if ($validator->fails()) {
        return redirect()->back()->withErrors($validator)->withInput();
    }

    $atividade->update($request->only(['atividade', 'data', 'hora', 'instrutor', 'local']));
    Session::flash('flash_message', [
        'msg' => "Atividade atualizada com sucesso!",
        'class' => "alert-success"
    ]);

    return redirect()->route('atividades.listar');
}


    // Deleta uma atividade do banco de dados
    public function deletarAtividade($id)
    {
        $atividade = Atividades::find($id);
        if ($atividade) {
            $atividade->delete();
            Session::flash('flash_message', [
                'msg' => "Atividade excluída com sucesso!",
                'class' => "alert-success"
            ]);
        } else {
            Session::flash('flash_message', [
                'msg' => "Atividade não encontrada.",
                'class' => "alert-danger"
            ]);
        }
        return redirect()->route('atividades.index');
    }

    public function perfilEdit()
    {
        $usuario = Auth::guard('admin')->user();
        return view('perfil.edit_admin', compact('usuario'));
    }

    public function perfilUpdate(Request $request)
    {
        $usuario = Auth::guard('admin')->user();

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

        return redirect()->route('admin.perfil.edit')->with('success', 'Perfil atualizado com sucesso.');
    }
}
}
