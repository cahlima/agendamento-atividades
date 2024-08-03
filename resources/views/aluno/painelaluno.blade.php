@extends('layouts.app')

@section('title', 'Painel do Aluno')

@section('content')
<div class="container mt-5">
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h2>Olá, {{ Auth::user()->nome }}</h2>
        </div>
        <div class="card-body">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h5 class="card-title">{{ __('Minhas Atividades Matriculadas') }}</h5>
            </div>
            <div class="table-responsive">
                @if(isset($atividades) && $atividades->isNotEmpty())
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
                            @foreach($atividades as $atividade)
                                <tr>
                                    <td>{{ $atividade->atividade }}</td>
                                    <td>{{ \Carbon\Carbon::parse($atividade->data)->format('d/m/Y') }}</td>
                                    <td>{{ \Carbon\Carbon::parse($atividade->hora)->format('H:i') }}</td>
                                    <td>
                                        @if(is_object($atividade->instrutor) && property_exists($atividade->instrutor, 'nome'))
                                            {{ $atividade->instrutor->nome }}
                                        @else
                                            Nome do instrutor não disponível
                                        @endif
                                    </td>
                                    <td>{{ $atividade->local }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @else
                    <p>{{ __('Você ainda não está matriculado em nenhuma atividade.') }}</p>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
