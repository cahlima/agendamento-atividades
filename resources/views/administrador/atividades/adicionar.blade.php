@extends('layouts.app')

@section('content')
<div class="container">
    <h4>{{ __('Cadastrar Atividades') }}</h4>
    <form action="{{ route('atividades.store') }}" method="POST">
        @csrf
        <div class="form-group">
            <label for="atividade">{{ __('Atividade') }}</label>
            <input type="text" class="form-control" id="atividade" name="atividade" required>
        </div>
        <div class="form-group">
            <label for="data">{{ __('Data') }}</label>
            <input type="date" class="form-control" id="data" name="data" required>
        </div>
        <div class="form-group">
            <label for="hora">{{ __('Hora') }}</label>
            <input type="time" class="form-control" id="hora" name="hora" required>
        </div>
        <div class="form-group">
            <label for="instrutor">{{ __('Instrutor') }}</label>
            <input type="text" class="form-control" id="instrutor" name="instrutor" required>
        </div>
        <div class="form-group">
            <label for="local">{{ __('Local') }}</label>
            <input type="text" class="form-control" id="local" name="local" required>
        </div>
        <button type="submit" class="btn btn-success mt-3">{{ __('Cadastrar') }}</button>
    </form>
</div>
@endsection
