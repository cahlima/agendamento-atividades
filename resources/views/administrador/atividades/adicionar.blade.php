@extends('layouts.app')

@section('content')
<div class="container">
    <h2>{{ __('Adicionar Atividade') }}</h2>

    @if($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ route('atividades.store') }}">
        @csrf

        <div class="form-group">
            <label for="atividade">{{ __('Atividade') }}</label>
            <input id="atividade" type="text" class="form-control" name="atividade" value="{{ old('atividade') }}" required>
        </div>

        <div class="form-group">
            <label for="data">{{ __('Data') }}</label>
            <input id="data" type="date" class="form-control" name="data" value="{{ old('data') }}" required>
        </div>

        <div class="form-group">
            <label for="hora">{{ __('Hora') }}</label>
            <input id="hora" type="time" class="form-control" name="hora" value="{{ old('hora') }}" required>
        </div>

        <div class="form-group">
            <label for="instrutor">{{ __('Instrutor') }}</label>
            <select id="instrutor" class="form-control" name="instrutor" required>
                @foreach($instrutores as $instrutor)
                    <option value="{{ $instrutor->id }}">{{ $instrutor->nome }}</option>
                @endforeach
            </select>
        </div>

        <div class="form-group">
            <label for="local">{{ __('Local') }}</label>
            <input id="local" type="text" class="form-control" name="local" value="{{ old('local') }}" required>
        </div>

        <div class="form-group">
            <button type="submit" class="btn btn-primary">{{ __('Adicionar Atividade') }}</button>
            <a href="{{ route('atividades.index') }}" class="btn btn-secondary">{{ __('Voltar') }}</a>
        </div>
    </form>
</div>
@endsection
