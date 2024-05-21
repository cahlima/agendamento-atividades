<!-- resources/views/atividades/index.blade.php -->

@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Lista de Atividades</h1>
    <a href="{{ route('atividades.create') }}" class="btn btn-primary">Criar Nova Atividade</a>
    <table class="table">
        <thead>
            <tr>
                <th>Título</th>
                <th>Descrição</th>
                <th>Ações</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($atividades as $atividade)
                <tr>
                    <td>{{ $atividade->titulo }}</td>
                    <td>{{ $atividade->descricao }}</td>
                    <td>
                        <a href="{{ route('atividades.show', $atividade->id) }}" class="btn btn-info">Ver</a>
                        <a href="{{ route('atividades.edit', $atividade->id) }}" class="btn btn-warning">Editar</a>
                        <form action="{{ route('atividades.destroy', $atividade->id) }}" method="POST" style="display:inline-block;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger">Excluir</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
