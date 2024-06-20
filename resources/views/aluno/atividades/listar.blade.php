<!-- resources/views/aluno/atividades/listar.blade.php -->
@extends('layouts.base')

@section('main-content')
<h2>{{ __('Atividades Disponíveis') }}</h2>

<form action="{{ route('aluno.atividades.listar') }}" method="GET" class="mb-4">
    <div class="row">
        <div class="col-md-4">
            <label for="atividade_id">{{ __('Atividade') }}:</label>
            <select name="atividade_id" id="atividade_id" class="form-control">
                <option value="">{{ __('Selecione a atividade') }}</option>
                @foreach($atividadesDisponiveis as $atividade)
                    <option value="{{ $atividade->id }}">{{ $atividade->atividade }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-md-4">
            <label for="hora">{{ __('Horário') }}:</label>
            <select name="hora" id="hora" class="form-control">
                <option value="">{{ __('Selecione o horário') }}</option>
                @foreach($horariosDisponiveis as $horario)
                    <option value="{{ $horario }}">{{ $horario }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-md-4 mt-4">
            <button type="submit" class="btn btn-primary">{{ __('Pesquisar') }}</button>
            <a href="{{ route('aluno.painel') }}" class="btn btn-secondary">{{ __('Voltar') }}</a>
        </div>
    </div>
</form>

@if(isset($atividades) && $atividades->count() > 0)
    <div class="table-responsive mt-4">
        <table class="table table-striped table-sm">
            <thead>
                <tr>
                    <th>{{ __('Atividade') }}</th>
                    <th>{{ __('Data') }}</th>
                    <th>{{ __('Hora') }}</th>
                    <th>{{ __('Instrutor') }}</th>
                    <th>{{ __('Local') }}</th>
                    <th>{{ __('Ações') }}</th>
                </tr>
            </thead>
            <tbody>
                @foreach($atividades as $atividade)
                <tr>
                    <td>{{ $atividade->atividade }}</td>
                    <td>{{ \Carbon\Carbon::parse($atividade->data)->format('d/m/Y') }}</td>
                    <td>{{ $atividade->hora }}</td>
                    <td>{{ $atividade->instrutor }}</td>
                    <td>{{ $atividade->local }}</td>
                    <td>
                        <form action="{{ route('aluno.atividades.matricular', $atividade->id) }}" method="POST" onsubmit="event.preventDefault(); showMatriculaModal('{{ $atividade->atividade }}', '{{ \Carbon\Carbon::parse($atividade->data)->format('d/m/Y') }}', '{{ $atividade->hora }}', this);">
                            @csrf
                            <button type="submit" class="btn btn-sm btn-primary">{{ __('Matricular') }}</button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    {{ $atividades->links() }}
@else
    <p>{{ __('Nenhuma atividade encontrada com os critérios selecionados.') }}</p>
@endif
@endsection
