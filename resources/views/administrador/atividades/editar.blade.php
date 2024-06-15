@extends('layouts.app')

@section('content')
<div class="container">
    <h2>{{ __('Editar Atividade') }}</h2>
    @if(Session::has('flash_message'))
        <div class="alert {{ Session::get('flash_message.class') }}">
            {{ Session::get('flash_message.msg') }}
        </div>
    @endif
    <form action="{{ route('atividades.update', $atividade->id) }}" method="POST">
        @csrf
        @method('PUT') <!-- Especifica que é uma solicitação PUT -->
        <div class="form-group">
            <label for="atividade">{{ __('Atividade') }}</label>
            <input type="text" class="form-control" id="atividade" name="atividade" value="{{ $atividade->atividade }}" required>
        </div>
        <div class="form-group">
            <label for="data">{{ __('Data') }}</label>
            <input type="date" class="form-control" id="data" name="data" value="{{ $atividade->data }}" required>
        </div>



        <div class="form-group">
            <label for="hora">{{ __('Hora') }}</label>
            <input type="time" class="form-control" id="hora" name="hora" value="{{ old('hora', substr($atividade->hora, 0, 5)) }}" required> <!-- Ajuste para enviar apenas H:i -->
        </div>
        <div class="form-group">
            <label for="instrutor">{{ __('Instrutor') }}</label>
            <input type="text" class="form-control" id="instrutor" name="instrutor" value="{{ $atividade->instrutor }}" required>
        </div>
        <div class="form-group">
            <label for="local">{{ __('Local') }}</label>
            <input type="text" class="form-control" id="local" name="local" value="{{ $atividade->local }}" required>
        </div>
        <button type="submit" class="btn btn-success">{{ __('Atualizar') }}</button>
    </form>
</div>
@endsection
