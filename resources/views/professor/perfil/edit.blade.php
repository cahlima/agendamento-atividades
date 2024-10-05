@extends('layouts.app')

@section('title', 'Editar Perfil')

@section('content')
<div class="container mt-5">
    <div class="card shadow-sm border-0">
        <div class="card-header bg-primary text-white text-center">
            <h1 class="h4">{{ __('Editar Perfil') }}</h1>
        </div>
        <div class="card-body">
            @if(Session::has('flash_message'))
                <div class="alert {{ Session::get('flash_message.class') }} text-center">
                    {{ Session::get('flash_message.msg') }}
                </div>
            @endif

            <form action="{{ route('professor.perfil.update') }}" method="POST" onsubmit="return confirm('Você tem certeza que deseja salvar as alterações no perfil?');">
                @csrf
                @method('PUT')

                <!-- Nome -->
                <div class="form-group mb-4">
                    <label for="nome" class="font-weight-bold">{{ __('Nome') }}</label>
                    <div class="input-group">
                        <input type="text" class="form-control" id="nome" name="nome" value="{{ $usuario->nome }}" readonly style="background-color: #e9ecef;">
                        <button class="btn btn-outline-primary" type="button" onclick="toggleEditing('nome')">Editar</button>
                    </div>
                </div>

                <!-- Email -->
                <div class="form-group mb-4">
                    <label for="email" class="font-weight-bold">{{ __('Email') }}</label>
                    <div class="input-group">
                        <input type="email" class="form-control" id="email" name="email" value="{{ $usuario->email }}" readonly style="background-color: #e9ecef;">
                        <button class="btn btn-outline-primary" type="button" onclick="toggleEditing('email')">Editar</button>
                    </div>
                </div>

                <!-- Login -->
                <div class="form-group mb-4">
                    <label for="login" class="font-weight-bold">{{ __('Login') }}</label>
                    <input type="text" class="form-control" id="login" name="login" value="{{ $usuario->login }}">
                </div>

                <!-- Data de Nascimento -->
                <div class="form-group mb-4">
                    <label for="data_nascimento" class="font-weight-bold">{{ __('Data de Nascimento') }}</label>
                    <input type="date" class="form-control" id="data_nascimento" name="data_nascimento" value="{{ $usuario->data_nascimento }}">
                </div>

                <!-- Telefone -->
                <div class="form-group mb-4">
                    <label for="telefone" class="font-weight-bold">{{ __('Telefone') }}</label>
                    <input type="text" class="form-control" id="telefone" name="telefone" value="{{ $usuario->telefone }}">
                </div>

                <!-- Senha -->
                <div class="form-group mb-4">
                    <label for="password" class="font-weight-bold">{{ __('Senha') }}</label>
                    <div class="input-group">
                        <input type="password" class="form-control" id="password" name="password" placeholder="Deixe em branco se não quiser alterar a senha" readonly style="background-color: #e9ecef;">
                        <button class="btn btn-outline-primary" type="button" onclick="toggleEditing('password')">Editar</button>
                    </div>
                </div>

                <!-- Confirmar Senha -->
                <div class="form-group mb-4">
                    <label for="password_confirmation" class="font-weight-bold">{{ __('Confirmar Senha') }}</label>
                    <div class="input-group">
                        <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" placeholder="Deixe em branco se não quiser alterar a senha" readonly style="background-color: #e9ecef;">
                        <button class="btn btn-outline-primary" type="button" onclick="toggleEditing('password_confirmation')">Editar</button>
                    </div>
                </div>

                <div class="d-flex justify-content-center">
                    <button type="submit" class="btn btn-success mr-2">{{ __('Salvar') }}</button>
                    <a href="{{ route('professor.perfil.index') }}" class="btn btn-secondary">{{ __('Voltar') }}</a>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    function toggleEditing(fieldId) {
        const field = document.getElementById(fieldId);
        const button = field.nextElementSibling;

        if (field.hasAttribute('readonly')) {
            field.removeAttribute('readonly');
            field.style.backgroundColor = "#fff";
            button.textContent = "Bloquear";
        } else {
            field.setAttribute('readonly', true);
            field.style.backgroundColor = "#e9ecef";
            button.textContent = "Editar";
        }
    }
</script>
@endsection
