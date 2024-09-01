<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">

    <!-- Styles -->
    <link rel="stylesheet" href="{{ mix('css/app.css') }}">

    <!-- Additional CSS (if needed) -->
    @stack('styles')
</head>
<body>
    <div id="app">
        <!-- Navbar -->
        <nav class="navbar navbar-expand-lg navbar-light bg-light">
            <a class="navbar-brand" href="{{ route('paineladm') }}">
                Centro Cultural Sirius
            </a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    @if(Auth::check())
                        @can('isAdmin')
                            <li class="nav-item"><a class="nav-link" href="{{ route('paineladm') }}">Início</a></li>
                            <li class="nav-item"><a class="nav-link" href="{{ route('admin.atividades.index') }}">Gerenciar Atividades</a></li>
                            <li class="nav-item"><a class="nav-link" href="{{ route('usuarios.index') }}">Gerenciar Usuários</a></li>
                            <li class="nav-item"><a class="nav-link" href="{{ route('admin.perfil.index', ['id' => Auth::user()->id]) }}">Meu Perfil</a></li>
                        @endcan
                        @can('isAluno')
                            <li class="nav-item"><a class="nav-link" href="{{ route('aluno.painel') }}">Início</a></li>
                            <li class="nav-item"><a class="nav-link" href="{{ route('aluno.atividades.listarAluno') }}">Buscar Atividades</a></li>
                            <li class="nav-item"><a class="nav-link" href="{{ route('aluno.atividades.matriculadas') }}">Minhas Atividades</a></li>
                            <li class="nav-item"><a class="nav-link" href="{{ route('aluno.perfil.index') }}">Meu Perfil</a></li>
                        @endcan
                        @can('isProfessor')
                            <li class="nav-item"><a class="nav-link" href="{{ route('professor.painel') }}">Início</a></li>
                            <li class="nav-item"><a class="nav-link" href="{{ route('professor.atividades.matriculadas') }}">Minhas Atividades</a></li>
                            <li class="nav-item"><a class="nav-link" href="{{ route('professor.atividades.listarProfessor') }}">Buscar Atividades</a></li>
                            <li class="nav-item"><a class="nav-link" href="{{ route('professor.perfil.index') }}">Meu Perfil</a></li>
                        @endcan
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('logout') }}"
                               onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                Sair
                            </a>
                            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                @csrf
                            </form>
                        </li>
                    @else
                        <li class="nav-item"><a class="nav-link" href="{{ route('login') }}">Login</a></li>
                        <li class="nav-item"><a class="nav-link" href="{{ route('register') }}">Cadastrar-se</a></li>
                    @endif
                </ul>
            </div>
        </nav>

        <!-- Banner abaixo do navbar -->
        <div class="banner">
            <img src="/images/IMAGEM-BANNER1.jpg" alt="Banner" class="img-fluid w-100">
        </div>

        <!-- Main Content -->
        <main class="py-4">
            @yield('content')
        </main>
    </div>

    <!-- Scripts -->
    <script src="{{ mix('js/app.js') }}" defer></script>
</body>
</html>
