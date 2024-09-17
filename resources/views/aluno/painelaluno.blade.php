@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <div class="card card-custom">
        <div class="card-body">
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
                    @if(isset($atividadesFiltradas) && $atividadesFiltradas->isNotEmpty())
                        <ul class="list-group">
                            @foreach($atividadesFiltradas as $atividade)
                                <li class="list-group-item">
                                    {{ $atividade->atividade }} -
                                    {{ \Carbon\Carbon::parse($atividade->data_ocorrencia)->format('d/m/Y') }}
                                    ({{ ucfirst(\Carbon\Carbon::parse($atividade->data_ocorrencia)->locale('pt_BR')->isoFormat('dddd')) }})
                                    às {{ \Carbon\Carbon::parse($atividade->hora)->format('H:i') }}
                                    <br>Instrutor: {{ $atividade->instrutor->nome ?? 'Nome do instrutor não disponível' }}
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
@endsection
