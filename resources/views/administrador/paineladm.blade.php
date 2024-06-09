@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row">
        <!-- Sidebar -->
        <div class="col-md-2 sidebar">
            <div class="user-info">
                <img src="path/to/user/image.jpg" alt="User Image" class="img-fluid rounded-circle mb-3">
                <h5>Olá, {{ Auth::user()->name }}</h5>
            </div>
            <ul class="nav flex-column">
                <li class="nav-item">
                    <a class="nav-link active" href="#">Consultar Atividades</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">Cadastrar Atividades</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">Meu Perfil</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-danger" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                        Sair
                    </a>
                </li>
            </ul>
        </div>

        <!-- Main Content -->
        <div class="col-md-10 content">
            <div class="card">
                <div class="card-header">{{ __('Painel Administrativo') }}</div>

                <div class="card-body">
                    <p>{{ __('Bem-vindo(a) ao painel administrativo! Utilize o menu ao lado para navegar.') }}</p>

                    <div class="mt-4">
                        <h4>{{ __('Atividades Cadastradas') }}</h4>
                        @if(isset($atividades) && $atividades->count() > 0)
                            @foreach ($atividades as $atividade)
                                <div class="card mb-3">
                                    <div class="card-body">
                                        <h5 class="card-title">{{ $atividade->nome }}</h5>
                                        <p class="card-text">{{ $atividade->descricao }}</p>
                                    </div>
                                </div>
                            @endforeach
                        @else
                            <p>{{ __('Nenhuma atividade cadastrada.') }}</p>
                        @endif
                    </div>

                    <div class="mt-4">
                        <h4>{{ __('Alunos Cadastrados') }}</h4>
                        @if(isset($alunos) && $alunos->count() > 0)
                            @foreach ($alunos as $aluno)
                                <div class="card mb-3">
                                    <div class="card-body">
                                        <h5 class="card-title">{{ $aluno->nome }}</h5>
                                    </div>
                                </div>
                            @endforeach
                        @else
                            <p>{{ __('Nenhum aluno cadastrado.') }}</p>
                        @endif
                    </div>

                    <div class="mt-4">
                                        <h4>{{ __('Cadastrar Atividades') }}</h4>
                    <form action="{{ route('atividades.store') }}" method="POST">
                        @csrf
                        <div class="form-group">
                            <label for="titulo">{{ __('Título') }}</label>
                            <input type="text" class="form-control" id="titulo" name="titulo" required>
                        </div>
                        <div class="form-group">
                            <label for="descricao">{{ __('Descrição') }}</label>
                            <input type="text" class="form-control" id="descricao" name="descricao" required>
                        </div>
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
                        <button type="submit" class="btn btn-success mt-3">{{ __('Avançar') }}</button>
                    </form>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
