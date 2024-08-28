@extends('layouts.app')

@section('title', 'Gerenciador de Atividades')

@section('content')
<div class="container mt-5">
    <div class="card">
        <div class="card-header">
            <h2>{{ __('Gerenciador de Atividades') }}</h2>
        </div>

         <!-- Formulário de busca -->
    <form method="GET" action="{{ route('admin.atividades.index') }}" class="mb-4">
        <div class="input-group">
            <input type="text" name="busca" class="form-control" placeholder="Buscar atividade..." value="{{ request('busca') }}">
            <div class="input-group-append">
                <button class="btn btn-primary" type="submit">{{ __('Buscar') }}</button>
            </div>
        </div>
    </form>
        <div class="card-body">
            @if(Session::has('flash_message'))
                <div class="alert alert-success">{{ Session::get('flash_message') }}</div>
            @endif

            <a href="{{ route('admin.atividades.create') }}" class="btn btn-success mb-3">{{ __('Adicionar Atividade') }}</a>

            <div class="table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                            <th>{{ __('Atividade') }}</th>
                            <th>{{ __('Data de Início') }}</th>
                            <th>{{ __('Data de Fim') }}</th>
                            <th>{{ __('Hora') }}</th>
                            <th>{{ __('Instrutor') }}</th>
                            <th>{{ __('Local') }}</th>
                            <th>{{ __('Dias da Semana') }}</th>
                            <th>{{ __('Próximas Atividades') }}</th>
                            <th>{{ __('Ações') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($atividades as $atividade)
                            <tr>
                                <td>{{ $atividade->atividade }}</td>
                                <td>{{ \Carbon\Carbon::parse($atividade->data_inicio)->format('d/m/Y') }}</td>
                                <td>{{ \Carbon\Carbon::parse($atividade->data_fim)->format('d/m/Y') }}</td>
                                <td>{{ \Carbon\Carbon::parse($atividade->hora)->format('H:i') }}</td>
                                <td>{{ $atividade->instrutor->nome ?? 'N/A' }}</td>
                                <td>{{ $atividade->local }}</td>
                                <td>{{ $atividade->dias }}</td>
                                <td>
                                    @if(!empty($atividade->proximas_atividades) && is_array($atividade->proximas_atividades))
                                        <ul>
                                            @foreach($atividade->proximas_atividades as $data)
                                                <li>{{ \Carbon\Carbon::parse($data)->format('d/m/Y') }}</li>
                                            @endforeach
                                        </ul>
                                    @else
                                        {{ __('Nenhuma atividade programada') }}
                                    @endif
                                </td>
                                <td>
                                    <a href="{{ route('admin.atividades.edit', $atividade->id) }}" class="btn btn-primary">{{ __('Editar') }}</a>
                                    <form action="{{ route('admin.atividades.destroy', $atividade->id) }}" method="POST" style="display:inline-block;" onsubmit="return confirm('{{ __('Tem certeza que deseja excluir esta atividade?') }}');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger">{{ __('Deletar') }}</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
