@extends('layouts.base')

@section('content')
<div class="container mt-5">
    <div class="card">
        <div class="card-header">
            <h2>{{ __('Adicionar Atividade') }}</h2>
        </div>
        <div class="card-body">
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

                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label for="data_inicio">{{ __('Data de Início') }}</label>
                        <input id="data_inicio" type="date" class="form-control" name="data_inicio" value="{{ old('data_inicio') }}" required>
                    </div>
                    <div class="form-group col-md-6">
                        <label for="data_fim">{{ __('Data de Fim') }}</label>
                        <input id="data_fim" type="date" class="form-control" name="data_fim" value="{{ old('data_fim') }}" required>
                    </div>
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
                    <label for="dias">{{ __('Dias da Semana') }}</label>
                    <select id="dias" class="form-control" name="dias[]" multiple required>
                        @php
                            $dias_semana = ['domingo', 'segunda', 'terca', 'quarta', 'quinta', 'sexta', 'sabado'];
                        @endphp
                        @foreach($dias_semana as $dia)
                            <option value="{{ $dia }}" {{ in_array($dia, old('dias', [])) ? 'selected' : '' }}>
                                {{ ucfirst($dia) }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group">
                    <button type="submit" class="btn btn-primary">{{ __('Adicionar Atividade') }}</button>
                    <a href="{{ route('atividades.index') }}" class="btn btn-secondary">{{ __('Voltar') }}</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
