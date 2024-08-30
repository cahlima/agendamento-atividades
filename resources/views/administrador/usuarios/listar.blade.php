@extends('layouts.app')

@section('title', 'Lista de Usuários')

@section('content')
<div class="container mt-5">
    <div class="card card-custom">
    <div class="card-body">
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
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>{{ __('ID') }}</th>
                            <th>{{ __('Nome') }}</th>
                            <th>{{ __('Sobrenome') }}</th>
                            <th>{{ __('Email') }}</th>
                            <th>{{ __('Login') }}</th>
                            <th>{{ __('Data de Nascimento') }}</th>
                            <th>{{ __('Telefone') }}</th>
                            <th>{{ __('Tipo') }}</th>
                            <th>{{ __('Ações') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($usuarios as $usuario)
                            <tr>
                                <td>{{ $usuario->id }}</td>
                                <td>{{ $usuario->nome }}</td>
                                <td>{{ $usuario->sobrenome }}</td>
                                <td>{{ $usuario->email }}</td>
                                <td>{{ $usuario->login }}</td>
                                <td>{{ \Carbon\Carbon::parse($usuario->data_nascimento)->format('d/m/Y') }}</td>
                                <td>{{ $usuario->telefone }}</td>
                                <td>{{ $usuario->tipo->nome }}</td>
                                <td>
                                    <a href="{{ route('usuarios.edit', $usuario->id) }}" class="btn btn-primary btn-sm">{{ __('Editar') }}</a>
                                    <form action="{{ route('usuarios.destroy', $usuario->id) }}" method="POST" style="display:inline-block;" onsubmit="return confirm('{{ __('Tem certeza que deseja deletar este usuário?') }}');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm">{{ __('Deletar') }}</button>
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
