@extends('layouts.app')

@section('content')
<h1>Lista de Tipos de Usuários</h1>

<a href="{{ route('tipo.adicionar') }}" class="btn btn-primary">Adicionar Novo Tipo</a>

@if(session('success'))
    <div class="alert alert-success mt-2">
        {{ session('success') }}
    </div>
@endif

<table class="table mt-3">
    <thead>
        <tr>
            <th>ID</th>
            <th>Nome</th>
            <th>Ações</th>
        </tr>
    </thead>
    <tbody>
        @foreach($tipos as $tipo)
            <tr>
                <td>{{ $tipo->id }}</td>
                <td>{{ $tipo->nome }}</td>
                <td>
                    <a href="{{ route('tipo.editar', $tipo->id) }}" class="btn btn-sm btn-warning">Editar</a>
                    <form action="{{ route('tipo.deletar', $tipo->id) }}" method="POST" style="display:inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-sm btn-danger">Deletar</button>
                    </form>
                </td>
            </tr>
        @endforeach
    </tbody>
</table>

{{ $tipos->links() }}

@endsection
