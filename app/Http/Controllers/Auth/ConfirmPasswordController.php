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

        $user = Auth::usuario();

        if (!Hash::check($request->password, $user->password)) {
            return back()->withErrors(['password' => 'Senha incorreta.']);
        }

        if ($user->isAdmin()) {
            return redirect()->intended('/PerfilAdm');
        } elseif ($user->isProfessor()) {
            return redirect()->intended('/PerfilProf');
        } elseif ($user->isAluno()) {
            return redirect()->intended('/PerfilAluno');
        }

        return redirect()->intended($this->redirectTo);
    }
}
