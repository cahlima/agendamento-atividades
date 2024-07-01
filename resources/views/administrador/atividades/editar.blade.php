@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Editar Atividade') }}</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('atividades.atualizar', $atividade->id) }}">
                        @csrf
                        @method('PUT')

                        <div class="form-group">
                            <label for="atividade">Atividade</label>
                            <input type="text" class="form-control @error('atividade') is-invalid @enderror" id="atividade" name="atividade" value="{{ $atividade->atividade }}" required>
                            @error('atividade')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="data">Data</label>
                            <input type="date" class="form-control @error('data') is-invalid @enderror" id="data" name="data" value="{{ $atividade->data }}" required>
                            @error('data')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="hora">Hora</label>
                            <input type="time" class="form-control @error('hora') is-invalid @enderror" id="hora" name="hora" value="{{ $atividade->hora }}" required>
                            @error('hora')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="instrutor">Instrutor</label>
                            <select class="form-control @error('instrutor') is-invalid @enderror" id="instrutor" name="instrutor" required>
                                <option value="">Selecione o instrutor</option>
                                @foreach($instrutores as $instrutor)
                                    <option value="{{ $instrutor->id }}" {{ $instrutor->id == $atividade->instrutor ? 'selected' : '' }}>{{ $instrutor->nome }}</option>
                                @endforeach
                            </select>
                            @error('instrutor')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="local">Local</label>
                            <input type="text" class="form-control @error('local') is-invalid @enderror" id="local" name="local" value="{{ $atividade->local }}" required>
                            @error('local')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <button type="submit" class="btn btn-primary">
                            {{ __('Salvar') }}
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
