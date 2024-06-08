<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use App\Models\Usuarios;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;

class RegisterController extends Controller
{
    use RegistersUsers;

    protected $redirectTo = RouteServiceProvider::HOME;

    public function __construct()
    {
        $this->middleware('guest');
    }

    public function showRegistrationForm()
    {
        return view('auth.register');
    }

    protected function validator(array $data)
    {
        Log::info('Validando dados de registro', $data);

        return Validator::make($data, [
            'nome' => ['required', 'string', 'max:255'],
            'sobrenome' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:usuarios'],
            'data_nascimento' => ['required', 'date'],
            'telefone' => ['required', 'string', 'max:15'],
            'login' => ['required', 'string', 'max:255', 'unique:usuarios'],
            'senha' => ['required', 'string', 'min:8', 'confirmed'],
        ]);
    }

    protected function create(array $data)
    {
        Log::info('Criando novo usuário', $data);

        // Aqui garantimos que o tipo_id seja sempre 3 (aluno) para novos registros
        $usuario = Usuarios::create([
            'nome' => $data['nome'],
            'sobrenome' => $data['sobrenome'],
            'email' => $data['email'],
            'data_nascimento' => $data['data_nascimento'],
            'telefone' => $data['telefone'],
            'login' => $data['login'],
            'senha' => Hash::make($data['senha']),
            'tipo_id' => 3,  // Definido como aluno
        ]);

        Log::info('Usuário criado com sucesso', ['usuario_id' => $usuario->id]);

        return $usuario;
    }

    protected function registered(Request $request, $usuario)
    {
        Log::info('Usuário registrado com sucesso', ['usuario_id' => $usuario->id]);

        // Redirecionar usuários do tipo 3 para a página do painel do aluno
        if ($usuario->tipo_id == 3) {
            return redirect('/painelaluno')->with('success', 'Cadastro realizado com sucesso!');
        }

        return redirect($this->redirectPath())->with('success', 'Cadastro realizado com sucesso!');
    }
}
