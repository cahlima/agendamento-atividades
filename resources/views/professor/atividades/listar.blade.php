@extends('layouts.app')

@section('content')
<div class="container">
    <h2>{{ __('Minhas Atividades') }}</h2>

    @if(Session::has('success'))
        <div class="alert alert-success">
            {{ Session::get('success') }}
        </div>
    @endif

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
                    <td>{{ $atividade->professor->nome ?? 'N/A' }}</td>
                    <td>{{ $atividade->local }}</td>
                    <td>
                        <a href="{{ route('atividades.editar', $atividade->id) }}" class="btn btn-sm btn-primary">{{ __('Editar') }}</a>
                        <form method="POST" action="{{ route('atividades.deletar', $atividade->id) }}" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger">{{ __('Deletar') }}</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
    {{ $atividades->links() }}
</div>
@endsection
