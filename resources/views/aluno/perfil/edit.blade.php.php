@extends('layouts.app')

@section('content')
<div class="container">
    <h2>{{ __('Editar Perfil') }}</h2>
    @if(Session::has('flash_message'))
        <div class="alert {{ Session::get('flash_message.class') }}">
            {{ Session::get('flash_message.msg') }}
        </div>
    @endif
    <form action="{{ route('aluno.perfil.update') }}" method="POST">
        @csrf
        <div class="form-group">
            <label for="nome">{{ __('Nome') }}</label>
            <input type="text" class="form-control" id="nome" name="nome" value="{{ $usuario->nome }}" required>
        </div>
        <div class="form-group">
            <label for="email">{{ __('Email') }}</label>
            <input type="email" class="form-control" id="email" name="email" value="{{ $usuario->email }}" required>
        </div>
        <div class="form-group">
            <label for="password">{{ __('Senha') }}</label>
            <input type="password" class="form-control" id="password" name="password">
        </div>
        <div class="form-group">
            <label for="password_confirmation">{{ __('Confirmar Senha') }}</label>
            <input type="password" class="form-control" id="password_confirmation" name="password_confirmation">
        </div>
        <button type="submit" class="btn btn-success">{{ __('Atualizar') }}</button>
    </form>
</div>
@endsection
