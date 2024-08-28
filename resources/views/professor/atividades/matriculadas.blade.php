@extends('layouts.app')

@section('content')
<div class="container">
<div class="row justify-content-center">
     <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
            <h2>{{ __('Minhas Atividades Matriculadas') }}</h2>


            @if($atividades->isNotEmpty())
                <div class="table-responsive mt-4">
                    <table class="table table-striped table-sm">
                        <thead>
                            <tr>
                                <th>{{ __('Atividade') }}</th>
                                <th>{{ __('Data') }}</th>
                                <th>{{ __('Hora') }}</th>
                                <th>{{ __('Local') }}</th>
                                <th>{{ __('Alunos Matriculados') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($atividades as $atividade)
                                <tr>
                                    <td>{{ $atividade->nome }}</td>
                                    <td>{{ \Carbon\Carbon::parse($atividade->data)->format('d/m/Y') }}</td>
                                    <td>{{ $atividade->hora }}</td>
                                    <td>{{ $atividade->local }}</td>
                                    <td>
                                        <ul>
                                            @foreach($atividade->alunos as $aluno)
                                                <li>{{ $aluno->nome }}</li>
                                            @endforeach

                                            


                                        </ul>
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
