@extends('layouts.app')

@section('title', 'Atividades do Centro Cultural')

@section('content')
<div class="container mt-5">
    <div class="card card-custom">
        <div class="card-body">
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
                <div class="table-responsive">
                    <table class="table">
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
                                    <td>

                                        
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <p>{{ __('Nenhuma atividade encontrada.') }}</p>
            @endif
        </div>
    </div>
</div>
@endsection
