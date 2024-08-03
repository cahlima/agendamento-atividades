@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
<div class="container">
    <h2>{{ __('Atividades Cadastradas') }}</h2>
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
                    <td>{{ $atividade->data }}</td>
                    <td>{{ $atividade->hora }}</td>
                    <td>{{ $atividade->instrutor }}</td>
                    <td>{{ $atividade->local }}</td>
                    <td>
                    <a href="{{ route('atividades.editar', $atividade->id) }}" class="btn btn-sm btn-primary">{{ __('Editar') }}</a>
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
