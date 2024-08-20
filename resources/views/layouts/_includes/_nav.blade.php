<nav class="navbar navbar-expand-lg navbar-dark bg-dark shadow-sm">
    <div class="container">
        <a class="navbar-brand" href="{{ url('/') }}">
            <img src="{{ asset('images/IMAGEM-BANNER1.webp') }}" alt="Logo" class="img-fluid" style="max-height: 40px;">
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto">
                @auth
                    <!-- Itens dinâmicos para diferentes tipos de usuário -->
                    @if (Auth::user()->isAdmin())
                        <li class="nav-item"><a class="nav-link" href="{{ route('admin.painel') }}">Admin</a></li>
                    @endif
                    <li class="nav-item"><a class="nav-link" href="{{ route('atividades.matriculadas') }}">Minhas Atividades</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Sair</a></li>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">@csrf</form>
                @else
                    <li class="nav-item"><a class="nav-link" href="{{ route('login') }}">Login</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ route('register') }}">Registrar</a></li>
                @endauth
            </ul>
        </div>
    </div>
</nav>
