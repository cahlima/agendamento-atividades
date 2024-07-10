<!-- resources/views/layouts/_includes/nav.blade.php -->

<nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
    <div class="container">
        <a class="navbar-brand" href="{{ url('/') }}">
            <!-- Removido para não exibir 'Laravel' -->
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <!-- Left Side Of Navbar -->
            <ul class="navbar-nav mr-auto">
                @guest
                    @if (Route::has('login'))
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                        </li>
                    @endif
                @else
                    @if (Auth::user()->isAdmin())
                        <!-- Links removidos para administradores -->
                        <!-- <li class="nav-item">
                            <a class="nav-link" href="{{ route('paineladm') }}">{{ __('Painel Administrativo') }}</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('matricula.geral') }}">{{ __('Matriculas Geral') }}</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('atividades.listar') }}">{{ __('Atividades Cadastradas') }}</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('usuario.index') }}">{{ __('Usuários') }}</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('tipo.index') }}">{{ __('Tipos Usuários') }}</a>
                        </li> -->
                    @endif

                    @if (Auth::user()->isProfessor())
                        <!-- Links removidos para professores -->
                        <!-- <li class="nav-item">
                            <a class="nav-link" href="{{ route('atividades.listar') }}">{{ __('Atividades Disponiveis') }}</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('painelprof') }}">{{ __('Gerenciar Minhas Atividades') }}</a>
                        </li> -->
                    @endif

                    @if (Auth::user()->isAluno())
                        <!-- Links removidos para alunos -->
                        <!-- <li class="nav-item">
                            <a class="nav-link" href="{{ route('matricula.aluno') }}">{{ __('Realizar Matricula') }}</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('atividades.listar') }}">{{ __('Atividades Disponiveis') }}</a>
                        </li> -->
                    @endif
                @endguest
            </ul>

            <!-- Right Side Of Navbar -->
            <ul class="navbar-nav ml-auto">
                @guest
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                    </li>
                @else
                    <li class="nav-item dropdown">
                        <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                            {{ Auth::user()->nome }}
                        </a>

                        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                            <a class="dropdown-item" href="{{ route('logout') }}"
                               onclick="event.preventDefault();
                                             document.getElementById('logout-form').submit();">
                                {{ __('Logout') }}
                            </a>

                            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                @csrf
                            </form>
                        </div>
                    </li>
                @endguest
            </ul>
        </div>
    </div>
</nav>
