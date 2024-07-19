@extends('layouts.base')

@section('content')
<h1>Editar Tipo de Usuário</h1>

<form action="{{ route('tipo.atualizar', $tipo->id) }}" method="POST">
    @csrf
    @method('PUT')

    <div class="mb-3">
        <label for="nome" class="form-label">Nome</label>
        <input type="text" class="form-control" id="nome" name="nome" value="{{ $tipo->nome }}" required>
    </div>

    <button type="submit" class="btn btn-primary">Atualizar</button>
</form>
@endsection
