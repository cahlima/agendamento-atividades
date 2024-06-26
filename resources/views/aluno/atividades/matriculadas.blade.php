<!-- resources/views/aluno/atividades/matriculadas.blade.php -->
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
            <h2>{{ __('Minhas Atividades') }}</h2>

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
                                        <button type="button" class="btn btn-sm btn-danger" data-bs-toggle="modal" data-bs-target="#desmatriculaModal" data-atividade="{{ $atividade->atividade }}" data-data="{{ \Carbon\Carbon::parse($atividade->data)->format('d/m/Y') }}" data-hora="{{ $atividade->hora }}" data-id="{{ $atividade->id }}">
                                            {{ __('Desmatricular') }}
                                        </button>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                {{ $atividades->links() }}
            @else
                <p>{{ __('Você não está matriculado em nenhuma atividade.') }}</p>
            @endif
        </main>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="desmatriculaModal" tabindex="-1" aria-labelledby="desmatriculaModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form id="desmatriculaForm" method="POST" action="{{ route('aluno.atividades.desmatricular', ['id' => 0]) }}">
                @csrf
                @method('DELETE')
                <div class="modal-header">
                    <h5 class="modal-title" id="desmatriculaModalLabel">{{ __('Confirmar Desmatrícula') }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p>{{ __('Você deseja se desmatricular da atividade') }} <strong id="atividadeNome"></strong> {{ __('no horário') }} <strong id="atividadeHora"></strong>?</p>
                    <input type="hidden" name="id" id="atividadeId">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{{ __('Cancelar') }}</button>
                    <button type="submit" class="btn btn-danger">{{ __('Confirmar') }}</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    var desmatriculaModal = document.getElementById('desmatriculaModal');
    desmatriculaModal.addEventListener('show.bs.modal', function (event) {
        var button = event.relatedTarget;
        var atividade = button.getAttribute('data-atividade');
        var data = button.getAttribute('data-data');
        var hora = button.getAttribute('data-hora');
        var id = button.getAttribute('data-id');

        var modalTitle = desmatriculaModal.querySelector('.modal-title');
        var modalBodyInputAtividade = desmatriculaModal.querySelector('#atividadeNome');
        var modalBodyInputHora = desmatriculaModal.querySelector('#atividadeHora');
        var modalForm = desmatriculaModal.querySelector('#desmatriculaForm');

        modalTitle.textContent = 'Confirmar Desmatrícula';
        modalBodyInputAtividade.textContent = atividade;
        modalBodyInputHora.textContent = data + ' ' + hora;
        modalForm.action = '{{ route('aluno.atividades.desmatricular', '') }}/' + id;
    });
</script>
@endsection
