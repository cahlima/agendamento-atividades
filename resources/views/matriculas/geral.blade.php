<!-- resources/views/matriculas/geral.blade.php -->
@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Matrículas Gerais</h1>

    @if($matriculas->isEmpty())
        <p>Não há matrículas disponíveis.</p>
    @else
        <table class="table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nome da Atividade</th>
                    <th>Descrição</th>
                </tr>
            </thead>
            <tbody>
                @foreach($matriculas as $matricula)
                    <tr>
                        <td>{{ $matricula->id }}</td>
                        <td>{{ $matricula->nome }}</td>
                        <td>{{ $matricula->descricao }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif
</div>
@endsection
