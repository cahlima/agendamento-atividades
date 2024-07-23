@extends('layouts.base')

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Atividades') }}</div>

                <div class="card-body">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>{{ __('Atividade') }}</th>
                                <th>{{ __('Data') }}</th>
                                <th>{{ __('Hora') }}</th>
                                <th>{{ __('Instrutor') }}</th>
                                <th>{{ __('Local') }}</th>
                                <th>{{ __('Ações') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($atividades as $atividade)
                                <tr>
                                    <td>{{ $atividade->titulo }}</td>
                                    <td>{{ \Carbon\Carbon::parse($atividade->data)->format('d/m/Y') }}</td>
                                    <td>{{ $atividade->hora }}</td>
                                    <td>{{ $atividade->professor->nome ?? 'N/A' }}</td> <!-- Verifica se o professor não é nulo -->
                                    <td>{{ $atividade->local }}</td>
                                    <td>
                                        <form action="{{ route('aluno.atividades.matricular', $atividade->id) }}" method="POST">
                                            @csrf
                                            <button type="submit" class="btn btn-sm btn-primary">{{ __('Matricular') }}</button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                {{ $atividades->links() }}

            </div>
        </div>
    </div>
</div>
@endsection
