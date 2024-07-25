@extends('layouts.app')

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
                    <th>{{ __('Data') }}</th>
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

<script>
document.getElementById('atividade').addEventListener('change', function() {
    var atividadeId = this.value;
    if (atividadeId) {
        fetch('/aluno/atividades/' + atividadeId + '/horarios')
            .then(response => response.json())
            .then(data => {
                var horariosList = document.getElementById('horarios-list');
                horariosList.innerHTML = '';
                data.forEach(function(horario) {
                    var listItem = document.createElement('li');
                    listItem.classList.add('list-group-item');
                    listItem.textContent = horario.hora;
                    horariosList.appendChild(listItem);
                });
                document.getElementById('horarios-disponiveis').style.display = 'block';

                fetch('/aluno/atividades/' + atividadeId)
                    .then(response => response.json())
                    .then(data => {
                        var atividadesList = document.getElementById('atividades-list');
                        atividadesList.innerHTML = '';
                        data.forEach(function(atividade) {
                            var row = document.createElement('tr');
                            row.innerHTML = `
                                <td>${atividade.atividade}</td>
                                <td>${new Date(atividade.data).toLocaleDateString()}</td>
                                <td>${atividade.hora}</td>
                                <td>${atividade.instrutor ?? 'N/A'}</td>
                                <td>${atividade.local}</td>
                                <td>
                                    <form method="POST" action="/aluno/atividades/matricular/${atividade.id}">
                                        @csrf
                                        <button type="submit" class="btn btn-primary">{{ __('Matricular') }}</button>
                                    </form>
                                </td>
                            `;
                            atividadesList.appendChild(row);
                        });
                        document.getElementById('atividades-dinamicas').style.display = 'block';
                    });
            });
    } else {
        document.getElementById('horarios-disponiveis').style.display = 'none';
        document.getElementById('atividades-dinamicas').style.display = 'none';
    }
});
</script>
@endsection
