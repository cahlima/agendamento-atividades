<?php
namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

class ResetPasswordController extends Controller
{
    public function __construct()
    {
        $this->middleware('guest');
    }

    // Exibe o formulário para redefinir a senha
    public function showResetForm(Request $request, $token = null)
    {
        return view('auth.passwords.reset')->with(
            ['token' => $token, 'email' => $request->email]
        );
    }

    // Reseta a senha do usuário
    public function reset(Request $request)
    {
        // Validação dos dados de entrada
        $validator = Validator::make($request->all(), [
            'token' => 'required',
            'email' => 'required|email',
            'senha' => 'required|min:8|confirmed',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        // Tentativa de resetar a senha
        $status = Password::reset(
            $request->only('email', 'senha', 'senha_confirmation', 'token'),
            function ($user, $senha) {
                $user->forceFill([
                    'senha' => Hash::make($senha),
                    'remember_token' => Str::random(60),
                ])->save();
            }
        );

        // Verificação do status do reset
        if ($status == Password::PASSWORD_RESET) {
            Session::flash('flash_message', 'Senha redefinida com sucesso!');
            return redirect()->route('login')->with('status', __($status));
        }

        // Exceção em caso de falha no reset
        throw ValidationException::withMessages([
            'email' => [trans($status)],
        ]);
    }
}
