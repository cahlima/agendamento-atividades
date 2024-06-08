@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Painel do Aluno') }}</div>

                <div class="card-body">
                    @if(session('success'))
                        <div class="alert alert-success">
                            {{ session('success') }}
                        </div>
                    @endif

                    <h3>Bem-vindo, {{ Auth::user()->nome }}!</h3>

                    <p>Aqui você pode ver suas informações e acessar as funcionalidades disponíveis para os alunos.</p>

                    <div class="list-group">
                        <a href="#" class="list-group-item list-group-item-action">Buscar atividades</a>
                        <a href="#" class="list-group-item list-group-item-action">Ver minhas Atividades</a>
                        <a href="#" class="list-group-item list-group-item-action">Editar perfil</a>
                        <a href="#" class="list-group-item list-group-item-action">Configurações</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
