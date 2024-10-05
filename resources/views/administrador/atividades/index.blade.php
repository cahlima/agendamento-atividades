@extends('layouts.app')

@section('title', 'Gerenciador de Atividades')

@section('content')
<div class="container mt-5">
    <div class="card card-custom shadow-sm" style="max-width: 1200px; margin: auto;">
        <div class="card-header bg-primary text-white">
            <h2 class="text-center mb-0">{{ __('Gerenciador de Atividades') }}</h2>
        </div>
        <div class="card-body">
            <!-- Mensagem de erro -->
            @if($errors->any())
                <div class="alert alert-danger">
                    <ul class="mb-0">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <!-- Formulário de busca com dropdowns -->
<form method="GET" action="{{ route('admin.atividades.index') }}" class="mb-4">
    <div class="row">
        <!-- Dropdown para selecionar uma atividade específica -->
        <div class="col-md-4 mb-3">
            <select name="busca" class="form-control">
                <option value="">{{ __('Selecione uma atividade') }}</option>
                @foreach($todasAtividades as $atividade)
                    <option value="{{ $atividade->atividade }}" {{ request('busca') == $atividade->atividade ? 'selected' : '' }}>
                        {{ $atividade->atividade }}
                    </option>
                @endforeach
            </select>
        </div>

        <!-- Dropdown para selecionar instrutor -->
        <div class="col-md-4 mb-3">
            <select name="instrutor" class="form-control">
                <option value="">{{ __('Selecione um instrutor') }}</option>
                @foreach($instrutores as $instrutor)
                    <option value="{{ $instrutor->nome }}" {{ request('instrutor') == $instrutor->nome ? 'selected' : '' }}>
                        {{ $instrutor->nome }}
                    </option>
                @endforeach
            </select>
        </div>

        <!-- Campo de busca por local -->
        <div class="col-md-4 mb-3">
            <input type="text" name="local" class="form-control" placeholder="Buscar por local..." value="{{ request('local') }}">
        </div>
    </div>

    <div class="d-flex justify-content-end">
        <button class="btn btn-primary mr-3" type="submit">
            <i class="fas fa-search"></i> {{ __('Buscar') }}
        </button>
        @if(request('busca') || request('instrutor') || request('local'))
            <a href="{{ route('admin.atividades.index') }}" class="btn btn-secondary">{{ __('Limpar') }}</a>
        @endif
    </div>
</form>


            <!-- Mensagem de sucesso -->
            @if(Session::has('flash_message'))
                <div class="alert alert-success">{{ Session::get('flash_message') }}</div>
            @endif

            <!-- Botão Adicionar Atividade -->
            <div class="d-flex justify-content-end mb-3">
                <a href="{{ route('admin.atividades.create') }}" class="btn btn-success">{{ __('Adicionar Atividade') }}</a>
            </div>

            <!-- Tabela de Atividades -->
            <div class="table-responsive">
                <table class="table table-bordered table-striped">
                    <thead class="thead-light">
                        <tr>
                            <th>{{ __('Atividade') }}</th>
                            <th>{{ __('Data de Início') }}</th>
                            <th>{{ __('Data de Fim') }}</th>
                            <th>{{ __('Hora') }}</th>
                            <th>{{ __('Dias da Semana') }}</th>
                            <th>{{ __('Instrutor') }}</th>
                            <th>{{ __('Local') }}</th>
                            <th>{{ __('Ações') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                    @forelse($atividades as $atividade)
    <tr>
        <td>{{ $atividade->atividade }}</td>
        <td>{{ \Carbon\Carbon::parse($atividade->data_inicio)->format('d/m/Y') }}</td>
        <td>{{ \Carbon\Carbon::parse($atividade->data_fim)->format('d/m/Y') }}</td>

        <td>
            @php
                $horarios = explode(',', $atividade->hora); // Divide os horários em um array
                $horariosFormatados = array_map(function($hora) {
                    try {
                        return \Carbon\Carbon::createFromFormat('H:i', trim($hora))->format('H:i');
                    } catch (\Exception $e) {
                        // Retorna o valor original se o Carbon não puder formatá-lo
                        return trim($hora);
                    }
                }, $horarios);
                echo implode(', ', $horariosFormatados); // Exibe os horários formatados
            @endphp
        </td>

        <td>
            @php
                $diasSemana = explode(',', $atividade->dias);
                $diasSemanaFormatados = array_map(fn($dia) => ucfirst(trim($dia)), $diasSemana);
                echo implode(', ', $diasSemanaFormatados);
            @endphp
        </td>

        <td>{{ $atividade->instrutor->nome ?? 'N/A' }}</td>
        <td>{{ $atividade->local }}</td>

        <td>
            <div class="d-flex">
                <a href="{{ route('admin.atividades.edit', $atividade->id) }}" class="btn btn-sm btn-primary mr-2">{{ __('Editar') }}</a>
                <form action="{{ route('admin.atividades.destroy', $atividade->id) }}" method="POST" onsubmit="return confirm('{{ __('Tem certeza que deseja excluir esta atividade?') }}');">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-sm btn-danger">{{ __('Deletar') }}</button>
                </form>
            </div>
        </td>
    </tr>
@empty
    <tr>
        <td colspan="8" class="text-center">{{ __('Nenhuma atividade encontrada') }}</td>
    </tr>
@endforelse


                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
