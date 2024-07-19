<?php

namespace App\Actions\Fortify;

use Laravel\Fortify\Contracts\ResetPasswordViewResponse as ResetPasswordViewResponseContract;

class ResetPasswordResponse implements ResetPasswordViewResponseContract
{
    public function toResponse($request)
    {
        return view('auth.passwords.reset', ['request' => $request]);
    }
}
