@extends('layouts.base')

@section('title', 'Editar Perfil')

@section('main-content')
<div class="container">
    <h2>{{ __('Editar Perfil') }}</h2>
    <form method="POST" action="{{ route('aluno.perfil.update') }}">
        @csrf
        @method('POST')

        <!-- Nome -->
        <div class="mb-3">
            <label for="name" class="form-label">{{ __('Nome') }}</label>
            <input type="text" name="name" class="form-control" id="name" value="{{ auth()->user()->name }}" required>
        </div>

        <!-- Email -->
        <div class="mb-3">
            <label for="email" class="form-label">{{ __('Email') }}</label>
            <input type="email" name="email" class="form-control" id="email" value="{{ auth()->user()->email }}" required>
        </div>

        <!-- Senha -->
        <div class="mb-3">
            <label for="password" class="form-label">{{ __('Senha') }}</label>
            <input type="password" name="password" class="form-control" id="password">
            <small class="form-text text-muted">{{ __('Deixe em branco se não quiser alterar a senha') }}</small>
        </div>

        <!-- Confirmar Senha -->
        <div class="mb-3">
            <label for="password_confirmation" class="form-label">{{ __('Confirmar Senha') }}</label>
            <input type="password" name="password_confirmation" class="form-control" id="password_confirmation">
        </div>

        <button type="button" class="btn btn-primary" onclick="showEditProfileModal(this.form)">{{ __('Salvar') }}</button>
    </form>
</div>
@endsection
