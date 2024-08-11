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
            <select id="atividade" name="atividade" class="form-control">
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
document.getElementById('atividade').addEventListener('change', function() {
    var atividadeId = this.value;
    if (atividadeId) {
        fetch(`/aluno/atividades/${atividadeId}`)
            .then(response => response.json())
            .then(data => {
                var atividadesList = document.getElementById('atividades-list');
                atividadesList.innerHTML = ''; // Limpa a lista de atividades

                var row = document.createElement('tr');
                row.innerHTML = `
                    <td>${data.atividade}</td>
                    <td>${new Date(data.data_inicio).toLocaleDateString()}</td>
                    <td>${new Date(data.data_fim).toLocaleDateString()}</td>
                    <td>${data.hora}</td>
                    <td>${data.instrutor ?? 'N/A'}</td>
                    <td>${data.local}</td>
                    <td>
                        <button type="button" class="btn btn-primary" data-id="${data.id}" data-atividade="${data.atividade}" data-hora="${data.hora}" data-bs-toggle="modal" data-bs-target="#confirmModal">{{ __('Matricular') }}</button>
                    </td>
                `;
                atividadesList.appendChild(row);

                document.getElementById('atividades-dinamicas').style.display = 'block';
            })
            .catch(error => console.error('Erro ao buscar atividade:', error));
    } else {
        document.getElementById('horarios-disponiveis').style.display = 'none';
        document.getElementById('atividades-dinamicas').style.display = 'none';
    }
});

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
        var form = document.createElement('form');
        form.method = 'POST';
        form.action = `/aluno/atividades/matricular/${atividadeId}`;

        var csrfInput = document.createElement('input');
        csrfInput.type = 'hidden';
        csrfInput.name = '_token';
        csrfInput.value = `{{ csrf_token() }}`;

        var methodInput = document.createElement('input');
        methodInput.type = 'hidden';
        methodInput.name = '_method';
        methodInput.value = 'POST';

        form.appendChild(csrfInput);
        form.appendChild(methodInput);
        document.body.appendChild(form);
        form.submit();
    };
});
</script>
@endsection
