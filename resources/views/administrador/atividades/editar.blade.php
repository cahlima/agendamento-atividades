@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row">
        <!-- Sidebar -->
        <nav id="sidebar" class="col-md-3 col-lg-2 d-md-block bg-light sidebar collapse">
            <div class="position-sticky">
                <ul class="nav flex-column">
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('paineladm') }}">
                            {{ __('Gerenciar Atividades') }}
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('usuario.index') }}">
                            {{ __('Gerenciar Usuários') }}
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('perfil.edit') }}">
                            {{ __('Meu Perfil') }}
                        </a>
                    </li>
                </ul>
            </div>
        </nav>

        <!-- Main content -->
        <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
            <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                <h1 class="h2">{{ __('Editar Atividade') }}</h1>
            </div>

            <form action="{{ route('atividades.update', $atividade->id) }}" method="POST" style="max-width: 600px;">
                @csrf
                @method('POST')
                <div class="form-group">
                    <label for="atividade">{{ __('Atividade') }}</label>
                    <input type="text" class="form-control" id="atividade" name="atividade" value="{{ $atividade->atividade }}" required>
                </div>
                <div class="form-group">
                    <label for="data">{{ __('Data') }}</label>
                    <input type="date" class="form-control" id="data" name="data" value="{{ $atividade->data }}" required>
                </div>
                <div class="form-group">
                    <label for="hora">{{ __('Hora') }}</label>
                    <input type="time" class="form-control" id="hora" name="hora" value="{{ $atividade->hora }}" required>
                </div>
                <div class="form-group">
                    <label for="instrutor">{{ __('Instrutor') }}</label>
                    <input type="text" class="form-control" id="instrutor" name="instrutor" value="{{ $atividade->instrutor }}" required>
                </div>
                <div class="form-group">
                    <label for="local">{{ __('Local') }}</label>
                    <input type="text" class="form-control" id="local" name="local" value="{{ $atividade->local }}" required>
                </div>
                <button type="submit" class="btn btn-success mt-3">{{ __('Atualizar') }}</button>
            </form>
        </main>
    </div>
</div>
@endsection
