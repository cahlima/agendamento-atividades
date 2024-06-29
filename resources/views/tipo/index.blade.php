@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Lista de Tipos') }}</div>

                <div class="card-body">
                    @if (session('success'))
                        <div class="alert alert-success">
                            {{ session('success') }}
                        </div>
                    @endif

                    <a href="{{ route('tipo.adicionar') }}" class="btn btn-primary mb-3">Adicionar Tipo</a>

                    @if ($tipos->count())
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Nome</th>
                                    <th>Ações</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($tipos as $tipo)
                                    <tr>
                                        <td>{{ $tipo->id }}</td>
                                        <td>{{ $tipo->nome }}</td>
                                        <td>
                                            <a href="{{ route('tipo.editar', $tipo->id) }}" class="btn btn-warning">Editar</a>
                                            <form action="{{ route('tipo.deletar', $tipo->id) }}" method="POST" style="display: inline-block;">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger">Deletar</button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        {{ $tipos->links() }}
                    @else
                        <p>Nenhum tipo encontrado.</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
