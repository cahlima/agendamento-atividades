@extends('layouts.app')

@section('title', 'Painel Administrativo')

@section('content')
<div class="container mt-5">
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
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
                            <th>{{ __('Atividade') }}</th>
                            <th>{{ __('Data') }}</th>
                            <th>{{ __('Hora') }}</th>
                            <th>{{ __('Instrutor') }}</th>
                            <th>{{ __('Local') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($atividades as $atividade)
                            <tr>
                                <td>{{ $atividade->atividade }}</td>
                                <td>{{ now()->format('d/m/Y') }}</td>
                                <td>{{ \Carbon\Carbon::parse($atividade->hora)->format('H:i') }}</td>
                                <td>{{ $atividade->instrutor->nome ?? 'N/A' }}</td>
                                <td>{{ $atividade->local }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
