<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Painel de Aluno') }}</title>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])
</head>
<body>
    <div id="app">
        @include('layouts._includes._nav')

        <main class="py-4">
            @yield('content')
        </main>
    </div>

    <div id="vue-app"></div>

    <!-- Scripts -->
    @vite('resources/js/app.js')

    <script>
        window.addEventListener('beforeunload', function (e) {
            navigator.sendBeacon('{{ route("logout") }}', '');
        });
    </script>
</body>
</html>
