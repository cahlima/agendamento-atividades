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

    <form id="buscar-atividade-form" method="GET" action="{{ route('atividades.listarAtividades') }}" class="mb-3">
        <div class="input-group">
            <select id="atividade" name="atividade" class="form-control" onchange="mostrarDetalhesAtividade(this.value)">
                <option value="">{{ __('Selecione uma atividade') }}</option>
                @foreach($atividades as $atividade)
                    <option value="{{ $atividade->id }}">{{ $atividade->atividade }}</option>
                @endforeach
            </select>
        </div>
    </form>

    <div id="detalhes-atividade" style="display: none;">
        <h4>{{ __('Detalhes da Atividade') }}</h4>
        <table class="table mt-4">
            <thead>
                <tr>
                    <th>{{ __('Data de Início') }}</th>
                    <th>{{ __('Data de Término') }}</th>
                    <th>{{ __('Dia da Semana') }}</th>
                    <th>{{ __('Hora') }}</th>
                    <th>{{ __('Instrutor') }}</th>
                    <th>{{ __('Local') }}</th>
                    <th>{{ __('Ações') }}</th>
                </tr>
            </thead>
            <tbody id="detalhes-atividade-list">
                <!-- Detalhes serão preenchidos dinamicamente -->
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
                <form id="matricular-form" method="POST">
                    @csrf
                    <button type="submit" class="btn btn-primary">{{ __('Confirmar') }}</button>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
function mostrarDetalhesAtividade(atividadeId) {
    if (atividadeId) {
        fetch(`/atividades/${atividadeId}`)
            .then(response => response.json())
            .then(data => {
                var detalhesList = document.getElementById('detalhes-atividade-list');
                detalhesList.innerHTML = ''; // Limpa a lista de detalhes

                if (data.horarios && data.horarios.length > 0) {
                    data.horarios.forEach(horario => {
                        var tr = document.createElement('tr');

                        tr.innerHTML = `
                            <td>${data.data_inicio}</td>
                            <td>${data.data_fim}</td>
                            <td>${horario.dia_semana}</td>
                            <td>${horario.hora}</td>
                            <td>${data.instrutor}</td>
                            <td>${data.local}</td>
                            <td>
                                <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#confirmModal" data-id="${data.id}" data-atividade="${data.atividade}" data-hora="${horario.hora}">
                                    {{ __('Matricular') }}
                                </button>
                            </td>
                        `;

                        detalhesList.appendChild(tr);
                    });
                    document.getElementById('detalhes-atividade').style.display = 'block';
                } else {
                    document.getElementById('detalhes-atividade').style.display = 'none';
                }
            })
            .catch(error => {
                console.error('Erro ao buscar detalhes da atividade:', error);
                alert('Ocorreu um erro ao buscar os detalhes da atividade. Por favor, tente novamente.');
            });
    } else {
        document.getElementById('detalhes-atividade').style.display = 'none';
    }
}

document.getElementById('confirmModal').addEventListener('show.bs.modal', function (event) {
    var button = event.relatedTarget;
    var atividadeId = button.getAttribute('data-id');

    var form = document.getElementById('matricular-form');
    form.action = `/atividades/matricular/${atividadeId}`;
});
</script>
@endsection
