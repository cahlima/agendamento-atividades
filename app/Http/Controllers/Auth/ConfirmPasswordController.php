<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Providers\RouteServiceProvider;
use App\Models\Usuarios;

class ConfirmPasswordController extends Controller
{
    /**
     * Onde redirecionar usuários quando a URL pretendida falhar.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Cria uma nova instância do controlador.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Mostra o formulário de confirmação de senha.
     *
     * @return \Illuminate\View\View
     */
    public function showConfirmForm()
    {
        return view('auth.confirm-password');
    }

    /**
     * Processa a confirmação de senha.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function confirm(Request $request)
    {
        $request->validate([
            'password' => 'required|string',
        ]);

        $usuario = Auth::usuario();

        if (!Hash::check($request->password, $usuario->password)) {
            return back()->withErrors(['password' => 'Senha incorreta.']);
        }

        if ($usuario->isAdmin()) {
            return redirect()->intended('/PerfilAdm');
        } elseif ($usuario->isProfessor()) {
            return redirect()->intended('/PerfilProf');
        } elseif ($usuario->isAluno()) {
            return redirect()->intended('/PerfilAluno');
        }

        return redirect()->intended($this->redirectTo);
    }
}
