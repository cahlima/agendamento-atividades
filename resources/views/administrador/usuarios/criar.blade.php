@extends('layouts.app')

@section('title', 'Adicionar Usuário')

@section('content')
<div class="container mt-5">
    <div class="card card-custom">
    <div class="card-body">
            <h2>{{ __('Adicionar Usuário') }}</h2>
        </div>
        <div class="card-body">
            @if(Session::has('flash_message'))
                <div class="alert alert-success">{{ Session::get('flash_message')['msg'] }}</div>
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
        </div>
    </div>
</div>
@endsection
