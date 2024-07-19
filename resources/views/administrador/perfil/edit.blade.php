@extends('layouts.base')

@section('content')
<h2>{{ __('Editar Perfil do Administrador') }}</h2>

<form action="{{ route('admin.perfil.update') }}" method="POST" onsubmit="event.preventDefault(); showEditProfileModal(this);">
    @csrf
    <div class="mb-3">
        <label for="nome" class="form-label">{{ __('Nome') }}</label>
        <input type="text" class="form-control" id="nome" name="nome" value="{{ old('nome', $usuario->nome) }}" required>
    </div>
    <div class="mb-3">
        <label for="email" class="form-label">{{ __('Email') }}</label>
        <input type="email" class="form-control" id="email" name="email" value="{{ old('email', $usuario->email) }}" required>
    </div>
    <div class="mb-3">
        <label for="senha" class="form-label">{{ __('Senha') }}</label>
        <input type="password" class="form-control" id="senha" name="senha">
    </div>
    <div class="mb-3">
        <label for="password_confirmation" class="form-label">{{ __('Confirmar Senha') }}</label>
        <input type="password" class="form-control" id="password_confirmation" name="password_confirmation">
    </div>
    <button type="submit" class="btn btn-primary">{{ __('Salvar') }}</button>
    <a href="{{ route('paineladm') }}" class="btn btn-secondary">{{ __('Voltar') }}</a>
</form>
@endsection
