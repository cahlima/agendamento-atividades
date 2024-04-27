<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session; // Adicionado para usar Session
use App\Models\Usuarios;
use App\Models\Tipos;
use App\Notifications\NotificaUsuario;

class UsuarioController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $usuarios = Usuarios::paginate(10); // Corrigido para usar o model Usuarios diretamente

        return view('usuario.index', compact('usuarios'));
    }

    public function adicionar()
    {
        $this->authorize('create', Usuarios::class);

        $tipos = Tipos::paginate(10); // Corrigido para usar o model Tipos diretamente

        return view('usuario.adicionar', compact('tipos'));
    }

    public function salvar(Request $request)
    {
        $this->authorize('create', Usuarios::class);

        $dados = $request->all();
        $dados['senha'] = bcrypt($dados['senha']);
        Usuarios::create($dados);

        Session::flash('flash_message', [
            'msg' => "Registro adicionado com sucesso!",
            'class' => "alert-success"
        ]);
        return redirect()->route('usuario.adicionar');
    }

    public function editar($id)
    {
        $this->authorize('update', Usuarios::class);

        $usuarios = Usuarios::find($id);
        $tipos = Tipos::paginate(10); // Corrigido para usar o model Tipos diretamente

        return view('usuario.editar', compact('usuarios', 'tipos'));
    }

    public function atualizar(Request $request, $id)
    {
        $this->authorize('update', Usuarios::class);

        $usuarios = Usuarios::find($id);

        $dados = $request->all();

        $usuarios->update($dados);

        Session::flash('flash_message', [
            'msg' => "Registro atualizado com sucesso!",
            'class' => "alert-success"
        ]);

        return redirect()->route('usuario.index');
    }

    public function deletar($id)
    {
        Usuarios::find($id)->delete();

        Session::flash('flash_message', [
            'msg' => "Registro excluído com sucesso!",
            'class' => "alert-success"
        ]);
        return redirect()->route('usuario.index');
    }
}
