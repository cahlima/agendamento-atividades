@extends('layouts.app')

@section('title', 'Atividades Disponíveis')

@section('content')
<div class="container">
    <h2>{{ __('Atividades Disponíveis') }}</h2>

    @if(Session::has('success'))
        <div class="alert alert-success">
            {{ Session::get('success') }}
        </div>
    @endif

    <form id="buscar-atividade-form" method="GET" action="{{ route('aluno.atividades.listar') }}" class="mb-3">
        <div class="input-group">
            <select id="atividade" name="atividade" class="form-control" onchange="buscarHorarios(this.value)">
                <option value="">{{ __('Selecione uma atividade') }}</option>
                @foreach($atividades as $atividade)
                    <option value="{{ $atividade->id }}">{{ $atividade->atividade }}</option>
                @endforeach
            </select>
        </div>
    </form>

    <div id="horarios-disponiveis" style="display: none;">
        <h4>{{ __('Horários Disponíveis') }}</h4>
        <ul id="horarios-list" class="list-group">
            <!-- Horários serão preenchidos via JavaScript -->
        </ul>
    </div>

    <div id="atividades-dinamicas" style="display: none;">
        <table class="table mt-4">
            <thead>
                <tr>
                    <th>{{ __('Atividade') }}</th>
                    <th>{{ __('Data de Início') }}</th>
                    <th>{{ __('Data de Término') }}</th>
                    <th>{{ __('Hora') }}</th>
                    <th>{{ __('Instrutor') }}</th>
                    <th>{{ __('Local') }}</th>
                    <th>{{ __('Ações') }}</th>
                </tr>
            </thead>
            <tbody id="atividades-list">
                <!-- Atividades serão preenchidas via JavaScript -->
            </tbody>
        </table>
    </div>
</div>

<!-- Modal de Confirmação -->
<div class="modal fade" id="confirmModal" tabindex="-1" aria-labelledby="confirmModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="confirmModalLabel">{{ __('Confirmação de Matrícula') }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p id="confirmMessage">{{ __('Você está se matriculando na atividade selecionada.') }}</p>
                <p>{{ __('Podemos confirmar?') }}</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{{ __('Cancelar') }}</button>
                <button type="button" id="confirmBtn" class="btn btn-primary">{{ __('Confirmar') }}</button>
            </div>
        </div>
    </div>
</div>

<script>
// Inicialize o select2
$(document).ready(function() {
    $('#atividade').select2({
        placeholder: "{{ __('Selecione uma atividade') }}",
        allowClear: true
    });
});

// Função para buscar horários via AJAX
function buscarHorarios(atividadeId) {
    if (atividadeId) {
        fetch(`/aluno/atividades/${atividadeId}/horarios`)
            .then(response => response.json())
            .then(data => {
                var horariosList = document.getElementById('horarios-list');
                horariosList.innerHTML = ''; // Limpa a lista de horários

                if (data.length > 0) {
                    data.forEach(horario => {
                        var li = document.createElement('li');
                        li.className = 'list-group-item';
                        li.textContent = horario.hora;
                        horariosList.appendChild(li);
                    });
                    document.getElementById('horarios-disponiveis').style.display = 'block';
                } else {
                    document.getElementById('horarios-disponiveis').style.display = 'none';
                }
            })
            .catch(error => {
                console.error('Erro ao buscar horários:', error);
                alert('Ocorreu um erro ao buscar os horários. Por favor, tente novamente.');
            });
    } else {
        document.getElementById('horarios-disponiveis').style.display = 'none';
    }
}

// Configurar o modal de confirmação
document.getElementById('confirmModal').addEventListener('show.bs.modal', function (event) {
    var button = event.relatedTarget;
    var atividadeId = button.getAttribute('data-id');
    var atividadeNome = button.getAttribute('data-atividade');
    var atividadeHora = button.getAttribute('data-hora');

    var confirmMessage = document.getElementById('confirmMessage');
    confirmMessage.textContent = `Você está se matriculando na atividade "${atividadeNome}" às ${atividadeHora}. Podemos confirmar?`;

    var confirmBtn = document.getElementById('confirmBtn');
    confirmBtn.onclick = function() {
        confirmBtn.disabled = true;
        var form = document.createElement('form');
        form.method = 'POST';
        form.action = `/aluno/atividades/matricular/${atividadeId}`;

        var csrfInput = document.createElement('input');
        csrfInput.type = 'hidden';
        csrfInput.name = '_token';
        csrfInput.value = `{{ csrf_token() }}`;

        form.appendChild(csrfInput);
        document.body.appendChild(form);
        form.submit();
    };
});
</script>
@endsection
