@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">{{ __('Listagem de Usuários') }}</div>
                <!-- @dump(auth()->user()) -->
                <div class="card-body">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Tipo Usuário</th>
                                <th>Nome</th>
                                <th>Sobrenome</th>
                                <th>Login</th>
                                @can('update', App\Models\User::class)
                                    <th>Opções</th>
                                @endcan
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($usuarios as $usuario)
                            <tr>
                                <td>{{ $usuario->id }}</td>
                                <td>{{ $usuario->tipo_id }}</td>
                                <td>{{ $usuario->nome }}</td>
                                <td>{{ $usuario->sobrenome }}</td>
                                <td>{{ $usuario->login }}</td>
                                @can('update', [$user, $usuarios])
                                <td>
                                    <a href="{{ route('usuario.editar', $usuario->id) }}" class="btn btn-warning">Editar</a>
                                    <a href="javascript: if(confirm('Realmente deseja deletar?')) { window.location.href = '{{ route('usuario.deletar', $usuario->id) }}'}" class="btn btn-danger">Excluir</a>
                                </td>
                                @endcan
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                    @can('create', App\Models\User::class)
                    <a href="{{ route('usuario.adicionar') }}" class="btn btn-primary">Adicionar</a>
                    @endcan
                </div>

                @if(Session::has('flash_message'))
                    <div class="container">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="alert {{ Session::get('flash_message')['class'] }} text-center">
                                    {{ Session::get('flash_message')['msg'] }}
                                </div>
                            </div>
                        </div>
                    </div>
                @endif

            </div>
        </div>
    </div>
</div>
@endsection
