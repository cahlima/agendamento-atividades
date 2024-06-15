<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    use AuthenticatesUsers;

    /**
     * Cria um novo controller
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    /**
     * Get the post-authentication redirect path.
     *
     * @return string
     */
    protected function redirectTo()
    {
        // Verifica o tipo de usuário para redirecionar adequadamente
        if (Auth::usuario()->isAdmin()) {
            return '/paineladm'; // Rota para o dashboard administrativo
        } elseif (Auth::usuario()->isProfessor()) {
            return '/painelprof'; // Rota para o dashboard de professores
        } elseif (Auth::usuario()->isAluno()){
            return '/painelaluno'; // Rota para o painel de alunos
        } else {
            return RouteServiceProvider::HOME; // Rota padrão para outros usuários
        }
    }

    /**
     * Handle user logout and redirect to the login page.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/login');
    }
}

