<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Password;

class ForgotPasswordController extends Controller
{
    public function showLinkRequestForm()
    {
        return view('auth.passwords.email');
    }

    public function sendResetLinkEmail(Request $request)
    {
        // Log para rastrear a tentativa de envio do link
        Log::info('Tentativa de envio de link de redefinição de senha para o e-mail: ', ['email' => $request->email]);

        // Valida o e-mail
        $request->validate(['email' => 'required|email']);

        // Tenta enviar o link de redefinição de senha
        $status = Password::sendResetLink(
            $request->only('email')
        );

        // Verifica se o link foi enviado ou se houve erro
        return $status === Password::RESET_LINK_SENT
            ? back()->with(['status' => __($status)])
            : back()->withErrors(['email' => __($status)]);
    }

    public function showResetForm(Request $request, $token = null)
    {
        return view('auth.passwords.reset')->with(
            ['token' => $token, 'email' => $request->email]
        );
    }
}
