<!-- resources/views/perfil/index.blade.php -->
@extends('layouts.base')

@section('content')
<div class="container mt-5">
    <div class="card">
        <div class="card-header">
            <h2>{{ __('Meu Perfil') }}</h2>
        </div>
        <div class="card-body">
            <table class="table table-bordered">
                <tr>
                    <th>{{ __('Tipo') }}</th>
                    <td>{{ $usuario->tipo->descricao }}</td>
                </tr>
                <tr>
                    <th>{{ __('Nome') }}</th>
                    <td>{{ $usuario->nome }}</td>
                </tr>
                <tr>
                    <th>{{ __('Sobrenome') }}</th>
                    <td>{{ $usuario->sobrenome }}</td>
                </tr>
                <tr>
                    <th>{{ __('Email') }}</th>
                    <td>{{ $usuario->email }}</td>
                </tr>
                <tr>
                    <th>{{ __('Data de Nascimento') }}</th>
                    <td>{{ $usuario->data_nascimento }}</td>
                </tr>
                <tr>
                    <th>{{ __('Telefone') }}</th>
                    <td>{{ $usuario->telefone }}</td>
                </tr>
                <tr>
                    <th>{{ __('Login') }}</th>
                    <td>{{ $usuario->login }}</td>
                </tr>
            </table>
            <a href="{{ route('admin.perfil.edit') }}" class="btn btn-primary">{{ __('Editar Perfil') }}</a>
        </div>
    </div>
</div>
@endsection
