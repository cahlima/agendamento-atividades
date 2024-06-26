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

                    <h3>Bem-vindo, {{ $usuario->nome }}!</h3>

                    <p>Aqui você pode ver suas informações e acessar as funcionalidades disponíveis para os alunos.</p>

                    <div class="list-group mb-4">
                        <a href="{{ route('aluno.atividades.listar') }}" class="list-group-item list-group-item-action">Buscar atividades</a>
                        <a href="{{ route('aluno.atividades.matriculadas') }}" class="list-group-item list-group-item-action">Ver minhas Atividades</a>
                        <a href="{{ route('aluno.perfil.edit') }}" class="list-group-item list-group-item-action">Editar perfil</a>
                    </div>

                    <div>
                        <h4>Minhas Atividades Matriculadas</h4>
                        @if($atividades->isEmpty())
                            <p>Você ainda não está matriculado em nenhuma atividade.</p>
                        @else
                            <ul class="list-group">
                                @foreach($atividades as $atividade)
                                    <li class="list-group-item">
                                        {{ $atividade->titulo }} - {{ $atividade->descricao }}
                                    </li>
                                @endforeach
                            </ul>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
