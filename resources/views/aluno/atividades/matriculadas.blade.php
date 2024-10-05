@extends('layouts.app')

@section('title', 'Minhas Atividades Matriculadas')

@section('content')
<div class="container mt-5">
    <div class="card shadow-sm border-0">
        <div class="card-header bg-primary text-white text-center">
            <h2>{{ __('Minhas Atividades Matriculadas') }}</h2>
        </div>

        <div class="card-body">
            @if(Session::has('success'))
                <div class="alert alert-success">
                    {{ Session::get('success') }}
                </div>
            @endif

            <!-- Tabela de Atividades Matriculadas -->
            <div class="table-responsive mt-4">
                <table class="table table-hover table-striped align-middle text-center">
                    <thead class="table-light">
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
                            <td><strong>{{ $atividade->atividade }}</strong></td>
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
                                <td colspan="8" class="text-center text-muted">{{ __('Você não está matriculado em nenhuma atividade.') }}</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Paginação -->
            @if($atividadesMatriculadas instanceof \Illuminate\Pagination\LengthAwarePaginator)
                <div class="d-flex justify-content-center mt-3">
                    {{ $atividadesMatriculadas->links() }}
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
