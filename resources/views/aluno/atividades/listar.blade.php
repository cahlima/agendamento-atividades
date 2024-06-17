@extends('layouts.app')

@section('content')
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

            <!-- Formulário de pesquisa por atividade e horário -->
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
                    <div class="col-md-4">
                        <label for="hora">{{ __('Horário') }}:</label>
                        <select name="hora" id="hora" class="form-control">
                            <option value="">{{ __('Selecione o horário') }}</option>
                            @foreach($horariosDisponiveis as $horario)
                                <option value="{{ $horario }}">{{ $horario }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-4 mt-4">
                        <button type="submit" class="btn btn-primary">{{ __('Pesquisar') }}</button>
                        <a href="{{ route('aluno.painel') }}" class="btn btn-secondary">{{ __('Voltar') }}</a>
                    </div>
                </div>
            </form>

            <!-- Lista de atividades filtradas, se houver -->
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

                <!-- Paginação -->
                {{ $atividades->links() }}

            @else
                <p>{{ __('Nenhuma atividade encontrada com os critérios selecionados.') }}</p>
            @endif
        </main>
    </div>
</div>
@endsection
