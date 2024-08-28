@extends('layouts.app')

@section('title', 'Atividades do Centro Cultural')

@section('content')
<div class="container">
    <h2>{{ __('Atividades do Centro Cultural') }}</h2>

    @if(Session::has('success'))
        <div class="alert alert-success">
            {{ Session::get('success') }}
        </div>
    @endif

    <!-- Formulário de busca -->
    <form method="GET" action="{{ route('professor.atividades.listarProfessor') }}" class="mb-4">
        <div class="input-group">
            <input type="text" name="busca" class="form-control" placeholder="Buscar atividade..." value="{{ request('busca') }}">
            <div class="input-group-append">
                <button class="btn btn-primary" type="submit">{{ __('Buscar') }}</button>
            </div>
        </div>
    </form>

    <!-- Listagem de Atividades -->
    @if($atividades->isNotEmpty())
        <ul class="list-group">
            @foreach($atividades as $atividade)
                <li class="list-group-item d-flex justify-content-between align-items-center">
                    <div>
                        <h5>{{ $atividade->atividade }}</h5>
                        <p><strong>Local:</strong> {{ $atividade->local }}</p>
                        <p><strong>Instrutor:</strong> {{ $atividade->instrutor->nome ?? 'Instrutor não definido' }}</p>
                        <p><strong>Data:</strong>
                            {{ optional($atividade->data_inicio)->format('d/m/Y') ?? 'Data não definida' }} -
                            {{ optional($atividade->data_fim)->format('d/m/Y') ?? 'Data não definida' }}
                        </p>
                        <p><strong>Horários:</strong>
                            @foreach($atividade->horarios as $horario)
                                {{ $horario->hora }}@if(!$loop->last), @endif
                            @endforeach
                        </p>
                    </div>
                </li>
            @endforeach
        </ul>
    @else
        <p>{{ __('Nenhuma atividade encontrada.') }}</p>
    @endif
</div>
@endsection
