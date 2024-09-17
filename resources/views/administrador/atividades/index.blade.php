@extends('layouts.app')

@section('title', 'Gerenciador de Atividades')

@section('content')
<div class="container mt-10 d-flex justify-content-center">
    <div class="card card-custom" style="width: 100%; max-width: 1500px;">
        <div class="card-body">


            <h2 class="text-center">{{ __('Gerenciador de Atividades') }}</h2>
        </div>
        <div class="card-body">
            @if($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif






         <!-- Formulário de busca -->
<form method="GET" action="{{ route('admin.atividades.index') }}" class="mb-7">
    <div class="input-group">
        <input type="text" name="busca" class="form-control" placeholder="{{ request('busca') ? request('busca') : 'Buscar atividade...' }}" value="{{ request('busca') }}">
        <div class="input-group-append">
            <button class="btn btn-primary" type="submit">
                <i class="fas fa-search"></i> {{ __('Buscar') }}
            </button>
            @if(request('busca'))
                <a href="{{ route('admin.atividades.index') }}" class="btn btn-secondary">{{ __('Limpar') }}</a>
            @endif
        </div>
    </div>
</form>
<div class="card-body">
    @if(Session::has('flash_message'))
        <div class="alert alert-success">{{ Session::get('flash_message') }}</div>
    @endif
</div>

            <a href="{{ route('admin.atividades.create') }}" class="btn btn-success mb-4">{{ __('Adicionar Atividade') }}</a>

           <div class="table-responsive">
            <table class="table" style="width: 100%; min-width: 1000px;">
    <table class="table">
        <thead>
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
            @foreach($atividades as $atividade)
                <tr>
                    <td>{{ $atividade->atividade }}</td>
                    <td>{{ \Carbon\Carbon::parse($atividade->data_inicio)->format('d/m/Y') }}</td>
                    <td>{{ \Carbon\Carbon::parse($atividade->data_fim)->format('d/m/Y') }}</td>
                    <td>{{ \Carbon\Carbon::parse($atividade->hora)->format('H:i') }}</td>
                    <td>
                        @php

                    // Transformando apenas a primeira letra dos dias da semana para maiúscula
                    $diasSemana = explode(',', $atividade->dias);
                    $diasSemanaFormatados = array_map(function($dia) {
                        return ucfirst(trim($dia)); // Apenas a primeira letra em maiúscula
                    }, $diasSemana);
                    echo implode(', ', $diasSemanaFormatados);
                @endphp

                    </td>
                    <td>{{ $atividade->instrutor->nome ?? 'N/A' }}</td>
                    <td>{{ $atividade->local }}</td>
                   
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
