@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row">
        <!-- Sidebar -->
        <nav id="sidebar" class="col-md-3 col-lg-2 d-md-block bg-light sidebar fixed">
            <div class="position-sticky">
                <ul class="nav flex-column">
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('paineladm') }}">
                            {{ __('Início') }}
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('atividades.index') }}">
                            {{ __('Gerenciar Atividades') }}
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('usuarios.index') }}">
                            {{ __('Gerenciar Usuários') }}
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="{{ route('admin.perfil.edit') }}">
                            {{ __('Meu Perfil') }}
                        </a>
                    </li>
                </ul>
            </div>
        </nav>

        <!-- Main content -->
        <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
            <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                <h1 class="h2">{{ __('Editar Perfil do Administrador') }}</h1>
            </div>

            @if(Session::has('flash_message'))
                <div class="alert {{ Session::get('flash_message.class') }}">
                    {{ Session::get('flash_message.msg') }}
                </div>
            @endif

            <form action="{{ route('admin.perfil.update') }}" method="POST">
                @csrf
                @method('PUT')
                <div class="form-group">
                    <label for="nome">{{ __('Nome') }}</label>
                    <input type="text" class="form-control" id="nome" name="nome" value="{{ Auth::user()->nome }}" required>
                </div>
                <div class="form-group">
                    <label for="email">{{ __('Email') }}</label>
                    <input type="email" class="form-control" id="email" name="email" value="{{ Auth::user()->email }}" required>
                </div>
                <div class="form-group">
                    <label for="senha">{{ __('Senha') }}</label>
                    <input type="password" class="form-control" id="senha" name="senha">
                </div>
                <div class="form-group">
                    <label for="password_confirmation">{{ __('Confirmar Senha') }}</label>
                    <input type="password" class="form-control" id="password_confirmation" name="password_confirmation">
                </div>
                <button type="submit" class="btn btn-success mt-3">{{ __('Salvar') }}</button>
                <a href="{{ route('paineladm') }}" class="btn btn-secondary mt-3">{{ __('Voltar') }}</a>
            </form>
        </main>
    </div>
</div>
@endsection
