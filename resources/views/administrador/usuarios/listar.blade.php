<!-- resources/views/administrador/usuarios/listar.blade.php -->
@extends('layouts.base')

@section('content')
<h1>Lista de Usuários</h1>

<a href="{{ route('usuarios.create') }}" class="btn btn-success">Adicionar Usuário</a>

<table class="table">
    <thead>
        <tr>
            <th>ID</th>
            <th>Nome</th>
            <th>Email</th>
            <th>Ações</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($usuarios as $usuario)
            <tr>
                <td>{{ $usuario->id }}</td>
                <td>{{ $usuario->nome }}</td>
                <td>{{ $usuario->email }}</td>
                <td>
                    <a href="{{ route('usuarios.edit', ['id' => $usuario->id]) }}" class="btn btn-primary">Editar</a>
                    <form action="{{ route('usuarios.destroy', ['id' => $usuario->id]) }}" method="POST" style="display:inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">Deletar</button>
                    </form>
                </td>
            </tr>
        @endforeach
    </tbody>
</table>
@endsection
