<?php

namespace App\Listeners;

use App\Models\Usuarios;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Notifications\NotificaUsuario;

class NotificaUsuarioMatricula
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  object  $event
     * @return void
     */
    public function handle($event)
    {
        $usuario = Usuarios::find($event->usuario->id);

        $usuario->notify(new NotificaUsuarioMatricula($usuario));
    }
}
