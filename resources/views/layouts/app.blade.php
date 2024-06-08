<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laravel</title>
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            display: flex;
            min-height: 100vh;
            flex-direction: column;
        }
        #header {
            background: url('/path/to/your/image.png') no-repeat center center;
            background-size: cover;
            height: 200px;
            width: 100%;
        }
        #sidebar {
            min-width: 200px;
            max-width: 200px;
            background: #343a40;
            padding: 20px;
        }
        #sidebar .nav-link {
            color: #ffffff;
        }
        #sidebar .nav-link:hover {
            background: #495057;
        }
        #content {
            flex: 1;
            padding: 20px;
        }
    </style>
</head>
<body>
    @auth
        <div id="header"></div>
        <div class="d-flex">
            <div id="sidebar" class="bg-dark">
                <ul class="nav flex-column">
                    <li class="nav-item">
                        <a class="nav-link" href="#">{{ __('Bem-vindo(a), ') }}{{ Auth::user()->nome }}</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('atividades.index') }}">Consultar Atividades</a>
                    </li>
                    @if (Auth::user()->type == 'admin')
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('admin.atividades.create') }}">Cadastrar Atividades</a>
                        </li>
                    @endif
                    @if (Auth::user()->type == 'professor')
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('atividades.professor') }}">Minhas Atividades</a>
                        </li>
                    @endif
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('usuario.editar', Auth::user()->id) }}">Meu Perfil</a>
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
                </ul>
            </div>
            <div id="content">
                @yield('content')
            </div>
        </div>
    @else
        <div id="content" class="container">
            @yield('content')
        </div>
    @endauth
</body>
</html>
