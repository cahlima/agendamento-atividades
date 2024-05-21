<!DOCTYPE html>
<html lang="en">
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
    <div id="header"></div>
    <div class="d-flex">
        <div id="sidebar" class="bg-dark">
            <ul class="nav flex-column">
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('paineladm') }}">Painel Administrativo</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('matricula.geral') }}">Matrículas Geral</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('atividades.index') }}">Atividades Geral</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('usuario.index') }}">Usuários</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('tipo.index') }}">Tipos de Usuários</a>
                </li>
            </ul>
        </div>
        <div id="content">
            @yield('content')
        </div>
    </div>
</body>
</html>
