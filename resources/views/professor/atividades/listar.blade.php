@extends('layouts.base')

@section('content')
<div class="container-fluid">
    <div class="row">
        <!-- Sidebar -->
        <nav id="sidebar" class="col-md-3 col-lg-2 d-md-block bg-light sidebar fixed">
            <div class="position-sticky">
                <ul class="nav flex-column">
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('professor.painel') }}">
                            {{ __('Voltar') }}
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('professor.atividades.listar') }}">
                            {{ __('Atividades Disponíveis') }}
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('professor.atividades.matriculadas') }}">
                            {{ __('Minhas Atividades') }}
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('professor.perfil.edit') }}">
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

            <form action="{{ route('professor.atividades.listar') }}" method="GET" class="mb-4">
                <div class="row">
                    <div class="col-md-4">
                        <label for="atividade_id">{{ __('Atividade') }}:</label>

                        <select name="atividade_id" id="atividade_id" class="form-control">
                            <option value="">{{ __('Selecione a atividade') }}</option>
                            @if(isset($atividadesDisponiveis))
                            @foreach($atividadesDisponiveis as $atividades)
                                <option value="{{ $atividade->id }}">{{ $atividades->$atividades }}</option>
                            @endforeach

                            @else
    <option value="">{{ __('Nenhuma atividade disponível') }}</option>
@endif
                        </select>
                    </div>
                    <div class="col-md-4 mt-4">
                        <button type="submit" class="btn btn-primary">{{ __('Pesquisar') }}</button>
                    </div>
                </div>
            </form>

      
                <p>{{ __('Nenhuma atividade encontrada com os critérios selecionados.') }}</p>
          
        </main>
    </div>
</div>
@endsection
