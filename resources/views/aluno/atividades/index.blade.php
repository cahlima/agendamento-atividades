<!-- resources/views/aluno/atividades/index.blade.php -->
@extends('layouts.base')

@section('content')
<div class="table-responsive">
    <table class="table table-striped table-sm">
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
                <td>{{ $atividade->atividade }}</td>
                <td>{{ \Carbon\Carbon::parse($atividade->data)->format('d/m/Y') }}</td>
                <td>{{ $atividade->hora }}</td>
                <td>{{ $atividade->instrutor }}</td>
                <td>{{ $atividade->local }}</td>
                <td>
                    <form action="{{ route('aluno.atividades.matricular', $atividade->id) }}" method="POST" style="display:inline;">
                        @csrf
                        <button type="submit" class="btn btn-sm btn-success">{{ __('Matricular') }}</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
