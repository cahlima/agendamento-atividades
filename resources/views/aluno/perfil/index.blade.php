@extends('layouts.app')

@section('title', 'Meu Perfil')

@section('content')
<div class="container mt-5">
    <div class="card">
        <div class="card-header">
            <h2>{{ __('Meu Perfil') }}</h2>
        </div>
        <div class="card-body">
            @if(Session::has('flash_message'))
                @php
                    $flashMessage = Session::get('flash_message');
                @endphp
                @if(is_array($flashMessage) && isset($flashMessage['msg']))
                    <div class="alert alert-success">{{ $flashMessage['msg'] }}</div>
                @else
                    <div class="alert alert-success">{{ $flashMessage }}</div>
                @endif
            @endif

            <div class="form-group">
                <label for="nome">{{ __('Nome') }}</label>
                <input type="text" class="form-control" id="nome" name="nome" value="{{ $usuario->nome }}" disabled>
            </div>
            <div class="form-group">
                <label for="sobrenome">{{ __('Sobrenome') }}</label>
                <input type="text" class="form-control" id="sobrenome" name="sobrenome" value="{{ $usuario->sobrenome }}" disabled>
            </div>
            <div class="form-group">
                <label for="email">{{ __('Email') }}</label>
                <input type="email" class="form-control" id="email" name="email" value="{{ $usuario->email }}" disabled>
            </div>
            <div class="form-group">
                <label for="login">{{ __('Login') }}</label>
                <input type="text" class="form-control" id="login" name="login" value="{{ $usuario->login }}" disabled>
            </div>
            <div class="form-group">
                <label for="data_nascimento">{{ __('Data de Nascimento') }}</label>
                <input type="date" class="form-control" id="data_nascimento" name="data_nascimento" value="{{ $usuario->data_nascimento }}" disabled>
            </div>
            <div class="form-group">
                <label for="telefone">{{ __('Telefone') }}</label>
                <input type="text" class="form-control" id="telefone" name="telefone" value="{{ $usuario->telefone }}" disabled>
            </div>

            <!-- Link para editar o perfil do aluno -->
            <a href="{{ route('aluno.perfil.edit') }}" class="btn btn-primary mt-3">{{ __('Editar Perfil') }}</a>

            <!-- Botão Voltar -->
           <!-- Botão Voltar para o Painel do Aluno -->
<a href="{{ route('aluno.painel') }}" class="btn btn-secondary mt-3">{{ __('Voltar') }}</a>

        </div>
    </div>
</div>
@endsection
