@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Atividades Matriculadas') }}</div>

                <div class="card-body">
                    @if (session('success'))
                        <div class="alert alert-success" role="alert">
                            {{ session('success') }}
                        </div>
                    @endif

                    @if ($atividades->count())
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>{{ __('Nome') }}</th>
                                    <th>{{ __('Descrição') }}</th>
                                    <th>{{ __('Data de Início') }}</th>
                                    <th>{{ __('Data de Término') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($atividades as $atividade)
                                    <tr>
                                        <td>{{ $atividade->nome }}</td>
                                        <td>{{ $atividade->descricao }}</td>
                                        <td>{{ $atividade->data_inicio->format('d/m/Y') }}</td>
                                        <td>{{ $atividade->data_termino->format('d/m/Y') }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>

                        <div class="d-flex justify-content-center">
                            {{ $atividades->links() }}
                        </div>
                    @else
                        <p>{{ __('Você não está matriculado em nenhuma atividade.') }}</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
