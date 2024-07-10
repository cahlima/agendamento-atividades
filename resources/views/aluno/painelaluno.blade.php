@extends('layouts.base')

@section('main-content')
<div class="container-fluid">
    <div class="row">
        <!-- Sidebar -->
        <nav id="sidebar" class="col-md-3 col-lg-2 d-md-block bg-light sidebar fixed">
            <div class="position-sticky">
                <ul class="nav flex-column">
                    <!-- Outros itens de navegação -->
                </ul>
            </div>
        </nav>

        <!-- Main content -->
        <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
            <h2>{{ __('Painel do Aluno') }}</h2>
            <h3>{{ __('Bem-vindo, ') . $usuario->nome }}</h3>
            <p>{{ __('Aqui você pode ver suas informações e acessar as funcionalidades disponíveis para os alunos.') }}</p>

            <div class="list-group mb-4">
                <!-- Links para outras páginas -->
            </div>

            <div>
            <h4>{{ __('Minhas Atividades Matriculadas') }}</h4>
@if(isset($atividades) && $atividades->isNotEmpty())
    <ul class="list-group">
        @foreach($atividades as $atividade)
            <li class="list-group-item">
                {{ $atividade->atividade }} -
                @if($atividade->data instanceof \DateTime)
                    {{ $atividade->data->format('d/m/Y') }} às {{ $atividade->hora }}
                @else
                    {{ $atividade->data }} às {{ $atividade->hora }} <!-- ou outra abordagem para mostrar a data -->
                @endif
                <br>Instrutor:
                @if(is_object($atividade->instrutor) && property_exists($atividade->instrutor, 'nome'))
                    {{ $atividade->instrutor->nome }}
                @else
                    Nome do instrutor não disponível <!-- ou outra mensagem de fallback -->
                @endif
                <br>Local: {{ $atividade->local }}
            </li>
        @endforeach

                    </ul>
                @else
                    <p>{{ __('Você ainda não está matriculado em nenhuma atividade.') }}</p>
                @endif
            </div>
        </main>
    </div>
</div>
@endsection
