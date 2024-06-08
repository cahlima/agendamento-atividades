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

    public function profAtividadesIndex()
    {
        $atividades = Atividades::paginate(10);
        return view('professor.atividades.index', compact('atividades'));
    }


    public function minhasAtividades()
    {
        $usuario = Auth::user();
        \Log::info('Usuario: ', ['usuario' => $usuario]);
        $atividades = $usuario->atividades()->paginate(10);
        \Log::info('Atividades: ', ['atividades' => $atividades]);
        return view('professor.atividades.matriculadas', compact('atividades'));
    }
    public function perfilEdit()
    {
        $usuario = Auth::user();
        return view('professor.perfil.edit', compact('usuario'));
    }

    public function perfilUpdate(Request $request)
    {
        $usuario = Auth::user();

        $data = $request->validate([
            'nome' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:usuarios,email,' . $usuario->id,
            'password' => 'nullable|string|min:8|confirmed',
        ]);

        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }

        $usuario->update($data);

        return redirect()->route('professor.perfil.edit')->with('success', 'Perfil atualizado com sucesso.');
    }
}
