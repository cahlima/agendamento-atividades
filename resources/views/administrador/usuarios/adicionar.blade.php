<!-- resources/views/usuario/adicionar.blade.php -->
@extends('layouts.base')

@section('main-content')
<h2>{{ __('Adicionar Usuário') }}</h2>

<form action="{{ route('usuario.salvar') }}" method="POST">
    @csrf
    <div class="mb-3">
        <label for="nome" class="form-label">{{ __('Nome') }}</label>
        <input type="text" class="form-control" id="nome" name="nome" value="{{ old('nome') }}" required>
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
        <label for="tipo_id" class="form-label">{{ __('Tipo') }}</label>
        <select class="form-control" id="tipo_id" name="tipo_id" required>
            @foreach($tipos as $tipo)
            <option value="{{ $tipo->id }}">{{ $tipo->nome }}</option>
            @endforeach
        </select>
    </div>
    <button type="submit" class="btn btn-primary">{{ __('Salvar') }}</button>
</form>
@endsection
