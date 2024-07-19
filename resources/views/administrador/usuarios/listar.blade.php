@extends('layouts.base')

@section('content')
<h1>Lista de Usuários</h1>

<a href="{{ route('usuario.adicionar') }}" class="btn btn-primary">Adicionar Usuário</a>

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
            <th>Email</th>
            <th>Tipo</th>
            <th>Ações</th>
        </tr>
    </thead>
    <tbody>
        @foreach($usuarios as $usuario)
            <tr>
                <td>{{ $usuario->id }}</td>
                <td>{{ $usuario->nome }}</td>
                <td>{{ $usuario->email }}</td>
                <td>{{ $usuario->tipo->nome }}</td>
                <td>
                    <a href="{{ route('usuario.editar', $usuario->id) }}" class="btn btn-sm btn-warning">Editar</a>
                    <form action="{{ route('usuario.deletar', $usuario->id) }}" method="POST" style="display:inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-sm btn-danger">Deletar</button>
                    </form>
                </td>
            </tr>
        @endforeach
    </tbody>
</table>

{{ $usuarios->links() }}

<a href="{{ route('paineladm') }}" class="btn btn-secondary mt-3">Voltar</a> <!-- Botão Voltar adicionado -->

@endsection
