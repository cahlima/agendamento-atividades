@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row">
        <!-- Sidebar -->
        <nav id="sidebar" class="col-md-3 col-lg-2 d-md-block bg-light sidebar fixed">
            <div class="position-sticky">
                <ul class="nav flex-column">
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('paineladm') }}">
                            {{ __('Início') }}
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="{{ route('atividades.index') }}">
                            {{ __('Gerenciar Atividades') }}
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('usuarios.index') }}">
                            {{ __('Gerenciar Usuários') }}
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('admin.perfil.edit') }}">
                            {{ __('Meu Perfil') }}
                        </a>
                    </li>
                </ul>
            </div>
        </nav>

        <!-- Main content -->
        <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
            <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                <h1 class="h2">{{ __('Gerenciador de Atividades') }}</h1>
            </div>

            @if(Session::has('flash_message'))
                <div class="alert {{ Session::get('flash_message.class') }}">
                    {{ Session::get('flash_message.msg') }}
                </div>
            @endif

            <h4>{{ __('Atividades Cadastradas') }}</h4>
            <div class="table-responsive">
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
                                <a href="{{ route('atividades.editar', $atividade->id) }}" class="btn btn-sm btn-primary">{{ __('Editar') }}</a>
                                <form action="{{ route('atividades.destroy', $atividade->id) }}" method="POST" style="display:inline;" onsubmit="return confirm('{{ __('Tem certeza que deseja deletar esta atividade?') }}')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger">{{ __('Deletar') }}</button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <h4>{{ __('Cadastrar Atividades') }}</h4>
            <form action="{{ route('atividades.store') }}" method="POST">
                @csrf
                <div class="form-group">
                    <label for="atividade">{{ __('Atividade') }}</label>
                    <input type="text" class="form-control" id="atividade" name="atividade" required>
                </div>
                <div class="form-group">
                    <label for="data">{{ __('Data') }}</label>
                    <input type="date" class="form-control" id="data" name="data" required>
                </div>
                <div class="form-group">
                    <label for="hora">{{ __('Hora') }}</label>
                    <input type="time" class="form-control" id="hora" name="hora" required>
                </div>
                <div class="form-group">
                    <label for="instrutor">{{ __('Instrutor') }}</label>
                    <input type="text" class="form-control" id="instrutor" name="instrutor" required>
                </div>
                <div class="form-group">
                    <label for="local">{{ __('Local') }}</label>
                    <input type="text" class="form-control" id="local" name="local" required>
                </div>
                <button type="submit" class="btn btn-success mt-3">{{ __('Cadastrar') }}</button>
            </form>
        </main>
    </div>
</div>
@endsection
