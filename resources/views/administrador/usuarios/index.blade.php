<!-- resources/views/usuario/index.blade.php -->
@extends('layouts.base')

@section('main-content')
<h2>{{ __('Lista de Usuários') }}</h2>

<a href="{{ route('usuario.adicionar') }}" class="btn btn-primary">{{ __('Adicionar Usuário') }}</a>

<table class="table mt-4">
    <thead>
        <tr>
            <th>{{ __('Nome') }}</th>
            <th>{{ __('Email') }}</th>
            <th>{{ __('Tipo') }}</th>
            <th>{{ __('Ações') }}</th>
        </tr>
    </thead>
    <tbody>
        @foreach($usuarios as $usuario)
        <tr>
            <td>{{ $usuario->nome }}</td>
            <td>{{ $usuario->email }}</td>
            <td>{{ $usuario->tipo->nome }}</td>
            <td>
                <a href="{{ route('usuario.editar', $usuario->id) }}" class="btn btn-sm btn-warning">{{ __('Editar') }}</a>
                <form action="{{ route('usuario.deletar', $usuario->id) }}" method="POST" style="display:inline;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-sm btn-danger">{{ __('Deletar') }}</button>
                </form>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>

{{ $usuarios->links() }}
@endsection
