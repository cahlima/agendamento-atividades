@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-10">
                <div class="card">
                    <div class="card-header">Lista de Usuários</div>

                    <div class="card-body">
                        @if(session('flash_message'))
                            <div class="alert {{ session('flash_message.class') }}" role="alert">
                                {{ session('flash_message.msg') }}
                            </div>
                        @endif

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
                                        <td>{{ $usuario->tipo_id }}</td>
                                        <td>
                                            <a href="{{ route('usuario.editar', $usuario->id) }}" class="btn btn-primary">Editar</a>
                                            <form action="{{ route('usuario.deletar', $usuario->id) }}" method="POST" style="display: inline;">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger" onclick="return confirm('Tem certeza que deseja excluir este usuário?')">Excluir</button>
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
    </div>
@endsection
