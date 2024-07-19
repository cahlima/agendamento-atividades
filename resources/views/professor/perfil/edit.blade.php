@extends('layouts.base')

@section('content')
<div class="container-fluid">
    <div class="row">
        <!-- Sidebar -->
        <nav id="sidebar" class="col-md-3 col-lg-2 d-md-block bg-light sidebar fixed">
            <div class="position-sticky">
                <ul class="nav flex-column">
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('professor.atividades.listar') }}">
                            {{ __('Atividades Disponíveis') }}
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('professor.atividades.matriculadas') }}">
                            {{ __('Minhas Atividades') }}
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('professor.perfil.edit') }}">
                            {{ __('Meu Perfil') }}
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                            {{ __('Sair') }}
                        </a>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                            @csrf
                        </form>
                    </li>
                </ul>
            </div>
        </nav>

        <!-- Main content -->
        <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
            <h2>{{ __('Editar Perfil') }}</h2>

            <form action="{{ route('professor.perfil.update') }}" method="POST">
                @csrf
                <div class="mb-3 row">
                    <label for="nome" class="col-sm-2 col-form-label">{{ __('Nome') }}</label>
                    <div class="col-sm-10">
                        <div class="input-group">
                            <input type="text" class="form-control" id="nome" name="nome" value="{{ $usuario->nome }}" readonly>
                            <button class="btn btn-outline-primary" type="button" onclick="enableEditing('nome')">Editar</button>
                        </div>
                    </div>
                </div>
                <div class="mb-3 row">
                    <label for="email" class="col-sm-2 col-form-label">{{ __('Email') }}</label>
                    <div class="col-sm-10">
                        <input type="email" class="form-control" id="email" name="email" value="{{ $usuario->email }}" readonly>
                    </div>
                </div>
                <div class="mb-3 row">
                    <label for="password" class="col-sm-2 col-form-label">{{ __('Senha') }}</label>
                    <div class="col-sm-10">
                        <div class="input-group">
                            <input type="password" class="form-control" id="password" name="password" placeholder="Deixe em branco se não quiser alterar a senha" readonly>
                            <button class="btn btn-outline-primary" type="button" onclick="enableEditing('password')">Editar</button>
                        </div>
                    </div>
                </div>
                <div class="mb-3 row">
                    <label for="password_confirmation" class="col-sm-2 col-form-label">{{ __('Confirmar Senha') }}</label>
                    <div class="col-sm-10">
                        <div class="input-group">
                            <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" placeholder="Deixe em branco se não quiser alterar a senha" readonly>
                            <button class="btn btn-outline-primary" type="button" onclick="enableEditing('password_confirmation')">Editar</button>
                        </div>
                    </div>
                </div>
                <button type="submit" class="btn btn-primary">{{ __('Salvar') }}</button>
                <a href="{{ route('professor.atividades.listar') }}" class="btn btn-secondary">{{ __('Voltar') }}</a> <!-- Botão Voltar adicionado -->
            </form>
        </main>
    </div>
</div>

<script>
    function enableEditing(fieldId) {
        document.getElementById(fieldId).removeAttribute('readonly');
    }
</script>
@endsection
