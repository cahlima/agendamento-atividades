<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class TestMailController extends Controller
{
    public function sendTestEmail()
    {
        $details = [
            'title' => 'Test Email from Laravel',
            'body' => 'This is a test email sent from Laravel using Mailtrap.'
        ];

        Mail::raw('This is a test email sent from Laravel using Mailtrap.', function ($message) {
            $message->from(env('MAIL_FROM_ADDRESS'), env('MAIL_FROM_NAME'));
            $message->to('test@example.com'); // Endereço de email de teste
            $message->subject('Test Email from Laravel');
        });

        return 'Test email sent!';
    }
}
