<?php
namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Usuarios;


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
            return '/admin'; // Rota para o dashboard administrativo
        } elseif (Auth::usuario()->isProfessor()) {
            return '/professor/home'; // Rota para o dashboard de professores
        } else {
            return RouteServiceProvider::HOME; // Rota padrão para usuários comuns
        }
    }
}
