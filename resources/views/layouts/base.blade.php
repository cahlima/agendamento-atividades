<!-- resources/views/layouts/base.blade.php -->
@extends('layouts.app')

@section('sidebar')
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
@endsection

@section('header')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">{{ __('Atividades Disponíveis') }}</h1>
</div>
@if(Session::has('flash_message'))
    <div class="alert {{ Session::get('flash_message.class') }}">
        {{ Session::get('flash_message.msg') }}
    </div>
@endif
@endsection

@section('content')
<div class="container-fluid">
    <div class="row">
        @yield('sidebar')

        <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
            @yield('header')
            @yield('main-content')
        </main>
    </div>
</div>

<!-- Modal de Confirmação de Matrícula -->
<div class="modal fade" id="confirmMatriculaModal" tabindex="-1" aria-labelledby="confirmMatriculaModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="confirmMatriculaModalLabel">{{ __('Confirmar Matrícula') }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p>{{ __('Você está prestes a se matricular na atividade:') }}</p>
                <p id="modal-matricula-atividade"></p>
                <p id="modal-matricula-dia"></p>
                <p id="modal-matricula-horario"></p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{{ __('Cancelar') }}</button>
                <button type="button" class="btn btn-primary" id="confirmMatriculaButton">{{ __('Confirmar') }}</button>
            </div>
        </div>
    </div>
</div>

<!-- Modal de Confirmação de Desmatrícula -->
<div class="modal fade" id="confirmDesmatriculaModal" tabindex="-1" aria-labelledby="confirmDesmatriculaModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="confirmDesmatriculaModalLabel">{{ __('Confirmar Desmatrícula') }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p>{{ __('Você está prestes a se desmatricular da atividade:') }}</p>
                <p id="modal-desmatricula-atividade"></p>
                <p id="modal-desmatricula-dia"></p>
                <p id="modal-desmatricula-horario"></p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{{ __('Cancelar') }}</button>
                <button type="button" class="btn btn-danger" id="confirmDesmatriculaButton">{{ __('Confirmar') }}</button>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    function showMatriculaModal(atividade, dia, horario, form) {
        document.getElementById('modal-matricula-atividade').innerText = `Atividade: ${atividade}`;
        document.getElementById('modal-matricula-dia').innerText = `Dia: ${dia}`;
        document.getElementById('modal-matricula-horario').innerText = `Horário: ${horario}`;
        
        var confirmButton = document.getElementById('confirmMatriculaButton');
        confirmButton.onclick = function() {
            form.submit();
        };

        var modal = new bootstrap.Modal(document.getElementById('confirmMatriculaModal'));
        modal.show();
    }

    function showDesmatriculaModal(atividade, dia, horario, form) {
        document.getElementById('modal-desmatricula-atividade').innerText = `Atividade: ${atividade}`;
        document.getElementById('modal-desmatricula-dia').innerText = `Dia: ${dia}`;
        document.getElementById('modal-desmatricula-horario').innerText = `Horário: ${horario}`;
        
        var confirmButton = document.getElementById('confirmDesmatriculaButton');
        confirmButton.onclick = function() {
            form.submit();
        };

        var modal = new bootstrap.Modal(document.getElementById('confirmDesmatriculaModal'));
        modal.show();
    }
</script>
@endsection
