<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Default Mailer
    |--------------------------------------------------------------------------
    |
    | Este mailer será usado para enviar qualquer e-mail enviado pelo
    | aplicativo. Você pode definir isso para qualquer um dos mailers definidos
    | abaixo.
    |
    */

    'default' => env('MAIL_MAILER', 'smtp'),

    /*
    |--------------------------------------------------------------------------
    | Mailer Configurations
    |--------------------------------------------------------------------------
    |
    | Aqui você pode definir todas as configurações de mailers usadas pelo seu
    | aplicativo, além de suas respectivas configurações. Vários exemplos
    | foram configurados para você, e você é livre para adicionar os seus.
    |
    | Laravel suporta vários "transportes" de e-mail para ser usado enquanto
    | você envia um e-mail. Você especificará qual um você está usando para
    | seus mailers abaixo. Você é livre para adicionar quantos quiser.
    |
    | Supported: "smtp", "sendmail", "mailgun", "ses",
    |            "postmark", "log", "array"
    |
    */

    'mailers' => [
        'smtp' => [
            'transport' => 'smtp',
            'host' => env('MAIL_HOST', 'smtp.mailtrap.io'),
            'port' => env('MAIL_PORT', 2525),
            'encryption' => env('MAIL_ENCRYPTION', null),
            'username' => env('MAIL_USERNAME'),
            'password' => env('MAIL_PASSWORD'),
            'timeout' => null,
            'auth_mode' => null,
        ],

        'sendmail' => [
            'transport' => 'sendmail',
            'path' => '/usr/sbin/sendmail -bs',
        ],

        'log' => [
            'transport' => 'log',
            'channel' => env('MAIL_LOG_CHANNEL'),
        ],

        'array' => [
            'transport' => 'array',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Global "From" Address
    |--------------------------------------------------------------------------
    |
    | Você pode desejar que todos os e-mails enviados pelo seu aplicativo
    | sejam enviados de um mesmo endereço. Aqui, você pode especificar um nome
    | e endereço que será usado globalmente para todos os e-mails enviados
    | pelo seu aplicativo.
    |
    */

    'from' => [
        'address' => env('MAIL_FROM_ADDRESS', 'from@example.com'),
        'name' => env('MAIL_FROM_NAME', 'Example'),
    ],

    /*
    |--------------------------------------------------------------------------
    | Markdown Mail Settings
    |--------------------------------------------------------------------------
    |
    | Se você estiver usando Markdown para renderizar seus e-mails, você pode
    | configurar seu tema e componente aqui. Ou você pode simplesmente ficar
    | com os valores padrão do Laravel.
    |
    */

    'markdown' => [
        'theme' => 'default',

        'paths' => [
            resource_path('views/vendor/mail'),
        ],
    ],

];
