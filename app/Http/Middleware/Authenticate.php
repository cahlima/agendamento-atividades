<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Auth\Middleware\Authenticate as Middleware;

class Authenticate extends Middleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string[]  ...$guards
     * @return mixed
     */
    public function handle($request, Closure $next, ...$guards)
    {
        // Verifica se a rota é a rota usuario/adicionar
        if ($request->is('usuario/adicionar')) {
            return $next($request); // Permite o acesso sem autenticação
        }

        // Verifica se o usuário está autenticado para outras rotas
        return parent::handle($request, $next, ...$guards);
    }
}
