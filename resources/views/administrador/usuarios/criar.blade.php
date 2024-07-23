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
                        <a class="nav-link active" aria-current="page" href="{{ route('usuarios.index') }}">
                            {{ __('Gerenciar Usuários') }}
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('admin.perfil.edit') }}">
                            {{ __('Meu Perfil') }}
                        </a>
                    </li>
                </ul>
            </div>
        </nav>

        <!-- Main content -->
        <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
            <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                <h2>{{ __('Adicionar Usuário') }}</h2>
            </div>

            @if(Session::has('flash_message'))
                <div class="alert {{ Session::get('flash_message.class') }}">
                    {{ Session::get('flash_message.msg') }}
                </div>
            @endif

            <form action="{{ route('usuarios.store') }}" method="POST">
                @csrf
                <div class="mb-3">
                    <label for="nome" class="form-label">{{ __('Nome') }}</label>
                    <input type="text" class="form-control" id="nome" name="nome" value="{{ old('nome') }}" required>
                </div>
                <div class="mb-3">
                    <label for="sobrenome" class="form-label">{{ __('Sobrenome') }}</label>
                    <input type="text" class="form-control" id="sobrenome" name="sobrenome" value="{{ old('sobrenome') }}" required>
                </div>
                <div class="mb-3">
                    <label for="login" class="form-label">{{ __('Login') }}</label>
                    <input type="text" class="form-control" id="login" name="login" value="{{ old('login') }}" required>
                </div>
                <div class="mb-3">
                    <label for="email" class="form-label">{{ __('Email') }}</label>
                    <input type="email" class="form-control" id="email" name="email" value="{{ old('email') }}" required>
                </div>
                <div class="mb-3">
                    <label for="senha" class="form-label">{{ __('Senha') }}</label>
                    <input type="password" class="form-control" id="senha" name="senha" required>
                </div>
                <div class="mb-3">
                    <label for="password_confirmation" class="form-label">{{ __('Confirmar Senha') }}</label>
                    <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" required>
                </div>
                <div class="mb-3">
                    <label for="data_nascimento" class="form-label">{{ __('Data de Nascimento') }}</label>
                    <input type="date" class="form-control" id="data_nascimento" name="data_nascimento" value="{{ old('data_nascimento') }}" required>
                </div>
                <div class="mb-3">
                    <label for="telefone" class="form-label">{{ __('Telefone') }}</label>
                    <input type="text" class="form-control" id="telefone" name="telefone" value="{{ old('telefone') }}" required>
                </div>
                <div class="mb-3">
                    <label for="tipo_id" class="form-label">{{ __('Tipo') }}</label>
                    <select class="form-control" id="tipo_id" name="tipo_id" required>
                        @foreach($tipos as $tipo)
                        <option value="{{ $tipo->id }}">{{ $tipo->nome }}</option>
                        @endforeach
                    </select>
                </div>
                <button type="submit" class="btn btn-success">{{ __('Salvar') }}</button>
                <a href="{{ route('usuarios.index') }}" class="btn btn-secondary">{{ __('Voltar') }}</a>
            </form>
        </main>
    </div>
</div>
@endsection
