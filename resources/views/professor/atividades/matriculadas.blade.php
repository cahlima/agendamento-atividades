@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
            <div class="card shadow-sm border-0 mb-4">
                <div class="card-header bg-primary text-white text-center">
                    <h2>{{ __('Minhas Atividades Matriculadas') }}</h2>
                </div>
                <div class="card-body">
                    @if($atividades->isNotEmpty())
                        <div class="table-responsive mt-4">
                            <table class="table table-striped table-hover align-middle">
                                <thead class="table-light">
                                    <tr>
                                        <th>{{ __('Atividade') }}</th>
                                        <th>{{ __('Data Início - Fim') }}</th>
                                        <th>{{ __('Hora') }}</th>
                                        <th>{{ __('Dias da Semana') }}</th>
                                        <th>{{ __('Local') }}</th>
                                        <th>{{ __('Alunos Matriculados') }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($atividades as $atividade)
                                        <tr>
                                            <td>{{ $atividade->atividade }}</td>
                                            <td>{{ \Carbon\Carbon::parse($atividade->data_inicio)->format('d/m/Y') }} - {{ \Carbon\Carbon::parse($atividade->data_fim)->format('d/m/Y') }}</td>
                                            <td>{{ \Carbon\Carbon::parse($atividade->hora)->format('H:i') }}</td>
                                            <td>{{ ucfirst(str_replace(',', ', ', $atividade->dias)) }}</td>
                                            <td>{{ $atividade->local }}</td>
                                            <td>
                                                @if($atividade->alunos->isNotEmpty())
                                                    <ul class="list-unstyled mb-0">
                                                        @foreach($atividade->alunos as $aluno)
                                                            <li>{{ $aluno->nome }}</li>
                                                        @endforeach
                                                    </ul>
                                                @else
                                                    <p class="text-muted">{{ __('Nenhum aluno matriculado') }}</p>
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <div class="d-flex justify-content-center mt-4">
                            {{ $atividades->links() }}
                        </div>
                    @else
                        <div class="alert alert-info text-center mt-4">
                            {{ __('Você não está alocado em nenhuma atividade.') }}
                        </div>
                    @endif
                </div>
            </div>
        </main>
    </div>
</div>
@endsection
