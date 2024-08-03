@extends('layouts.app')

@section('title', 'Editar Perfil')

@section('content')
<div class="container mt-5">
    <div class="card">
        <div class="card-header">
            <h2>{{ __('Editar Perfil') }}</h2>
        </div>
        <div class="card-body">
            @if(Session::has('flash_message'))
                <div class="alert alert-success">{{ Session::get('flash_message')['msg'] }}</div>
            @endif

            <form action="{{ route('admin.perfil.update', ['id' => $usuario->id]) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="form-group">
                    <label for="nome">{{ __('Nome') }}</label>
                    <input type="text" class="form-control" id="nome" name="nome" value="{{ $usuario->nome }}" required>
                </div>
                <div class="form-group">
                    <label for="sobrenome">{{ __('Sobrenome') }}</label>
                    <input type="text" class="form-control" id="sobrenome" name="sobrenome" value="{{ $usuario->sobrenome }}" required>
                </div>
                <div class="form-group">
                    <label for="email">{{ __('Email') }}</label>
                    <input type="email" class="form-control" id="email" name="email" value="{{ $usuario->email }}" required>
                </div>
                <div class="form-group">
                    <label for="login">{{ __('Login') }}</label>
                    <input type="text" class="form-control" id="login" name="login" value="{{ $usuario->login }}" required>
                </div>
                <div class="form-group">
                    <label for="data_nascimento">{{ __('Data de Nascimento') }}</label>
                    <input type="date" class="form-control" id="data_nascimento" name="data_nascimento" value="{{ $usuario->data_nascimento }}" required>
                </div>
                <div class="form-group">
                    <label for="telefone">{{ __('Telefone') }}</label>
                    <input type="text" class="form-control" id="telefone" name="telefone" value="{{ $usuario->telefone }}" required>
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
                            <option value="{{ $tipo->id }}" {{ $usuario->tipo_id == $tipo->id ? 'selected' : '' }}>{{ $tipo->nome }}</option>
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
