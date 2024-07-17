<!-- resources/views/usuarios/editar.blade.php -->
@extends('layouts.base')

@section('content')
<h1>Editar Usuário - {{ $usuario->nome }}</h1>

<form action="{{ route('usuarios.update', ['id' => $usuario->id]) }}" method="POST">
    @csrf
    @method('POST') <!-- Usando POST para atualizar, conforme definido na rota -->

    <div class="mb-3">
        <label for="nome" class="form-label">Nome:</label>
        <input type="text" class="form-control" id="nome" name="nome" value="{{ $usuario->nome }}" required>
    </div>
    
    <div class="mb-3">
        <label for="email" class="form-label">Email:</label>
        <input type="email" class="form-control" id="email" name="email" value="{{ $usuario->email }}" required>
    </div><!-- resources/views/usuarios/editar.blade.php -->
@extends('layouts.base')

@section('content')
<h1>Editar Usuário - {{ $usuario->nome }}</h1>

<form action="{{ route('usuarios.update', ['id' => $usuario->id]) }}" method="POST">
    @csrf
    @method('POST') <!-- Usando POST para atualizar, conforme definido na rota -->

    <div class="mb-3">
        <label for="nome" class="form-label">Nome:</label>
        <input type="text" class="form-control" id="nome" name="nome" value="{{ $usuario->nome }}" required>
    </div>
    
    <div class="mb-3">
        <label for="sobrenome" class="form-label">Sobrenome:</label>
        <input type="text" class="form-control" id="sobrenome" name="sobrenome" value="{{ $usuario->sobrenome }}" required>
    </div>

    <div class="mb-3">
        <label for="login" class="form-label">Login:</label>
        <input type="text" class="form-control" id="login" name="login" value="{{ $usuario->login }}" required>
    </div>

    <div class="mb-3">
        <label for="email" class="form-label">Email:</label>
        <input type="email" class="form-control" id="email" name="email" value="{{ $usuario->email }}" required>
    </div>
    
    <div class="mb-3">
        <label for="senha" class="form-label">Senha:</label>
        <input type="password" class="form-control" id="senha" name="senha">
        <small class="form-text text-muted">Deixe em branco para manter a senha atual.</small>
    </div>

    <div class="mb-3">
        <label for="password_confirmation" class="form-label">Confirmar Senha:</label>
        <input type="password" class="form-control" id="password_confirmation" name="password_confirmation">
    </div>
    
    <div class="mb-3">
        <label for="data_nascimento" class="form-label">Data de Nascimento:</label>
        <input type="date" class="form-control" id="data_nascimento" name="data_nascimento" value="{{ $usuario->data_nascimento }}" required>
    </div>

    <div class="mb-3">
        <label for="telefone" class="form-label">Telefone:</label>
        <input type="text" class="form-control" id="telefone" name="telefone" value="{{ $usuario->telefone }}" required>
    </div>
    
    <div class="mb-3">
        <label for="tipo_id" class="form-label">Tipo:</label>
        <select class="form-control" id="tipo_id" name="tipo_id" required>
            @foreach($tipos as $tipo)
                <option value="{{ $tipo->id }}" {{ $usuario->tipo_id == $tipo->id ? 'selected' : '' }}>{{ $tipo->nome }}</option>
            @endforeach
        </select>
    </div>

    <button type="submit" class="btn btn-primary">Atualizar</button>
</form>
@endsection

    
    <div class="mb-3">
        <label for="senha" class="form-label">Senha:</label>
        <input type="password" class="form-control" id="senha" name="senha">
        <small class="form-text text-muted">Deixe em branco para manter a senha atual.</small>
    </div>

    <div class="mb-3">
        <label for="password_confirmation" class="form-label">Confirmar Senha:</label>
        <input type="password" class="form-control" id="password_confirmation" name="password_confirmation">
    </div>
    
    <div class="mb-3">
        <label for="tipo_id" class="form-label">Tipo:</label>
        <select class="form-control" id="tipo_id" name="tipo_id" required>
            @foreach($tipos as $tipo)
                <option value="{{ $tipo->id }}" {{ $usuario->tipo_id == $tipo->id ? 'selected' : '' }}>{{ $tipo->nome }}</option>
            @endforeach
        </select>
    </div>

    <button type="submit" class="btn btn-primary">Atualizar</button>
</form>
@endsection
