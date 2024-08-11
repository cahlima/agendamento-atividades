@extends('layouts.app')

@section('title', 'Editar Usuário')

@section('content')
<div class="container mt-5">
    <div class="card">
        <div class="card-header">
            <h2>{{ __('Editar Usuário') }}</h2>
        </div>
        <div class="card-body">
            @if(Session::has('flash_message'))
                <div class="alert alert-success">{{ Session::get('flash_message') }}</div>
            @endif

            <form action="{{ route('usuarios.update', ['id' => $usuario->id]) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="form-group">
                    <label for="nome">{{ __('Nome') }}</label>
                    <input type="text" class="form-control" id="nome" name="nome" value="{{ old('nome', $usuario->nome) }}" required>
                </div>
                <div class="form-group">
                    <label for="sobrenome">{{ __('Sobrenome') }}</label>
                    <input type="text" class="form-control" id="sobrenome" name="sobrenome" value="{{ old('sobrenome', $usuario->sobrenome) }}" required>
                </div>
                <div class="form-group">
                    <label for="email">{{ __('Email') }}</label>
                    <input type="email" class="form-control" id="email" name="email" value="{{ old('email', $usuario->email) }}" required>
                </div>
                <div class="form-group">
                    <label for="login">{{ __('Login') }}</label>
                    <input type="text" class="form-control" id="login" name="login" value="{{ old('login', $usuario->login) }}" required>
                </div>
                <div class="form-group">
                    <label for="data_nascimento">{{ __('Data de Nascimento') }}</label>
                    <input type="date" class="form-control" id="data_nascimento" name="data_nascimento" value="{{ old('data_nascimento', $usuario->data_nascimento) }}" required>
                </div>
                <div class="form-group">
                    <label for="telefone">{{ __('Telefone') }}</label>
                    <input type="text" class="form-control" id="telefone" name="telefone" value="{{ old('telefone', $usuario->telefone) }}" required>
                </div>
                <div class="form-group">
                    <label for="senha">{{ __('Senha') }}</label>
                    <input type="password" class="form-control" id="senha" name="senha">
                </div>
                <div class="form-group">
                    <label for="password_confirmation">{{ __('Confirmar Senha') }}</label>
                    <input type="password" class="form-control" id="password_confirmation" name="password_confirmation">
                </div>
                <div class="form-group">
                    <label for="tipo_id">{{ __('Tipo') }}</label>
                    <select class="form-control" id="tipo_id" name="tipo_id" required>
                        @foreach($tipos as $tipo)
                            <option value="{{ $tipo->id }}" {{ old('tipo_id', $usuario->tipo_id) == $tipo->id ? 'selected' : '' }}>{{ $tipo->nome }}</option>
                        @endforeach
                    </select>
                </div>
                <button type="submit" class="btn btn-success mt-3">{{ __('Salvar') }}</button>
                <a href="{{ route('usuarios.index') }}" class="btn btn-secondary mt-3">{{ __('Voltar') }}</a>
            </form>
        </div>
    </div>
</div>
@endsection
