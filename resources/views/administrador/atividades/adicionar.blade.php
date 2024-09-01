@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
<div class="container mt-5">
    <div class="card card-custom">
    <div class="card-body">
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

            <form method="POST" action="{{ route('admin.atividades.store') }}">
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

                <!-- Seção de horários -->
                <div class="form-group">
                    <label for="hora">{{ __('Horários') }}</label>
                    <div id="horarios-container">
                        <div class="input-group mb-3">
                            <input type="time" name="hora[]" class="form-control" value="{{ old('hora.0') }}" required>
                            <div class="input-group-append">
                                <button type="button" class="btn btn-success add-hora">{{ __('Adicionar Horário') }}</button>
                            </div>
                        </div>
                    </div>
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
                <div class="form-group">
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

        var container = document.getElementById('horarios-container');

        // Adicionar novo campo de horário
        document.querySelector('.add-hora').addEventListener('click', function() {
            var newInput = document.createElement('div');
            newInput.classList.add('input-group', 'mb-2');
            newInput.innerHTML = `
                <input type="time" name="hora[]" class="form-control" required>
                <div class="input-group-append">
                    <button type="button" class="btn btn-danger remove-hora">{{ __('Remover') }}</button>
                </div>
            `;
            container.appendChild(newInput);

            // Adicionar evento para remover horário
            newInput.querySelector('.remove-hora').addEventListener('click', function() {
                newInput.remove();
            });
        });

        // Remover horário existente
        document.querySelectorAll('.remove-hora').forEach(function(button) {
            button.addEventListener('click', function() {
                button.closest('.input-group').remove();
            });
        });
    });
</script>

@endsection
