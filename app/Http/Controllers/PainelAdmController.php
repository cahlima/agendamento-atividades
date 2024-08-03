<?php

namespace App\Http\Controllers;

use App\Models\Atividades;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use App\Models\Usuarios;
use App\Models\Tipos;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;

class PainelAdmController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        Log::info('Método index do PainelAdmController chamado');
        $atividades = Atividades::all(); // Busca todas as atividades cadastradas
        return view('administrador.paineladm', compact('atividades'));
    }

    public function perfilIndex()
{
    $usuario = Auth::user();
    return view('administrador.perfil.index', compact('usuario'));
}


public function perfilEdit($id)
{
    $usuario = Usuarios::findOrFail($id);
    return view('administrador.perfil.edit', compact('usuario'));
}

public function perfilUpdate(Request $request, $id)
{
    $usuario = Usuarios::findOrFail($id);

    $request->validate([
        'nome' => 'required|string|max:255',
        'sobrenome' => 'required|string|max:255',
        'email' => 'required|string|email|max:255|unique:usuarios,email,' . $id,
        'login' => 'required|string|max:255|unique:usuarios,login,' . $id,
        'data_nascimento' => 'required|date',
        'telefone' => 'required|string|max:15',
        'senha' => 'nullable|string|min:8|confirmed',
    ]);

    $usuario->update($request->only('nome', 'sobrenome', 'email', 'login', 'data_nascimento', 'telefone'));

    if ($request->filled('senha')) {
        $usuario->update(['senha' => bcrypt($request->senha)]);
    }

    Session::flash('flash_message', 'Perfil atualizado com sucesso!');
    return redirect()->route('admin.perfil.index');
}


    public function listarUsuarios()
    {
        try {
            Log::info('Entrando no método listarUsuarios');

            $usuarios = Usuarios::paginate(10);

            Log::info('Usuários recuperados com sucesso');

            return view('administrador.usuarios.listar', compact('usuarios'));
        } catch (\Exception $e) {
            Log::error('Erro ao listar usuários: ' . $e->getMessage());
            return redirect()->back()->withErrors('Erro ao recuperar usuários.');
        }
    }

    public function adicionarUsuario()
    {
        $this->authorize('create', Usuarios::class);
        $tipos = Tipos::all();
        return view('administrador.usuarios.criar', compact('tipos'));
    }

    public function salvarUsuario(Request $request)
    {
        $this->authorize('create', Usuarios::class);

        $validator = Validator::make($request->all(), [
            'nome' => 'required|string|max:255',
            'sobrenome' => 'required|string|max:255',
            'login' => 'required|string|max:255|unique:usuarios,login',
            'email' => 'required|email|unique:usuarios,email',
            'senha' => 'required|string|min:6|confirmed',
            'data_nascimento' => 'required|date',
            'telefone' => 'required|string|max:20',
            'tipo_id' => 'required|exists:tipos,id'
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $dados = $request->only(['nome', 'sobrenome', 'login', 'email', 'data_nascimento', 'telefone', 'tipo_id']);
        $dados['senha'] = bcrypt($request->senha);
        Usuarios::create($dados);

        Session::flash('flash_message', [
            'msg' => "Registro adicionado com sucesso!",
            'class' => "alert-success"
        ]);
        return redirect()->route('usuarios.index');
    }

    public function editarUsuario($id)
    {
        $usuario = Usuarios::findOrFail($id);
        $this->authorize('update', $usuario);
        $tipos = Tipos::all();
        return view('administrador.usuarios.editar', compact('usuario', 'tipos'));
    }

    public function atualizarUsuario(Request $request, $id)
    {
        $usuario = Usuarios::findOrFail($id);
        $this->authorize('update', $usuario);

        $validator = Validator::make($request->all(), [
            'nome' => 'required|string|max:255',
            'sobrenome' => 'required|string|max:255',
            'login' => 'required|string|max:255|unique:usuarios,login,'.$usuario->id,
            'email' => 'required|email|unique:usuarios,email,'.$usuario->id,
            'senha' => 'nullable|string|min:6|confirmed',
            'data_nascimento' => 'required|date',
            'telefone' => 'required|string|max:20',
            'tipo_id' => 'required|exists:tipos,id'
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $dados = $request->only(['nome', 'sobrenome', 'login', 'email', 'data_nascimento', 'telefone', 'tipo_id']);
        if ($request->filled('senha')) {
            $dados['senha'] = bcrypt($request->senha);
        }
        $usuario->update($dados);

        Session::flash('flash_message', [
            'msg' => "Registro atualizado com sucesso!",
            'class' => "alert-success"
        ]);

        return redirect()->route('usuarios.index');
    }

    public function deletarUsuario($id)
    {
        $usuario = Usuarios::findOrFail($id);
        $this->authorize('delete', $usuario);
        $usuario->delete();

        Session::flash('flash_message', [
            'msg' => "Registro excluído com sucesso!",
            'class' => "alert-success"
        ]);

        return redirect()->route('usuarios.index');
    }
}
