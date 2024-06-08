<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Atividades;
use App\Models\Usuarios;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class ProfessoresController extends Controller
{

    public function index()
    {
        return view('professor.painelprof');
    }
    public function ProfatividadesIndex()
    {
        $atividades = Atividades::paginate(10);
        return view('professor.atividades.index', compact('atividades'));
    }

    public function minhasAtividades()
    {
        $atividades = Atividades::where('usuario_id', Auth::id())->paginate(10);
        return view('professor.atividades.matriculadas', compact('atividades'));
    }

    public function perfilEdit()
    {
        $usuario = Auth::usuario();
        return view('professor.perfil.edit', compact('usuario'));
    }

    public function perfilUpdate(Request $request)
    {
        $usuario = Auth::usuario();

        $data = $request->validate([
            'nome' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $usuario->id,
        ]);

        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }

        $usuario->getAuthIdentifier($data);

        return redirect()->route('professor.perfil.edit')->with('success', 'Perfil atualizado com sucesso.');
    }
}
