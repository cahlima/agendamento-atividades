@extends('layouts.app')

@section('title', 'Atividades Disponíveis')

@section('content')
<div class="container mt-5">
    <div class="card shadow-sm border-0">
        <div class="card-header bg-primary text-white text-center">
            <h2>{{ __('Atividades Disponíveis') }}</h2>
        </div>

        <div class="card-body">
            @if(Session::has('success'))
                <div class="alert alert-success">
                    {{ Session::get('success') }}
                </div>
            @endif

            <!-- Formulário de busca -->
            <form method="GET" action="{{ route('aluno.atividades.listarAluno') }}" class="mb-4">
                <div class="row">
                    <div class="col-md-6">
                        <div class="input-group">
                            <select name="busca" class="form-control">
                                <option value="">{{ __('Selecione uma atividade') }}</option>
                                @foreach($atividades as $atividadeOption)
                                    <option value="{{ $atividadeOption->atividade }}" {{ request('busca') == $atividadeOption->atividade ? 'selected' : '' }}>
                                        {{ $atividadeOption->atividade }}
                                    </option>
                                @endforeach
                            </select>
                            <div class="input-group-append">
                                <button class="btn btn-primary" type="submit"><i class="fas fa-search"></i> {{ __('Buscar') }}</button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>

            <!-- Listagem de Atividades para matrícula -->
            <h3 class="text-secondary mt-3">{{ __('Atividades para Matrícula') }}</h3>
            @if($atividades->isNotEmpty())
                <ul class="list-group mb-5">
                    @foreach($atividades as $atividade)
                        <li class="list-group-item d-flex justify-content-between align-items-center shadow-sm p-4 mb-2 rounded">
                            <div>
                                <h5 class="mb-1">{{ $atividade->atividade }}</h5>
                                <p><strong>Instrutor:</strong> {{ $atividade->instrutor->nome ?? 'Instrutor não definido' }}</p>
                                <p><strong>Dia(s) da Semana:</strong> {{ ucfirst(str_replace(',', ', ', $atividade->dias)) }}</p>
                                <p><strong>Período:</strong>
                                    {{ \Carbon\Carbon::parse($atividade->data_inicio)->format('d/m/Y') }} -
                                    {{ \Carbon\Carbon::parse($atividade->data_fim)->format('d/m/Y') }}
                                </p>
                                <p><strong>Hora(s):</strong>
                                    @if($atividade->horarios->isNotEmpty())
                                        @foreach($atividade->horarios as $horario)
                                            {{ \Carbon\Carbon::parse($horario->hora)->format('H:i') }}@if(!$loop->last), @endif
                                        @endforeach
                                    @else
                                        {{ __('Horários não definidos') }}
                                    @endif
                                </p>
                                <p><strong>Local:</strong> {{ $atividade->local }}</p>
                            </div>
                            <!-- Botão de matrícula -->
                            <form action="{{ route('aluno.atividades.matricular', $atividade->id) }}" method="POST">
                                @csrf
                                <button type="submit" class="btn btn-success">{{ __('Matricular') }}</button>
                            </form>
                        </li>
                    @endforeach
                </ul>
            @else
                <div class="alert alert-info">{{ __('Nenhuma atividade encontrada para matrícula.') }}</div>
            @endif

            <!-- Listagem de Atividades já matriculadas -->
            <h3 class="text-secondary mt-5">{{ __('Atividades já Matriculadas') }}</h3>
            @if($atividadesMatriculadas->isNotEmpty())
                <ul class="list-group mb-5">
                    @foreach($atividadesMatriculadas as $atividade)
                        <li class="list-group-item d-flex justify-content-between align-items-center shadow-sm p-4 mb-2 rounded">
                            <div>
                                <h5 class="mb-1">{{ $atividade->atividade }}</h5>
                                <p><strong>Instrutor:</strong> {{ $atividade->instrutor->nome ?? 'Instrutor não definido' }}</p>
                                <p><strong>Dia(s) da Semana:</strong> {{ ucfirst(str_replace(',', ', ', $atividade->dias)) }}</p>
                                <p><strong>Período:</strong>
                                    {{ \Carbon\Carbon::parse($atividade->data_inicio)->format('d/m/Y') }} -
                                    {{ \Carbon\Carbon::parse($atividade->data_fim)->format('d/m/Y') }}
                                </p>
                                <p><strong>Hora(s):</strong>
                                    @if($atividade->horarios->isNotEmpty())
                                        @foreach($atividade->horarios as $horario)
                                            {{ \Carbon\Carbon::parse($horario->hora)->format('H:i') }}@if(!$loop->last), @endif
                                        @endforeach
                                    @else
                                        {{ __('Horários não definidos') }}
                                    @endif
                                </p>
                                <p><strong>Local:</strong> {{ $atividade->local }}</p>
                            </div>
                            <!-- Botão desabilitado para atividades já matriculadas -->
                            <button class="btn btn-secondary" disabled>{{ __('Já Matriculado') }}</button>
                        </li>
                    @endforeach
                </ul>
            @else
                <div class="alert alert-info">{{ __('Nenhuma atividade já matriculada.') }}</div>
            @endif
        </div>
    </div>
</div>
@endsection
