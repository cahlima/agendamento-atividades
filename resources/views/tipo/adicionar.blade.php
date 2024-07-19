@extends('layouts.base')

@section('content')
<h1>Adicionar Novo Tipo de Usuário</h1>

<form action="{{ route('tipo.salvar') }}" method="POST">
    @csrf

    <div class="mb-3">
        <label for="nome" class="form-label">Nome</label>
        <input type="text" class="form-control" id="nome" name="nome" required>
    </div>

    <button type="submit" class="btn btn-primary">Salvar</button>
</form>
@endsection
