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
                    <input type="text" name="busca" class="form-control" placeholder="{{ request('busca') ? request('busca') : 'Buscar atividade...' }}" value="{{ request('busca') }}">
                    <div class="input-group-append">
                        <button class="btn btn-primary" type="submit">
                            <i class="fas fa-search"></i> {{ __('Buscar') }}
                        </button>
                        @if(request('busca'))
                            <a href="{{ route('aluno.atividades.listarAluno') }}" class="btn btn-secondary">{{ __('Limpar') }}</a>
                        @endif
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
                            <!-- Verificação se o aluno já está matriculado -->
                            @if(!$atividade->alunos->contains(Auth::id()))
                                <form action="{{ route('aluno.atividades.matricular', $atividade->id) }}" method="POST" onsubmit="return confirm('Tem certeza que deseja se matricular nesta atividade?');">
                                    @csrf
                                    <button class="btn btn-success">{{ __('Matricular') }}</button>
                                </form>
                            @else
                                <button class="btn btn-secondary" disabled>{{ __('Já Matriculado') }}</button>
                            @endif
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
