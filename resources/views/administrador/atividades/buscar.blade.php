@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
<div class="container">
    <h2>{{ __('Buscar Atividades') }}</h2>

    <form id="buscar-atividade-form">
        <div class="form-group">
            <label for="atividade">{{ __('Atividade') }}</label>
            <select id="atividade" class="form-control" name="atividade" required>
                <option value="">{{ __('Selecione uma atividade') }}</option>
                @foreach($atividades as $atividade)
                    <option value="{{ $atividade->id }}">{{ $atividade->titulo }}</option>
                @endforeach
            </select>
        </div>
    </form>

    <div id="horarios-disponiveis" style="display: none;">
        <h4>{{ __('Horários Disponíveis') }}</h4>
        <form id="matricular-form" method="POST" action="{{ route('atividades.matricular') }}">
            @csrf
            <input type="hidden" name="atividade_id" id="atividade-id">
            <div class="form-group">
                <label for="horario">{{ __('Horário') }}</label>
                <select id="horario" class="form-control" name="horario_id" required>
                    <!-- Horários serão preenchidos via JavaScript -->
                </select>
            </div>
            <button type="submit" class="btn btn-primary">{{ __('Matricular') }}</button>
        </form>
    </div>
</div>

<script>
document.getElementById('atividade').addEventListener('change', function() {
    var atividadeId = this.value;
    if (atividadeId) {
        fetch('/atividades/' + atividadeId + '/horarios')
            .then(response => response.json())
            .then(data => {
                var horariosSelect = document.getElementById('horario');
                horariosSelect.innerHTML = '';
                data.forEach(function(horario) {
                    var option = document.createElement('option');
                    option.value = horario.id;
                    option.text = horario.hora;
                    horariosSelect.appendChild(option);
                });
                document.getElementById('horarios-disponiveis').style.display = 'block';
                document.getElementById('atividade-id').value = atividadeId;
            });
    } else {
        document.getElementById('horarios-disponiveis').style.display = 'none';
    }
});
</script>
@endsection
