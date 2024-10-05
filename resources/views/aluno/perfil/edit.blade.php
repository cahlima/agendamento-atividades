@extends('layouts.app')

@section('title', 'Editar Perfil')

@section('content')
<div class="container mt-5">
    <div class="card shadow-sm border-0">
        <div class="card-header bg-primary text-white text-center">
            <h2>{{ __('Editar Perfil') }}</h2>
        </div>
        <div class="card-body">
            @if(Session::has('flash_message'))
                <div class="alert {{ Session::get('flash_message.class') }} text-center">
                    {{ Session::get('flash_message.msg') }}
                </div>
            @endif

            <form action="{{ route('aluno.perfil.update') }}" method="POST" onsubmit="return confirm('Você tem certeza que deseja salvar as alterações no perfil?');">
                @csrf
                @method('PUT')
                <div class="row">
                    <!-- Nome -->
                    <div class="col-md-6 mb-3">
                        <label for="nome" class="form-label">{{ __('Nome') }}</label>
                        <input type="text" class="form-control" id="nome" name="nome" value="{{ $usuario->nome }}" required>
                    </div>

                    <!-- Sobrenome -->
                    <div class="col-md-6 mb-3">
                        <label for="sobrenome" class="form-label">{{ __('Sobrenome') }}</label>
                        <input type="text" class="form-control" id="sobrenome" name="sobrenome" value="{{ $usuario->sobrenome }}" required>
                    </div>
                </div>

                <div class="row">
                    <!-- Email -->
                    <div class="col-md-6 mb-3">
                        <label for="email" class="form-label">{{ __('Email') }}</label>
                        <input type="email" class="form-control" id="email" name="email" value="{{ $usuario->email }}" required>
                    </div>

                    <!-- Login -->
                    <div class="col-md-6 mb-3">
                        <label for="login" class="form-label">{{ __('Login') }}</label>
                        <input type="text" class="form-control" id="login" name="login" value="{{ $usuario->login }}" required>
                    </div>
                </div>

                <div class="row">
                    <!-- Data de Nascimento -->
                    <div class="col-md-6 mb-3">
                        <label for="data_nascimento" class="form-label">{{ __('Data de Nascimento') }}</label>
                        <input type="date" class="form-control" id="data_nascimento" name="data_nascimento" value="{{ $usuario->data_nascimento }}" required>
                    </div>

                    <!-- Telefone -->
                    <div class="col-md-6 mb-3">
                        <label for="telefone" class="form-label">{{ __('Telefone') }}</label>
                        <input type="text" class="form-control" id="telefone" name="telefone" value="{{ $usuario->telefone }}" required>
                    </div>
                </div>

                <div class="row">
                    <!-- Senha -->
                    <div class="col-md-6 mb-3">
                        <label for="senha" class="form-label">{{ __('Senha') }}</label>
                        <input type="password" class="form-control" id="senha" name="senha" placeholder="Deixe em branco para não alterar">
                    </div>

                    <!-- Confirmar Senha -->
                    <div class="col-md-6 mb-3">
                        <label for="password_confirmation" class="form-label">{{ __('Confirmar Senha') }}</label>
                        <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" placeholder="Deixe em branco para não alterar">
                    </div>
                </div>

                <div class="d-flex justify-content-between mt-4">
                    <button type="submit" class="btn btn-success">
                        <i class="fas fa-save"></i> {{ __('Salvar') }}
                    </button>
                    <a href="{{ route('aluno.perfil.index') }}" class="btn btn-secondary">
                        <i class="fas fa-arrow-left"></i> {{ __('Voltar') }}
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
