<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Illuminate\Support\Facades\Log;

class AutenticacaoController extends Controller
{
    public function index()
    {
        $user = Auth::usuario();
        Log::info('Usuário autenticado redirecionando...', ['user' => $user]);
        if ($user->isAdmin()) {
            return redirect()->route('paineladm');

        } elseif ($user->isProfessor()) {
            return redirect()->route('painelprof');

        } elseif ($user->isAluno()) {
            return redirect()->route('painelaluno');
        } else {
            return redirect()->route('home');
        }
    }

    public function login()
    {
        return view('login');
    }

    public function logindo(Request $request)
    {
        $request->validate([
            'login' => 'required',
            'senha' => 'required',
        ]);

        $login = $request->input('login');
        $senha = $request->input('senha');
        $user = User::where('login', $login)->first();
        if ($user && Hash::check($senha, $user->senha)) {
            Auth::login($user);
            $request->session()->regenerate();

            Log::info('Usuário logado com sucesso', ['user' => $user]);

            // Redirecionamento baseado no tipo de usuário
            if ($user->isAdmin()) {
                Log::info('Redirecionando para paineladm');
                return redirect()->intended('paineladm');
            } elseif ($user->isProfessor()) {
                Log::info('Redirecionando para painelprof');
                return redirect()->intended('painelprof');
            } elseif ($user->isAluno()) {
                Log::info('Redirecionando para painelaluno');
                return redirect()->intended('painelaluno');
            } else {
                Log::info('Redirecionando para home');
                return redirect()->intended('home');
            }
        } else {
            Log::info('Credenciais inválidas', ['login' => $login]);
            return redirect()->route('login')->withErrors(['login' => 'As credenciais fornecidas não correspondem aos nossos registros.']);
        }
    }

    public function logout()
    {
        Auth::logout();
        request()->session()->invalidate();
        request()->session()->regenerateToken();
        return redirect()->route('login');
    }
}
