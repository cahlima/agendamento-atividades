<!-- resources/views/aluno/atividades/listar.blade.php -->
@extends('layouts.base')

@section('main-content')
<div class="container-fluid">
    <div class="row">
        <!-- Sidebar -->
        <nav id="sidebar" class="col-md-3 col-lg-2 d-md-block bg-light sidebar fixed">
            <div class="position-sticky">
                <ul class="nav flex-column">
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('aluno.atividades.listar') }}">
                            {{ __('Atividades Disponíveis') }}
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('aluno.atividades.matriculadas') }}">
                            {{ __('Minhas Atividades') }}
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('aluno.perfil.edit') }}">
                            {{ __('Meu Perfil') }}
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                            {{ __('Sair') }}
                        </a>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                            @csrf
                        </form>
                    </li>
                </ul>
            </div>
        </nav>

        <!-- Main content -->
        <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
            <h2>{{ __('Atividades Disponíveis') }}</h2>

            <form action="{{ route('aluno.atividades.listar') }}" method="GET" class="mb-4">
                <div class="row">
                    <div class="col-md-4">
                        <label for="atividade_id">{{ __('Atividade') }}:</label>
                        <select name="atividade_id" id="atividade_id" class="form-control">
                            <option value="">{{ __('Selecione a atividade') }}</option>
                            @foreach($atividadesDisponiveis as $atividade)
                                <option value="{{ $atividade->id }}">{{ $atividade->atividade }}</option>
                            @endforeach
                        </select>
                      </div>
                    <div class="col-md-4 mt-4">
                        <button type="submit" class="btn btn-primary">{{ __('Pesquisar') }}</button>
                        <a href="{{ route('aluno.painel') }}" class="btn btn-secondary">{{ __('Voltar') }}</a>
                    </div>
                </div>
            </form>

            @if(isset($atividades) && $atividades->count() > 0)
                <div class="table-responsive mt-4">
                    <table class="table table-striped table-sm">
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
                        <tbody>
                            @foreach($atividades as $atividade)
                                <tr>
                                    <td>{{ $atividade->atividade }}</td>
                                    <td>{{ \Carbon\Carbon::parse($atividade->data)->format('d/m/Y') }}</td>
                                    <td>{{ $atividade->hora }}</td>
                                    <td>{{ $atividade->instrutor }}</td>
                                    <td>{{ $atividade->local }}</td>
                                    <td>
                                        <form action="{{ route('aluno.atividades.matricular', $atividade->id) }}" method="POST">
                                            @csrf
                                            <button type="submit" class="btn btn-sm btn-primary">{{ __('Matricular') }}</button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                {{ $atividades->links() }}
            @else
                <p>{{ __('Nenhuma atividade encontrada com os critérios selecionados.') }}</p>
            @endif
        </main>
    </div>
</div>
<!-- Modal -->
<div class="modal fade" id="matriculaModal" tabindex="-1" aria-labelledby="matriculaModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form id="matriculaForm" method="POST" action="{{ route('aluno.atividades.matricular', ['id' => 0]) }}">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title" id="matriculaModalLabel">{{ __('Confirmar Matrícula') }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p>{{ __('Você deseja se matricular na atividade') }} <strong id="atividadeNome"></strong> {{ __('no horário') }} <strong id="atividadeHora"></strong>?</p>
                    <input type="hidden" name="id" id="atividadeId">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{{ __('Cancelar') }}</button>
                    <button type="submit" class="btn btn-primary">{{ __('Confirmar') }}</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    var matriculaModal = document.getElementById('matriculaModal');
    matriculaModal.addEventListener('show.bs.modal', function (event) {
        var button = event.relatedTarget;
        var atividade = button.getAttribute('data-atividade');
        var data = button.getAttribute('data-data');
        var hora = button.getAttribute('data-hora');
        var id = button.getAttribute('data-id');

        var modalTitle = matriculaModal.querySelector('.modal-title');
        var modalBodyInputAtividade = matriculaModal.querySelector('#atividadeNome');
        var modalBodyInputHora = matriculaModal.querySelector('#atividadeHora');
        var modalForm = matriculaModal.querySelector('#matriculaForm');

        modalTitle.textContent = 'Confirmar Matrícula';
        modalBodyInputAtividade.textContent = atividade;
        modalBodyInputHora.textContent = data + ' ' + hora;
        modalForm.action = '{{ route('aluno.atividades.matricular', '') }}/' + id;
    });
</script>



















@endsection
