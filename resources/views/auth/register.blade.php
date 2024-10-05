@extends('layouts.app')

@section('title', 'Cadastro')

@section('content')
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-primary text-white text-center">
                    <h2>{{ __('Cadastro') }}</h2>
                </div>

                <div class="card-body">
                    @if(session('success'))
                        <div class="alert alert-success">
                            {{ session('success') }}
                        </div>
                    @endif

                    <form method="POST" action="{{ route('register') }}">
                        @csrf

                        <!-- Nome -->
                        <div class="form-group mb-3">
                            <label for="nome" class="form-label">{{ __('Nome') }}</label>
                            <input id="nome" type="text" class="form-control @error('nome') is-invalid @enderror" name="nome" value="{{ old('nome') }}" required autofocus>
                            @error('nome')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <!-- Sobrenome -->
                        <div class="form-group mb-3">
                            <label for="sobrenome" class="form-label">{{ __('Sobrenome') }}</label>
                            <input id="sobrenome" type="text" class="form-control @error('sobrenome') is-invalid @enderror" name="sobrenome" value="{{ old('sobrenome') }}" required>
                            @error('sobrenome')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <!-- Email - campo vazio -->
                        <div class="form-group mb-3">
                            <label for="email" class="form-label">{{ __('E-Mail') }}</label>
                            <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="" required>
                            @error('email')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <!-- Data de Nascimento -->
                        <div class="form-group mb-3">
                            <label for="data_nascimento" class="form-label">{{ __('Data de Nascimento') }}</label>
                            <input id="data_nascimento" type="date" class="form-control @error('data_nascimento') is-invalid @enderror" name="data_nascimento" value="{{ old('data_nascimento') }}" required>
                            @error('data_nascimento')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <!-- Telefone -->
                        <div class="form-group mb-3">
                            <label for="telefone" class="form-label">{{ __('Telefone') }}</label>
                            <input id="telefone" type="text" class="form-control @error('telefone') is-invalid @enderror" name="telefone" value="{{ old('telefone') }}" required>
                            @error('telefone')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <!-- Login -->
                        <div class="form-group mb-3">
                            <label for="login" class="form-label">{{ __('Login') }}</label>
                            <input id="login" type="text" class="form-control @error('login') is-invalid @enderror" name="login" value="{{ old('login') }}" required>
                            @error('login')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <!-- Senha - campo vazio -->
                        <div class="form-group mb-3">
                            <label for="senha" class="form-label">{{ __('Senha') }}</label>
                            <input id="senha" type="password" class="form-control @error('senha') is-invalid @enderror" name="senha" value="" required>
                            @error('senha')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <!-- Confirmar Senha - campo vazio -->
                        <div class="form-group mb-3">
                            <label for="password-confirm" class="form-label">{{ __('Confirme a Senha') }}</label>
                            <input id="password-confirm" type="password" class="form-control" name="senha_confirmation" value="" required>
                        </div>

                        <!-- Botões -->
                        <div class="d-flex justify-content-between mt-4">
                            <button type="submit" class="btn btn-success">{{ __('Registrar') }}</button>
                            <a href="{{ url()->previous() }}" class="btn btn-secondary">{{ __('Voltar') }}</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
