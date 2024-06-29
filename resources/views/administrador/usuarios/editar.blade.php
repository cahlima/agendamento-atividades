<!-- resources/views/usuario/editar.blade.php -->
@extends('layouts.base')

@section('main-content')
<h2>{{ __('Editar Usuário') }}</h2>

<form action="{{ route('usuario.atualizar', $usuario->id) }}" method="POST">
    @csrf
    <div class="mb-3">
        <label for="nome" class="form-label">{{ __('Nome') }}</label>
        <input type="text" class="form-control" id="nome" name="nome" value="{{ old('nome', $usuario->nome) }}" required>
    </div>
    <div class="mb-3">
        <label for="email" class="form-label">{{ __('Email
