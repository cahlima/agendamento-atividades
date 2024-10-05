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

            <!-- Informações do Usuário -->
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="nome" class="form-label">{{ __('Nome') }}</label>
                    <input type="text" class="form-control" id="nome" value="{{ $usuario->nome }}" disabled>
                </div>
                <div class="col-md-6 mb-3">
                    <label for="sobrenome" class="form-label">{{ __('Sobrenome') }}</label>
                    <input type="text" class="form-control" id="sobrenome" value="{{ $usuario->sobrenome }}" disabled>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="email" class="form-label">{{ __('Email') }}</label>
                    <input type="email" class="form-control" id="email" value="{{ $usuario->email }}" disabled>
                </div>
                <div class="col-md-6 mb-3">
                    <label for="login" class="form-label">{{ __('Login') }}</label>
                    <input type="text" class="form-control" id="login" value="{{ $usuario->login }}" disabled>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="data_nascimento" class="form-label">{{ __('Data de Nascimento') }}</label>
                    <input type="date" class="form-control" id="data_nascimento" value="{{ $usuario->data_nascimento }}" disabled>
                </div>
                <div class="col-md-6 mb-3">
                    <label for="telefone" class="form-label">{{ __('Telefone') }}</label>
                    <input type="text" class="form-control" id="telefone" value="{{ $usuario->telefone }}" disabled>
                </div>
            </div>

            <!-- Botões de Ação -->
            <div class="d-flex justify-content-end mt-4">
                <a href="{{ route('aluno.perfil.edit') }}" class="btn btn-primary mr-2"><i class="fas fa-edit"></i> {{ __('Editar Perfil') }}</a>
                <a href="{{ route('aluno.painel') }}" class="btn btn-secondary"><i class="fas fa-arrow-left"></i> {{ __('Voltar') }}</a>
            </div>
        </div>
    </div>
</div>
@endsection
