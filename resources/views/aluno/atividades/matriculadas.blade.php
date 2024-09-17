@extends('layouts.app')

@section('title', 'Minhas Atividades Matriculadas')

@section('content')
<div class="container mt-5">
    <div class="card card-custom">
        <div class="card-body">
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
                            <th>{{ __('Data de Início') }}</th>
                            <th>{{ __('Próxima Ocorrência') }}</th>
                            <th>{{ __('Dia da Semana') }}</th>
                            <th>{{ __('Hora') }}</th>
                            <th>{{ __('Instrutor') }}</th>
                            <th>{{ __('Local') }}</th>
                            <th>{{ __('Ações') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($atividadesMatriculadas as $atividade)
                        <tr>
                            <td>{{ $atividade->atividade }}</td>
                            <td>{{ \Carbon\Carbon::parse($atividade->data_inicio)->format('d/m/Y') }}</td>
                            <td>{{ \Carbon\Carbon::parse($atividade->data_ocorrencia)->format('d/m/Y') }}</td>
                            <td>{{ ucfirst(\Carbon\Carbon::parse($atividade->data_ocorrencia)->locale('pt_BR')->isoFormat('dddd')) }}</td>
                            <td>{{ \Carbon\Carbon::parse($atividade->hora)->format('H:i') }}</td>
                            <td>{{ $atividade->instrutor['nome'] }}</td>
                            <td>{{ $atividade->local }}</td>
                            <td>
                                <form action="{{ route('aluno.atividades.desmatricular', $atividade->id) }}" method="POST" onsubmit="return confirm('Tem certeza que deseja se desmatricular desta atividade?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger">{{ __('Desmatricular') }}</button>
                                </form>
                            </td>
                        </tr>
                        @empty
                            <tr>
                                <td colspan="8">{{ __('Você não está matriculado em nenhuma atividade.') }}</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if($atividadesMatriculadas instanceof \Illuminate\Pagination\LengthAwarePaginator)
                {{ $atividadesMatriculadas->links() }}
            @endif
        </div>
    </div>
</div>
@endsection
