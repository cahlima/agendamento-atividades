@extends('layouts.app')

@section('title', 'Painel Administrativo')

@section('content')
<div class="container mt-5">
    <div class="card card-custom">
    <div class="card-body">
            <h2>Olá, {{ Auth::user()->nome }}</h2>
        </div>
        <div class="card-body">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h5 class="card-title">{{ __('Atividades de Hoje') }}</h5>
            </div>
            <div class="table-responsive">
        <table class="table">
    <thead>
        <tr>
            <th>Atividade</th>
            <th>Data</th>
            <th>Dia</th>
            <th>Hora</th>
            <th>Instrutor</th>
            <th>Local</th>
        </tr>
    </thead>
    <tbody>
        @forelse ($atividades as $atividade)
            <tr>
                <td>{{ $atividade->atividade }}</td>
                <td>{{ \Carbon\Carbon::parse($atividade->data_inicio)->addDays(\Carbon\Carbon::parse($atividade->data_inicio)->diffInDays($atividade->data_fim))->format('d/m/Y') }}</td>
                <td>{{ ucfirst(\Carbon\Carbon::parse($atividade->data_inicio)->addDays(\Carbon\Carbon::parse($atividade->data_inicio)->diffInDays($atividade->data_fim))->locale('pt_BR')->isoFormat('dddd')) }}</td>

                <td>{{ \Carbon\Carbon::parse($atividade->hora)->format('H:i') }}</td>
                <td>{{ $atividade->instrutor->nome ?? 'N/A' }}</td>
                <td>{{ $atividade->local ?? 'N/A' }}</td>
            </tr>
        @empty
            <tr>
                <td colspan="6">Nenhuma atividade encontrada para hoje.</td>
            </tr>
        @endforelse
    </tbody>
</table>

            </div>
        </div>
    </div>
</div>
@endsection
