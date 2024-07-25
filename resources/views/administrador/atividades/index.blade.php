@extends('layouts.app')

@section('content')
<div class="container">
    <h2>{{ __('Gerenciador de Atividades') }}</h2>

    @if(Session::has('success'))
        <div class="alert alert-success">
            {{ Session::get('success') }}
        </div>
    @endif

    <div class="mb-3">
        <a href="{{ route('atividades.create') }}" class="btn btn-success">{{ __('Adicionar Atividade') }}</a>
    </div>

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
                    <td>{{ $atividade->atividade }}</td>
                    <td>{{ \Carbon\Carbon::parse($atividade->data)->format('d/m/Y') }}</td>
                    <td>{{ $atividade->hora }}</td>
                    <td>{{ $atividade->instrutor ?? 'N/A' }}</td>
                    <td>{{ $atividade->local }}</td>
                    <td>
                        <a href="{{ route('atividades.edit', $atividade->id) }}" class="btn btn-sm btn-primary">{{ __('Editar') }}</a>
                        <form action="{{ route('atividades.destroy', $atividade->id) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger">{{ __('Deletar') }}</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
