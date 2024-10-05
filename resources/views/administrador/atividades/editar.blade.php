@extends('layouts.app')

@section('title', 'Editar Atividade')

@section('content')
<div class="container mt-5 d-flex justify-content-center">
    <div class="card shadow-lg" style="width: 100%; max-width: 800px;">
        <div class="card-header bg-primary text-white">
            <h2 class="text-center mb-0">{{ __('Editar Atividade') }}</h2>
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

            <!-- Formulário de edição -->
            <form method="POST" action="{{ route('admin.atividades.update', $atividade->id) }}" class="mx-auto" style="max-width: 700px;">
                @csrf
                @method('PUT')

                <div class="form-group">
                    <label for="atividade">{{ __('Atividade') }}</label>
                    <input id="atividade" type="text" class="form-control" name="atividade" value="{{ $atividade->atividade }}" required>
                </div>

                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label for="data_inicio">{{ __('Data de Início') }}</label>
                        <input id="data_inicio" type="date" class="form-control" name="data_inicio" value="{{ $atividade->data_inicio }}" required>
                    </div>
                    <div class="form-group col-md-6">
                        <label for="data_fim">{{ __('Data de Fim') }}</label>
                        <input id="data_fim" type="date" class="form-control" name="data_fim" value="{{ $atividade->data_fim }}" required>
                    </div>
                </div>

                <!-- Seção de horários -->
                <div class="form-group">
                    <label for="hora">{{ __('Horários') }}</label>
                    <div id="horarios-container">
                        @foreach(explode(',', $atividade->hora) as $index => $horario)
                            <div class="input-group mb-2">
                                <input type="time" name="hora[]" class="form-control" value="{{ $horario }}" required>
                                <div class="input-group-append">
                                    <button type="button" class="btn btn-danger remove-hora">Remover</button>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    <button type="button" class="btn btn-secondary mt-2 add-hora">Adicionar Horário</button>
                </div>

                <div class="form-group">
                    <label for="dias">{{ __('Dias da Semana') }}</label>
                    <select id="dias" class="form-control" name="dias[]" multiple required>
                        @php
                            $dias_semana = ['domingo', 'segunda', 'terca', 'quarta', 'quinta', 'sexta', 'sabado'];
                            $dias_selecionados = explode(',', $atividade->dias);
                        @endphp
                        @foreach($dias_semana as $dia)
                            <option value="{{ $dia }}" {{ in_array($dia, $dias_selecionados) ? 'selected' : '' }}>
                                {{ ucfirst($dia) }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group">
                    <label for="instrutor">{{ __('Instrutor') }}</label>
                    <select id="instrutor" class="form-control" name="instrutor_id" required>
                        @foreach($instrutores as $instrutor)
                            <option value="{{ $instrutor->id }}" {{ $instrutor->id == $atividade->instrutor_id ? 'selected' : '' }}>
                                {{ $instrutor->nome }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group">
                    <label for="local">{{ __('Local') }}</label>
                    <input id="local" type="text" class="form-control" name="local" value="{{ $atividade->local }}" required>
                </div>

                <div class="form-group text-center">
                    <button type="submit" class="btn btn-primary">{{ __('Salvar Alterações') }}</button>
                    <a href="{{ route('admin.atividades.index') }}" class="btn btn-secondary">{{ __('Voltar') }}</a>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        var container = document.getElementById('horarios-container');

        // Adicionar novo campo de horário
        document.querySelector('.add-hora').addEventListener('click', function() {
            var newInput = document.createElement('div');
            newInput.classList.add('input-group', 'mb-2');
            newInput.innerHTML = `
                <input type="time" name="hora[]" class="form-control" required>
                <div class="input-group-append">
                    <button type="button" class="btn btn-danger remove-hora">Remover</button>
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
