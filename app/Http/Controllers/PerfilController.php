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
                'name' => 'required|string|max:255',
                'email' => 'required|string|email|max:255|unique:users,email,' . $usuario->id,
                // Inclua outras validações conforme necessário
            ]);

            // Atualização dos dados do usuário
            $usuario->update([
                'name' => $request->name,
                'email' => $request->email,
                // Inclua outras atualizações conforme necessário
            ]);

            return redirect()->route('perfil.edit')->with('success', 'Perfil atualizado com sucesso!');
        }
    }


