@extends('layouts.app')

@section('content')
<div class="container">
    <h2>{{ __('Atividades') }}</h2>

    @if(Session::has('success'))
        <div class="alert alert-success">
            {{ Session::get('success') }}
        </div>
    @endif

    <!-- Formulário de busca -->
    <form method="GET" action="{{ route('professor.atividades.listar') }}" class="mb-4">
        <div class="input-group">
            <input type="text" name="busca" class="form-control" placeholder="Buscar atividade..." value="{{ request('busca') }}">
            <div class="input-group-append">
                <button class="btn btn-primary" type="submit">{{ __('Buscar') }}</button>
            </div>
        </div>
    </form>

    <!-- Tabela de atividades -->
    <table class="table">
        <thead>
            <tr>
                <th>{{ __('Atividade') }}</th>
                <th>{{ __('Data') }}</th>
                <th>{{ __('Hora') }}</th>
                <th>{{ __('Local') }}</th>
            </tr>
        </thead>
        <tbody>
            @foreach($atividades as $atividade)
                <tr>
                    <td>{{ $atividade->titulo }}</td>
                    <td>{{ \Carbon\Carbon::parse($atividade->data)->format('d/m/Y') }}</td>
                    <td>{{ $atividade->hora }}</td>
                    <td>{{ $atividade->local }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
