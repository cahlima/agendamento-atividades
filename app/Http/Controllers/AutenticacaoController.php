<?php

namespace App\Http\Controllers;


use App\Models\Usuarios;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

class AutenticacaoController extends Controller
{
    public function index()
    {
        $usuario = Auth::usuario();
        Log::info('Usuário autenticado redirecionando...', ['usuario' => $usuario]);

        if ($usuario->isAdmin()) {
            return redirect()->route('paineladm');
        } elseif ($usuario->isProfessor()) {
            return redirect()->route('painelprof');
        } elseif ($usuario->isAluno()) {
            return redirect()->route('painelaluno');
        } else {
            return redirect()->route('login');
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
        $usuario = Usuarios::where('login', $login)->first();

        if ($usuario && Hash::check($senha, $usuario->senha)) {
            Auth::login($usuario);
            $request->session()->regenerate();

            Log::info('Usuário logado com sucesso', ['usuario' => $usuario]);

            // Redirecionamento baseado no tipo de usuário
            if ($usuario->isAdmin()) {
                Log::info('Redirecionando para paineladm');
                return redirect()->intended('paineladm');
            } elseif ($usuario->isProfessor()) {
                Log::info('Redirecionando para painelprof');
                return redirect()->intended('painelprof');
            } elseif ($usuario->isAluno()) {
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

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/login')->with('success', 'Você foi deslogado com sucesso.');
    }
}
