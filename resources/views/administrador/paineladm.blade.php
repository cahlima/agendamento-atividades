@extends('layouts.app')

@section('content')
<div class="container">
    <div class="card">
        <div class="card-header">{{ __('Painel Administrativo') }}</div>

        <div class="card-body">
            @auth
                @if(session('status'))
                    <div class="alert alert-success" role="alert">
                        {{ session('status') }}
                    </div>
                @endif

                <p>{{ __('Você está no painel Administrativo') }}</p>

                <a href="{{ route('logout') }}"
                    onclick="event.preventDefault();
                    document.getElementById('logout-form').submit();">
                    Logout
                </a>

                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                    @csrf
                </form>

                <div class="mb-3">
                    <a href="{{ route('admin.atividades.create') }}">Criar Atividade</a>
                </div>

                <div class="mt-4">
                    <h4>{{ __('Atividades Cadastradas') }}</h4>
                    @if(isset($atividades) && $atividades->count() > 0)
                        @foreach ($atividades as $atividade)
                            <div class="card mb-3">
                                <div class="card-body">
                                    <h5 class="card-title">{{ $atividade->titulo }}</h5>
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

            @else
                <p>{{ __('Você precisa estar autenticado para acessar esta página.') }}</p>
            @endauth
        </div>
    </div>
</div>
@endsection
