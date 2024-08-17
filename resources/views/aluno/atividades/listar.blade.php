@extends('layouts.app')

@section('title', 'Atividades Disponíveis')

@section('content')
<div class="container" id="app">
    <h2>{{ __('Atividades disponíveis') }}</h2>

    @if(Session::has('success'))
        <div class="alert alert-success">
            {{ Session::get('success') }}
        </div>
    @endif

    <div class="mb-3">
        <label for="atividade">{{ __('Escolha uma atividade:') }}</label>
        <select id="atividade" class="form-control">
            <option value="">{{ __('Selecione uma atividade') }}</option>
            @foreach($atividades as $atividade)
                <option value="{{ $atividade->id }}">{{ $atividade->atividade }}</option>
            @endforeach
        </select>
    </div>

    <div class="mb-3" id="dias-container" style="display: none;">
        <label for="dia">{{ __('Escolha um dia:') }}</label>
        <select id="dia" class="form-control">
            <option value="">{{ __('Selecione um dia') }}</option>
            <!-- Os dias serão inseridos aqui via JavaScript -->
        </select>
    </div>

    <div id="horarios-disponiveis" style="display: none;">
        <h4>{{ __('Horários disponíveis') }}</h4>
        <ul class="list-group" id="horarios-list">
            <!-- Os horários serão inseridos aqui via JavaScript -->
        </ul>
    </div>
</div>
@endsection

@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const atividadeSelect = document.getElementById('atividade');
    const diaSelect = document.getElementById('dia');
    const diasContainer = document.getElementById('dias-container');
    const horariosDisponiveis = document.getElementById('horarios-disponiveis');
    const horariosList = document.getElementById('horarios-list');

    atividadeSelect.addEventListener('change', function() {
        const atividadeId = this.value;

        if (atividadeId) {
            fetch(`/atividades/${atividadeId}/horarios`)
                .then(response => response.json())
                .then(data => {
                    if (data.length > 0) {
                        // Limpar os dias e horários anteriores
                        diaSelect.innerHTML = '<option value="">{{ __('Selecione um dia') }}</option>';
                        horariosList.innerHTML = '';

                        // Obter dias únicos
                        const dias = [...new Set(data.map(horario => horario.dia))];
                        dias.forEach(dia => {
                            const option = document.createElement('option');
                            option.value = dia;
                            option.textContent = dia;
                            diaSelect.appendChild(option);
                        });

                        // Exibir o container de dias
                        diasContainer.style.display = 'block';

                        // Adicionar evento de mudança para o select de dias
                        diaSelect.addEventListener('change', function() {
                            const selectedDia = this.value;
                            const horariosFiltrados = data.filter(horario => horario.dia === selectedDia);

                            // Limpar a lista de horários
                            horariosList.innerHTML = '';

                            if (horariosFiltrados.length > 0) {
                                horariosFiltrados.forEach(horario => {
                                    const li = document.createElement('li');
                                    li.className = 'list-group-item';
                                    li.textContent = `${horario.hora} - ${horario.instrutor} (${horario.local})`;

                                    const matricularBtn = document.createElement('button');
                                    matricularBtn.className = 'btn btn-primary btn-sm float-end';
                                    matricularBtn.textContent = '{{ __('Matricular') }}';
                                    matricularBtn.addEventListener('click', function() {
                                        if (confirm('Deseja se matricular neste horário?')) {
                                            matricularHorario(horario.id);
                                        }
                                    });

                                    li.appendChild(matricularBtn);
                                    horariosList.appendChild(li);
                                });

                                horariosDisponiveis.style.display = 'block';
                            } else {
                                horariosDisponiveis.style.display = 'none';
                            }
                        });
                    } else {
                        // Esconder se não houver dados
                        diasContainer.style.display = 'none';
                        horariosDisponiveis.style.display = 'none';
                    }
                })
                .catch(error => {
                    console.error('Erro ao buscar horários:', error);
                    alert('Ocorreu um erro ao buscar os horários. Por favor, tente novamente.');
                });
        } else {
            diasContainer.style.display = 'none';
            horariosDisponiveis.style.display = 'none';
        }
    });

    function matricularHorario(horarioId) {
        fetch(`/atividades/matricular/${horarioId}`, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Content-Type': 'application/json'
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                alert('Matrícula realizada com sucesso!');
            } else {
                alert('Erro ao realizar a matrícula: ' + data.message);
            }
        })
        .catch(error => {
            console.error('Erro ao realizar a matrícula:', error);
            alert('Ocorreu um erro ao realizar a matrícula. Por favor, tente novamente.');
        });
    }
});
</script>
@endsection
