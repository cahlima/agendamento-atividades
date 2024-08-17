<nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
    <div class="container">
        <a class="navbar-brand" href="{{ url('/') }}">
            <!-- Nome do aplicativo -->
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <!-- Left Side Of Navbar -->
            <ul class="navbar-nav me-auto">
                @guest
                    @if (Route::has('login'))
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                        </li>
                    @endif
                @else
                    @if (Auth::user()->isAdmin())
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('admin.painel') }}">{{ __('Painel Administrativo') }}</a>
                        </li>
                    @endif

                    @if (Auth::user()->isProfessor())
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('professor.painel') }}">{{ __('Painel do Professor') }}</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('atividades.matriculadas') }}">{{ __('Minhas Atividades') }}</a>
                        </li>
                    @endif

                    @if (Auth::user()->isAluno())
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('aluno.painel') }}">{{ __('Painel do Aluno') }}</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('atividades.listarAtividades') }}">{{ __('Atividades Disponíveis') }}</a>
                        </li>
                    @endif
                @endguest
            </ul>

            <!-- Right Side Of Navbar -->
            <ul class="navbar-nav ms-auto">
                @guest
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                    </li>
                @else
                    <li class="nav-item dropdown">
                        <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            {{ Auth::user()->nome }}
                        </a>

                        <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
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
