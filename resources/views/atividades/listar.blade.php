@extends('layouts.app')

@section('title', 'Atividades do Centro Cultural')

@section('content')
<div class="container mt-5">
    <div class="card shadow-sm border-0">
        <div class="card-header bg-primary text-white text-center">
            <h2>{{ __('Atividades do Centro Cultural') }}</h2>
        </div>
        <div class="card-body">
            @if(Session::has('success'))
                <div class="alert alert-success">
                    {{ Session::get('success') }}
                </div>
            @endif

            <!-- Formulário de busca aprimorado -->
            <form method="GET" action="{{ route('professor.atividades.listarProfessor') }}" class="mb-4">
                <div class="row">
                    <!-- Dropdown de busca por atividade -->
                    <div class="col-md-6 mb-3">
                        <select name="busca" class="form-select">
                            <option value="">{{ __('Selecione uma atividade') }}</option>
                            @foreach($todasAtividades as $atividadeItem)
                                <option value="{{ $atividadeItem->atividade }}" {{ request('busca') == $atividadeItem->atividade ? 'selected' : '' }}>
                                    {{ $atividadeItem->atividade }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Botão de busca -->
                    <div class="col-md-6 mb-3">
                        <button class="btn btn-primary w-100" type="submit">{{ __('Buscar') }}</button>
                    </div>
                </div>
            </form>

            <!-- Listagem de Atividades -->
            @if($atividades->isNotEmpty())
                <div class="table-responsive mt-4">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>{{ __('Atividade') }}</th>
                                <th>{{ __('Data de Início') }}</th>
                                <th>{{ __('Data de Fim') }}</th>
                                <th>{{ __('Hora') }}</th>
                                <th>{{ __('Dias da Semana') }}</th>
                                <th>{{ __('Instrutor') }}</th>
                                <th>{{ __('Local') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($atividades as $atividade)
                                <tr>
                                    <td>{{ $atividade->atividade }}</td>
                                    <td>{{ \Carbon\Carbon::parse($atividade->data_inicio)->format('d/m/Y') }}</td>
                                    <td>{{ \Carbon\Carbon::parse($atividade->data_fim)->format('d/m/Y') }}</td>
                                    <td>{{ \Carbon\Carbon::parse($atividade->hora)->format('H:i') }}</td>
                                    <td>
                                        @php
                                            $diasSemana = explode(',', $atividade->dias);
                                            $diasSemanaFormatados = array_map(function($dia) {
                                                return ucfirst(strtolower(trim($dia)));
                                            }, $diasSemana);
                                            echo implode(', ', $diasSemanaFormatados);
                                        @endphp
                                    </td>
                                    <td>{{ $atividade->instrutor->nome ?? 'N/A' }}</td>
                                    <td>{{ $atividade->local }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="alert alert-info text-center mt-4">
                    {{ __('Nenhuma atividade encontrada.') }}
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
