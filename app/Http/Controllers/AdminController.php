<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Usuarios;
use App\Models\Atividades;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
    public function index()
    {
        return view('administrador.usuarios.index');
    }

    public function usuariosIndex()
    {
        $usuarios = Usuarios::all();
        return view('administrador.usuarios.index', compact('usuarios'));
    }

    public function usuariosCreate()
    {
        return view('administrador.usuarios.create');
    }

    public function usuariosStore(Request $request)
    {
        $data = $request->validate([
            'nome' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:usuarios',
            'password' => 'required|string|min:8|confirmed',
            'tipo_id' => 'required|integer|exists:tipos,id',
        ]);

        Usuarios::create([
            'nome' => $data['nome'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'tipo_id' => $data['tipo_id'],
        ]);

        return redirect()->route('admin.usuarios.index')->with('success', 'Usuário criado com sucesso.');
    }

    public function usuariosEdit($id)
    {
        $usuario = Usuarios::findOrFail($id);
        return view('administrador.usuarios.edit', compact('usuario'));
    }

    public function usuariosUpdate(Request $request, $id)
    {
        $usuario = Usuarios::findOrFail($id);

        $data = $request->validate([
            'nome' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:usuarios,email,' . $usuario->id,
            'tipo_id' => 'required|integer|exists:tipos,id',
        ]);

        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }

        $usuario->update($data);

        return redirect()->route('admin.usuarios.index')->with('success', 'Usuário atualizado com sucesso.');
    }

    public function usuariosDestroy($id)
    {
        $usuario = Usuarios::findOrFail($id);
        $usuario->delete();

        return redirect()->route('admin.usuarios.index')->with('success', 'Usuário deletado com sucesso.');
    }

    public function atividadesIndex()
    {
        $atividades = Atividades::all();
        return view('administrador.atividades.index', compact('atividades'));
    }

    public function atividadesCreate()
    {
        return view('administrador.atividades.create');
    }

    public function atividadesStore(Request $request)
    {
        $data = $request->validate([
            'titulo' => 'required|string|max:255',
            'descricao' => 'nullable|string',
            'usuario_id' => 'required|exists:usuarios,id',
        ]);

        Atividades::create($data);

        return redirect()->route('admin.atividades.index')->with('success', 'Atividade criada com sucesso.');
    }

    public function atividadesEdit($id)
    {
        $atividade = Atividades::findOrFail($id);
        return view('administrador.atividades.edit', compact('atividade'));
    }

    public function atividadesUpdate(Request $request, $id)
    {
        $atividade = Atividades::findOrFail($id);

        $data = $request->validate([
            'titulo' => 'required|string|max:255',
            'descricao' => 'nullable|string',
            'usuario_id' => 'required|exists:usuarios,id',
        ]);

        $atividade->update($data);

        return redirect()->route('admin.atividades.index')->with('success', 'Atividade atualizada com sucesso.');
    }

    public function atividadesDestroy($id)
    {
        $atividade = Atividades::findOrFail($id);
        $atividade->delete();

        return redirect()->route('admin.atividades.index')->with('success', 'Atividade deletada com sucesso.');
    }

    public function perfilEdit()
    {
        $usuario = Auth::user();
        return view('administrador.perfil.edit', compact('usuario'));
    }

    public function perfilUpdate(Request $request)
    {
        $usuario = Auth::user();

        $data = $request->validate([
            'nome' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:usuarios,email,' . $usuario->id,
        ]);

        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }

        $usuario->update($data);

        return redirect()->route('admin.perfil.edit')->with('success', 'Perfil atualizado com sucesso.');
    }
}
