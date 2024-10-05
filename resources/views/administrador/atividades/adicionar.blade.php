@extends('layouts.app')

@section('title', 'Adicionar Atividade')

@section('content')
<div class="container mt-5 d-flex justify-content-center">
    <div class="card shadow-lg" style="width: 100%; max-width: 800px;">
        <div class="card-header bg-primary text-white">
            <h2 class="text-center mb-0">{{ __('Adicionar Atividade') }}</h2>
        </div>
        <div class="card-body">
            @if($errors->any())
                <div class="alert alert-danger">
                    <ul class="mb-0">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form method="POST" action="{{ route('admin.atividades.store') }}" class="mx-auto" style="max-width: 700px;">
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
                    <label for="hora">{{ __('Horário') }}</label>
                    <input type="time" name="hora" class="form-control" value="{{ old('hora') }}" required>
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
                    <label for="instrutor">{{ __('Instrutor') }}</label>
                    <select id="instrutor" class="form-control" name="instrutor_id" required>
                        @foreach($instrutores as $instrutor)
                            <option value="{{ $instrutor->id }}">{{ $instrutor->nome }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group">
                    <label for="local">{{ __('Local') }}</label>
                    <input id="local" type="text" class="form-control" name="local" value="{{ old('local') }}" required>
                </div>

                <div class="form-group text-center">
                    <button type="submit" class="btn btn-primary">{{ __('Adicionar Atividade') }}</button>
                    <a href="{{ route('admin.atividades.index') }}" class="btn btn-secondary">{{ __('Voltar') }}</a>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Alerta de confirmação ao submeter o formulário
        const form = document.querySelector('form');
        form.addEventListener('submit', function(event) {
            const confirmSubmit = confirm('Você tem certeza que deseja adicionar essa atividade?');
            if (!confirmSubmit) {
                event.preventDefault(); // Cancela o envio se o usuário não confirmar
            }
        });
    });
</script>
@endsection
