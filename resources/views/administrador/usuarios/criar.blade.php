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
                <div class="alert alert-success">{{ Session::get('flash_message') }}</div>
            @endif

            <form action="{{ route('usuarios.store') }}" method="POST">
                @csrf
                <!-- Campo Nome -->
                <div class="mb-3">
                    <label for="nome" class="form-label">{{ __('Nome') }}</label>
                    <input type="text" class="form-control @error('nome') is-invalid @enderror" id="nome" name="nome" value="{{ old('nome') }}" required>
                    @error('nome')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Campo Sobrenome -->
                <div class="mb-3">
                    <label for="sobrenome" class="form-label">{{ __('Sobrenome') }}</label>
                    <input type="text" class="form-control @error('sobrenome') is-invalid @enderror" id="sobrenome" name="sobrenome" value="{{ old('sobrenome') }}" required>
                    @error('sobrenome')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Campo Login -->
                <div class="mb-3">
                    <label for="login" class="form-label">{{ __('Login') }}</label>
                    <input type="text" class="form-control @error('login') is-invalid @enderror" id="login" name="login" value="{{ old('login') }}" required autocomplete="off">
                    @error('login')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Campo Email -->
                <div class="mb-3">
                    <label for="email" class="form-label">{{ __('Email') }}</label>
                    <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" value="{{ old('email') }}" required>
                    @error('email')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Campo Senha -->
                <div class="mb-3">
                    <label for="senha" class="form-label">{{ __('Senha') }}</label>
                    <input type="password" class="form-control @error('senha') is-invalid @enderror" id="senha" name="senha" required autocomplete="new-password">
                    @error('senha')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Campo Confirmar Senha -->
                <div class="mb-3">
                    <label for="senha_confirmation" class="form-label">{{ __('Confirmar Senha') }}</label>
                    <input type="password" class="form-control @error('senha_confirmation') is-invalid @enderror" id="senha_confirmation" name="senha_confirmation" required autocomplete="new-password">
                    @error('senha_confirmation')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Campo Data de Nascimento -->
                <div class="mb-3">
                    <label for="data_nascimento" class="form-label">{{ __('Data de Nascimento') }}</label>
                    <input type="date" class="form-control @error('data_nascimento') is-invalid @enderror" id="data_nascimento" name="data_nascimento" value="{{ old('data_nascimento') }}" required>
                    @error('data_nascimento')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Campo Telefone -->
                <div class="mb-3">
                    <label for="telefone" class="form-label">{{ __('Telefone') }}</label>
                    <input type="text" class="form-control @error('telefone') is-invalid @enderror" id="telefone" name="telefone" value="{{ old('telefone') }}" required>
                    @error('telefone')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Campo Tipo de Usuário -->
                <div class="mb-3">
                    <label for="tipo_id" class="form-label">{{ __('Tipo') }}</label>
                    <select class="form-control @error('tipo_id') is-invalid @enderror" id="tipo_id" name="tipo_id" required>
                        @foreach($tipos as $tipo)
                            <option value="{{ $tipo->id }}">{{ $tipo->nome }}</option>
                        @endforeach
                    </select>
                    @error('tipo_id')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Botões -->
                <button type="submit" class="btn btn-success">{{ __('Salvar') }}</button>
                <a href="{{ route('usuarios.index') }}" class="btn btn-secondary">{{ __('Voltar') }}</a>
            </form>
        </div>
    </div>
</div>
@endsection
