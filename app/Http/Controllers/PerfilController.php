<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PerfilController extends Controller
{
    /**
     * Mostra o formulário para editar o perfil do usuário autenticado.
     */
    public function edit()
    {
        $usuario = Auth::usuario(); // Pega o usuário atualmente autenticado
        return view('admin.perfil.edit', compact('usuario')); // Retorna a view com os dados do usuário
    }

    /**
     * Atualiza os dados do perfil do usuário autenticado.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request)
    {
        $usuario = Auth::usuario(); // Pega o usuário atualmente autenticado

        // Validação dos dados submetidos
        $request->validate([
            'nome' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:usuarios,email,' . $usuario->id,
            'senha' => 'nullable|string|min:6|confirmed', // Confirmação de senha
        ]);

        // Atualização dos dados do usuário
        $usuario->nome = $request->nome;
        $usuario->email = $request->email;
        if ($request->senha) {
            $usuario->senha = bcrypt($request->senha); // Criptografando a senha se foi informada
        }
        $usuario->save();

        return redirect()->route('admin.perfil.edit')->with('success', 'Perfil atualizado com sucesso!');
    }
}

