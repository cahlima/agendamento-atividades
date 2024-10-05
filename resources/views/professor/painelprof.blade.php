@extends('layouts.app')

@section('title', 'Painel do Professor')

@section('content')
<div class="container mt-5">
    <div class="card shadow-sm border-0">
        <div class="card-header bg-primary text-white text-center">
            <h2>{{ __('Painel do Professor') }}</h2>
        </div>
        <div class="card-body">
            @if(session('success'))
                <div class="alert alert-success text-center">
                    {{ session('success') }}
                </div>
            @endif

            <h3 class="mb-4 text-secondary">Bem-vindo, {{ auth()->user()->nome }}!</h3>
            <p>Aqui você pode ver suas informações e acessar as funcionalidades disponíveis para os professores.</p>

            <!-- Lista de Navegação Rápida -->
            <div class="list-group mb-5">
                <a href="{{ route('professor.atividades.listarProfessor') }}" class="list-group-item list-group-item-action">
                    <i class="fas fa-calendar-alt"></i> Ver todas as Atividades
                </a>
                <a href="{{ route('professor.atividades.matriculadas') }}" class="list-group-item list-group-item-action">
                    <i class="fas fa-clipboard-list"></i> Ver minhas Atividades
                </a>
                <a href="{{ route('professor.perfil.index') }}" class="list-group-item list-group-item-action">
                    <i class="fas fa-user-edit"></i> Meu perfil
                </a>
            </div>

            <!-- Lista de Atividades do Professor -->
            <h4 class="text-secondary">Minhas Atividades</h4>
            @if($minhasAtividades->isNotEmpty())
                <ul class="list-group mb-4">
                    @foreach($minhasAtividades as $atividade)
                        <li class="list-group-item shadow-sm p-3 mb-2 rounded">
                            <h5 class="mb-1">{{ $atividade->atividade }}</h5>
                            <p class="mb-0"><strong>Período:</strong>
                                {{ \Carbon\Carbon::parse($atividade->data_inicio)->format('d/m/Y') }} -
                                {{ \Carbon\Carbon::parse($atividade->data_fim)->format('d/m/Y') }}
                            </p>
                            <p class="mb-0"><strong>Hora:</strong> {{ $atividade->hora }}</p>
                            <p class="mb-0"><strong>Local:</strong> {{ $atividade->local }}</p>
                            <p class="mb-0"><strong>Dias da Semana:</strong> {{ implode(', ', array_map('ucfirst', explode(',', $atividade->dias))) }}</p>
                        </li>
                    @endforeach
                </ul>

                <!-- Paginação -->
                <div class="d-flex justify-content-center">
                    {{ $minhasAtividades->links() }}
                </div>
            @else
                <div class="alert alert-info text-center">{{ __('Você ainda não está alocado em nenhuma atividade.') }}</div>
            @endif
        </div>
    </div>
</div>
@endsection
