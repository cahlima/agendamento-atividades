<!-- resources/views/aluno/atividades/matriculadas.blade.php -->
@extends('layouts.base')

@section('main-content')
<h2>{{ __('Minhas Atividades') }}</h2>

@if(isset($atividades) && $atividades->count() > 0)
    <div class="table-responsive mt-4">
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
                        <form action="{{ route('aluno.atividades.desmatricular', $atividade->id) }}" method="POST" onsubmit="event.preventDefault(); showDesmatriculaModal('{{ $atividade->atividade }}', '{{ \Carbon\Carbon::parse($atividade->data)->format('d/m/Y') }}', '{{ $atividade->hora }}', this);">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger">{{ __('Desmatricular') }}</button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    {{ $atividades->links() }}
@else
    <p>{{ __('Você não está matriculado em nenhuma atividade.') }}</p>
@endif
@endsection
