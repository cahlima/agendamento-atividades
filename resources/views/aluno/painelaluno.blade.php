@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <div class="card shadow-sm border-0">
        <div class="card-header bg-primary text-white text-center">
            <h3 class="mb-0">{{ __('Painel do Aluno') }}</h3>
        </div>

        <div class="card-body">
            @if(session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif

            <div class="text-center mb-4">
                <h4>Bem-vindo, {{ auth()->user()->nome }}!</h4>
                <p class="text-muted">Aqui você pode ver suas informações e acessar as funcionalidades disponíveis para os alunos.</p>
            </div>

            <div class="row mb-4">
                <div class="col-md-4">
                    <a href="{{ route('aluno.atividades.listarAluno') }}" class="btn btn-outline-primary btn-block">
                        Buscar Atividades
                    </a>
                </div>
                <div class="col-md-4">
                    <a href="{{ route('aluno.atividades.matriculadas') }}" class="btn btn-outline-primary btn-block">
                        Minhas Atividades
                    </a>
                </div>
                <div class="col-md-4">
                    <a href="{{ route('aluno.perfil.index') }}" class="btn btn-outline-primary btn-block">
                        Editar Perfil
                    </a>
                </div>
            </div>

            <h5 class="text-primary mb-3">Minhas Atividades Matriculadas</h5>

            @if(isset($atividadesFiltradas) && $atividadesFiltradas->isNotEmpty())
                <ul class="list-group">
                    @foreach($atividadesFiltradas as $atividade)
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            <div>
                                <strong>{{ $atividade->atividade }}</strong>
                                <p class="mb-0 text-muted">
                                    {{ \Carbon\Carbon::parse($atividade->data_ocorrencia)->format('d/m/Y') }}
                                    ({{ ucfirst(\Carbon\Carbon::parse($atividade->data_ocorrencia)->locale('pt_BR')->isoFormat('dddd')) }})
                                    às {{ \Carbon\Carbon::parse($atividade->hora)->format('H:i') }}
                                </p>
                                <small class="text-muted">Instrutor: {{ $atividade->instrutor->nome ?? 'Nome do instrutor não disponível' }}</small><br>
                                <small class="text-muted">Local: {{ $atividade->local }}</small>
                            </div>
                        </li>
                    @endforeach
                </ul>
            @else
                <div class="alert alert-info mt-3" role="alert">
                    {{ __('Você ainda não está matriculado em nenhuma atividade.') }}
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
