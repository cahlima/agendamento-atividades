@extends('layouts.app')

@section('title', 'Editar Atividade')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Editar Atividade') }}</div>

                <div class="card-body">

                    <!-- Alertas de sucesso ou erro -->
                    @if(Session::has('success'))
                        <div class="alert alert-success">
                            {{ Session::get('success') }}
                        </div>
                    @endif

                    @if(Session::has('error'))
                        <div class="alert alert-danger">
                            {{ Session::get('error') }}
                        </div>
                    @endif

                    <!-- Formulário com alerta de confirmação -->
                    <form method="POST" action="{{ route('admin.atividades.update', $atividade->id) }}" onsubmit="return confirm('Você tem certeza que deseja salvar as alterações?');">
                        @csrf
                        @method('PUT')

                        <!-- Campos do formulário -->
                        <div class="form-group">
                            <label for="atividade">Atividade</label>
                            <input type="text" class="form-control @error('atividade') is-invalid @enderror" id="atividade" name="atividade" value="{{ $atividade->atividade }}" required>
                            @error('atividade')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label for="data_inicio">Data de Início</label>
                                <input type="date" class="form-control @error('data_inicio') is-invalid @enderror" id="data_inicio" name="data_inicio" value="{{ $atividade->data_inicio }}" required>
                                @error('data_inicio')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="form-group col-md-6">
                                <label for="data_fim">Data de Fim</label>
                                <input type="date" class="form-control @error('data_fim') is-invalid @enderror" id="data_fim" name="data_fim" value="{{ $atividade->data_fim }}" required>
                                @error('data_fim')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="hora">Hora</label>
                            <input type="time" class="form-control @error('hora') is-invalid @enderror" id="hora" name="hora" value="{{ \Carbon\Carbon::parse($atividade->hora)->format('H:i') }}" required>
                            @error('hora')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="instrutor">Instrutor</label>
                            <select class="form-control @error('instrutor_id') is-invalid @enderror" id="instrutor" name="instrutor_id" required>
                                <option value="">Selecione o instrutor</option>
                                @foreach($instrutores as $instrutor)
                                    <option value="{{ $instrutor->id }}" {{ $instrutor->id == $atividade->instrutor_id ? 'selected' : '' }}>{{ $instrutor->nome }}</option>
                                @endforeach
                            </select>
                            @error('instrutor_id')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="local">Local</label>
                            <input type="text" class="form-control @error('local') is-invalid @enderror" id="local" name="local" value="{{ $atividade->local }}" required>
                            @error('local')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="dias">Dias da Semana</label>
                            <select id="dias" class="form-control @error('dias') is-invalid @enderror" name="dias[]" multiple required>
                                @php
                                    $dias_semana = ['domingo', 'segunda', 'terca', 'quarta', 'quinta', 'sexta', 'sabado'];
                                    $dias_selecionados = explode(',', $atividade->dias);
                                @endphp
                                @foreach($dias_semana as $dia)
                                    <option value="{{ $dia }}" {{ in_array($dia, $dias_selecionados) ? 'selected' : '' }}>
                                        {{ ucfirst($dia) }}
                                    </option>
                                @endforeach
                            </select>
                            @error('dias')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <button type="submit" class="btn btn-primary">
                            {{ __('Salvar') }}
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
