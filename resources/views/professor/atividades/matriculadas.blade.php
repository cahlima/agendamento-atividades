@extends('layouts.app')

@section('content')
<div class="container">
<div class="row justify-content-center">
     <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
            <h2>{{ __('Minhas Atividades Matriculadas') }}</h2>

            @if($atividades->isNotEmpty())
                <div class="table-responsive mt-4">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>Atividade</th>
                                <th>Data Início - Fim</th>
                                <th>Hora</th>
                                <th>Dias da Semana</th>
                                <th>Local</th>
                                <th>Alunos Matriculados</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($atividades as $atividade)
                                <tr>
                                    <td>{{ $atividade->atividade }}</td>
                                    <td>{{ \Carbon\Carbon::parse($atividade->data_inicio)->format('d/m/Y') }} - {{ \Carbon\Carbon::parse($atividade->data_fim)->format('d/m/Y') }}</td>
                                    <td>{{ $atividade->hora }}</td>
                                    <td>{{ $atividade->dias }}</td>
                                    <td>{{ $atividade->local }}</td>
                                    <td>
                                        @if($atividade->alunos->isNotEmpty())
                                            <ul>
                                                @foreach($atividade->alunos as $aluno)
                                                    <li>{{ $aluno->nome }}</li>
                                                @endforeach
                                            </ul>
                                        @else
                                            <p>Nenhum aluno matriculado.</p>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                {{ $atividades->links() }}
            @else
                <p>{{ __('Você não está alocado em nenhuma atividade.') }}</p>
            @endif
        </main>
    </div>
</div>
@endsection
