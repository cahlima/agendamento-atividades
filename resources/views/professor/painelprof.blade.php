@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Painel do Professor') }}</div>

                <div class="card-body">
                    @if(session('success'))
                        <div class="alert alert-success">
                            {{ session('success') }}
                        </div>
                    @endif

                    <h3>Bem-vindo, {{ auth()->user()->nome }}!</h3>

                    <p>Aqui você pode ver suas informações e acessar as funcionalidades disponíveis para os professores.</p>

                    <div class="list-group mb-4">
                        <a href="{{ route('professor.atividades.listarProfessor') }}" class="list-group-item list-group-item-action">Ver todas as Atividades</a>
                        <a href="{{ route('professor.atividades.matriculadas') }}" class="list-group-item list-group-item-action">Ver minhas Atividades</a>
                        <a href="{{ route('professor.perfil.edit') }}" class="list-group-item list-group-item-action">Editar perfil</a>
                    </div>

                    <div>
                        <h4>Minhas Atividades</h4>
                        @if($minhasAtividades->isNotEmpty())
                            <ul class="list-group">
                                @foreach($minhasAtividades as $atividade)
                                    <li class="list-group-item">
                                        <strong>{{ $atividade->atividade }}</strong> <br>
                                        Data: {{ \Carbon\Carbon::parse($atividade->data_inicio)->format('d/m/Y') }} - {{ \Carbon\Carbon::parse($atividade->data_fim)->format('d/m/Y') }} <br>
                                        Hora: {{ $atividade->hora }} <br>
                                        Local: {{ $atividade->local }} <br>
                                        Dias da Semana: {{ implode(', ', explode(',', $atividade->dias)) }} <br>
                                    </li>
                                @endforeach
                            </ul>

                            {{ $minhasAtividades->links() }}
                        @else
                            <p>Você ainda não está alocado em nenhuma atividade.</p>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
