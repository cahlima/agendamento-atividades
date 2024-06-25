<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class NotificaUsuarioMatricula extends Notification
{
    use Queueable;

    protected $usuario;
    protected $matricula;

    public function __construct($usuario, $matricula)
    {
        $this->usuario = $usuario;
        $this->matricula = $matricula;
    }

    public function via($notifiable)
    {
        return ['mail'];
    }

    public function toMail($notifiable)
    {
        return (new MailMessage)
                    ->line('Você foi matriculado com sucesso.')
                    ->action('Ver Matrícula', url('/matriculas/'.$this->matricula->id))
                    ->line('Obrigado por usar nosso aplicativo!');
    }
}
