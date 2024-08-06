@extends('layouts.app')

@section('title', 'Minhas Atividades Matriculadas')

@section('content')
<div class="container">
    <h2>{{ __('Minhas Atividades Matriculadas') }}</h2>

    @if(Session::has('success'))
        <div class="alert alert-success">
            {{ Session::get('success') }}
        </div>
    @endif

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
                @foreach($atividadesMatriculadas as $atividade)
                    <tr>
                        <td>{{ $atividade->atividade }}</td>
                        <td>{{ \Carbon\Carbon::parse($atividade->data)->format('d/m/Y') }}</td>
                        <td>{{ $atividade->hora }}</td>
                        <td>{{ $atividade->instrutor }}</td>
                        <td>{{ $atividade->local }}</td>
                        <td>
                            <form action="{{ route('aluno.atividades.desmatricular', $atividade->id) }}" method="POST">
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

    @if($atividadesMatriculadas->isNotEmpty())
        {{ $atividadesMatriculadas->links() }}
    @else
        <p>{{ __('Você não está matriculado em nenhuma atividade.') }}</p>
    @endif
</div>
@endsection
