@extends('layouts.app')

@section('title', 'Meu Perfil')

@section('content')
<div class="container mt-5">
    <div class="card shadow-sm border-0">
        <div class="card-header bg-primary text-white text-center">
            <h2>{{ __('Meu Perfil') }}</h2>
        </div>
        <div class="card-body">
            @if(Session::has('flash_message'))
                @php
                    $flashMessage = Session::get('flash_message');
                @endphp
                <div class="alert alert-success text-center">
                    {{ is_array($flashMessage) && isset($flashMessage['msg']) ? $flashMessage['msg'] : $flashMessage }}
                </div>
            @endif

            <!-- Informações do Perfil -->
            <div class="row mb-3">
                <div class="col-md-6">
                    <label for="nome" class="font-weight-bold">{{ __('Nome') }}</label>
                    <input type="text" class="form-control" id="nome" name="nome" value="{{ $usuario->nome }}" disabled>
                </div>
                <div class="col-md-6">
                    <label for="sobrenome" class="font-weight-bold">{{ __('Sobrenome') }}</label>
                    <input type="text" class="form-control" id="sobrenome" name="sobrenome" value="{{ $usuario->sobrenome }}" disabled>
                </div>
            </div>

            <div class="row mb-3">
                <div class="col-md-6">
                    <label for="email" class="font-weight-bold">{{ __('Email') }}</label>
                    <input type="email" class="form-control" id="email" name="email" value="{{ $usuario->email }}" disabled>
                </div>
                <div class="col-md-6">
                    <label for="login" class="font-weight-bold">{{ __('Login') }}</label>
                    <input type="text" class="form-control" id="login" name="login" value="{{ $usuario->login }}" disabled>
                </div>
            </div>

            <div class="row mb-3">
                <div class="col-md-6">
                    <label for="data_nascimento" class="font-weight-bold">{{ __('Data de Nascimento') }}</label>
                    <input type="date" class="form-control" id="data_nascimento" name="data_nascimento" value="{{ $usuario->data_nascimento }}" disabled>
                </div>
                <div class="col-md-6">
                    <label for="telefone" class="font-weight-bold">{{ __('Telefone') }}</label>
                    <input type="text" class="form-control" id="telefone" name="telefone" value="{{ $usuario->telefone }}" disabled>
                </div>
            </div>

            <!-- Ações -->
            <div class="d-flex justify-content-center mt-4">
                <a href="{{ route('professor.perfil.edit') }}" class="btn btn-primary mr-2">{{ __('Editar Perfil') }}</a>
                <a href="{{ route('professor.painel') }}" class="btn btn-secondary">{{ __('Voltar') }}</a>
            </div>
        </div>
    </div>
</div>
@endsection
