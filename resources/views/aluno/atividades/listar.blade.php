@extends('layouts.app')

@section('title', 'Atividades Disponíveis')

@section('content')
<div class="container mt-5">
    <div class="card card-custom">
        <div class="card-body">
            <h2>{{ __('Atividades Disponíveis') }}</h2>

            @if(Session::has('success'))
                <div class="alert alert-success">
                    {{ Session::get('success') }}
                </div>
            @endif

            <!-- Formulário de busca -->
            <form method="GET" action="{{ route('aluno.atividades.listarAluno') }}" class="mb-4">
                <div class="input-group">
                    <input type="text" name="busca" class="form-control" placeholder="Buscar atividade..." value="{{ request('busca') }}">
                    <div class="input-group-append">
                        <button class="btn btn-primary" type="submit">{{ __('Buscar') }}</button>
                    </div>
                </div>
            </form>

            <!-- Listagem de Atividades -->
            @if($atividades->isNotEmpty() || $atividadesMatriculadas->isNotEmpty())
                <ul class="list-group">
                    @foreach($atividades as $atividade)
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            <div>
                                <h5>{{ $atividade->atividade }}</h5>
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
                            <!-- Verifica se o usuário já está matriculado na atividade -->
                            <form action="{{ route('aluno.atividades.matricular', $atividade->id) }}" method="POST">
                                @csrf
                                <button type="submit" class="btn btn-success">{{ __('Matricular') }}</button>
                            </form>
                        </li>
                    @endforeach

                    <!-- Listagem de Atividades em que o Aluno já está Matriculado -->
                    @foreach($atividadesMatriculadas as $atividade)
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            <div>
                                <h5>{{ $atividade->atividade }}</h5>
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
                            <!-- Botão indicando que o aluno já está matriculado -->
                            <button class="btn btn-secondary" disabled>{{ __('Já Matriculado') }}</button>
                        </li>
                    @endforeach
                </ul>
            @else
                <p>{{ __('Nenhuma atividade encontrada.') }}</p>
            @endif
        </div>
    </div>
</div>
@endsection
