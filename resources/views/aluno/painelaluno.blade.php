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

                    <h3>Bem-vindo, {{ auth()->user()->nome }}!</h3>

                    <p>Aqui você pode ver suas informações e acessar as funcionalidades disponíveis para os alunos.</p>

                    <div class="list-group mb-4">
                        <a href="{{ route('aluno.atividades.listarAluno') }}" class="list-group-item list-group-item-action">Buscar Atividades</a>
                        <a href="{{ route('aluno.atividades.matriculadas') }}" class="list-group-item list-group-item-action">Minhas Atividades</a>
                        <a href="{{ route('aluno.perfil.index') }}" class="list-group-item list-group-item-action">Editar perfil</a>
                    </div>

                    <div>
                        <h4>Minhas Atividades Matriculadas</h4>
                        @if(isset($atividades) && $atividades->isNotEmpty())
                            <ul class="list-group">
                                @foreach($atividades as $atividade)
                                    <li class="list-group-item">
                                        {{ $atividade->atividade }} -
                                        @if($atividade->data instanceof \DateTime)
                                            {{ $atividade->data->format('d/m/Y') }} às {{ $atividade->hora }}
                                        @else
                                            {{ $atividade->data }} às {{ $atividade->hora }}
                                        @endif
                                        <br>Instrutor:
                                        @if(is_object($atividade->instrutor) && property_exists($atividade->instrutor, 'nome'))
                                            {{ $atividade->instrutor->nome }}
                                        @else
                                            Nome do instrutor não disponível
                                        @endif
                                        <br>Local: {{ $atividade->local }}
                                    </li>
                                @endforeach
                            </ul>
                        @else
                            <p>{{ __('Você ainda não está matriculado em nenhuma atividade.') }}</p>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
