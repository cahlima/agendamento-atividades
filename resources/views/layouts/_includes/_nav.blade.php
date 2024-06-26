<!-- resources/views/nav.blade.php -->

<nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
    <div class="container">
        <a class="navbar-brand" href="{{ url('/') }}">
            {{ config('app.name', 'Laravel') }}
        </a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
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
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('paineladm') }}">{{ __('Painel Administrativo') }}</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('matriculageral') }}">{{ __('Matriculas Geral') }}</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('atividades.listar') }}">{{ __('Atividades Geral') }}</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('usuario.index') }}">{{ __('Usuários') }}</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('tipo.index') }}">{{ __('Tipos Usuários') }}</a>
                        </li>
                    @endif

                    @if (Auth::user()->isProfessor())
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('matricula.index') }}">{{ __('Atividades Aprovação') }}</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('professor') }}">{{ __('Gerenciar Atividades') }}</a>
                        </li>
                    @endif

                    @if (Auth::user()->isAluno())
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('matricula.aluno') }}">{{ __('Meus Matriculamentos') }}</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('atividades.listar') }}">{{ __('Atividades') }}</a>
                        </li>
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
