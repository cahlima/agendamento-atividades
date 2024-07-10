<!-- resources/views/administrador/atividades/adicionar.blade.php -->
@extends('layouts.base')

@section('main-content')
    <div class="container">
        <h2>Adicionar Nova Atividade</h2>

        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('atividades.store') }}" method="POST">
            @csrf
            <div class="mb-3">
                <label for="atividade" class="form-label">Nome da Atividade</label>
                <input type="text" class="form-control" id="atividade" name="atividade" value="{{ old('atividade') }}" required>
            </div>
            <div class="mb-3">
                <label for="data" class="form-label">Data</label>
                <input type="date" class="form-control" id="data" name="data" value="{{ old('data') }}" required>
            </div>
            <div class="mb-3">
                <label for="hora" class="form-label">Hora</label>
                <input type="time" class="form-control" id="hora" name="hora" value="{{ old('hora') }}" required>
            </div>
            <select name="professor_id" class="form-control">
    <option value="">Selecione um Instrutor</option>
    @foreach($professores as $professor)
        <option value="{{ $professor->id }}" @if(isset($atividade) && $atividade->professor_id == $professor->id) selected @endif>
            {{ $professor->usuario->nome }} <!-- Assumindo que você tem um relacionamento com a tabela de usuários -->
        </option>
    @endforeach
</select>

            </div>
            <div class="mb-3">
                <label for="local" class="form-label">Local</label>
                <input type="text" class="form-control" id="local" name="local" value="{{ old('local') }}" required>
            </div>
            <button type="submit" class="btn btn-primary">Salvar</button>
        </form>
    </div>
@endsection
