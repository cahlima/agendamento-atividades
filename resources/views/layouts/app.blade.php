<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
    @vite(['resources/sass/app.scss'])
</head>
<body>
    <div id="app">
        <nav class="navbar navbar-expand-lg navbar-light bg-light">
            <a class="navbar-brand" href="{{ route('paineladm') }}">Painel Administrativo</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ml-auto">
                    @if(Auth::check())
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('paineladm') }}">Início</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('admin.atividades.index') }}">Gerenciar Atividades</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('usuarios.index') }}">Gerenciar Usuários</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('admin.perfil.index', ['id' => Auth::user()->id]) }}">Meu Perfil</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('logout') }}"
                               onclick="event.preventDefault();
                               document.getElementById('logout-form').submit();">
                                Sair
                            </a>
                            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                @csrf
                            </form>
                        </li>
                    @else
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('login') }}">Login</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('register') }}">Cadastrar-se</a>
                        </li>
                    @endif
                </ul>
            </div>
        </nav>

        <main class="py-4">
            @yield('content')
            <!-- Remover ou comentar essa linha -->
            <!-- <example-component></example-component> -->
        </main>
    </div>

    <!-- Vue App Mount Point -->
    <div id="vue-app"></div>

    <!-- Scripts -->
    @vite(['resources/js/app.js'])

    @yield('scripts')
</body>
</html>
