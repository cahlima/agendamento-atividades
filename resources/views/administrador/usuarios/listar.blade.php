@extends('layouts.app')

@section('title', 'Lista de Usuários')

@section('content')
<div class="container mt-5">
    <div class="card">
        <div class="card-header">
            <h2>{{ __('Lista de Usuários') }}</h2>
        </div>
        <div class="card-body">
            @if(Session::has('flash_message'))
                @php
                    $flashMessage = Session::get('flash_message');
                @endphp
                @if(is_array($flashMessage) && isset($flashMessage['msg']))
                    <div class="alert alert-success">{{ $flashMessage['msg'] }}</div>
                @else
                    <div class="alert alert-success">{{ $flashMessage }}</div>
                @endif
            @endif

            <a href="{{ route('usuarios.create') }}" class="btn btn-success mb-3">{{ __('Adicionar Usuário') }}</a>

            <div class="table-responsive">
                <table class="table">
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
                                    <a href="{{ route('usuarios.edit', $usuario->id) }}" class="btn btn-primary">{{ __('Editar') }}</a>
                                    <form action="{{ route('usuarios.destroy', $usuario->id) }}" method="POST" style="display:inline-block;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger">{{ __('Deletar') }}</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

                {{ $usuarios->links() }}
            </div>
        </div>
    </div>
</div>
@endsection
