@extends('layouts.app')

@section('title', 'Editar Perfil')

@section('content')
<div class="container mt-5">
    <div class="card">
        <div class="card-header">
            <h1 class="h2">{{ __('Editar Perfil') }}</h1>
        </div>
        <div class="card-body">
            @if(Session::has('flash_message'))
                <div class="alert {{ Session::get('flash_message.class') }}">
                    {{ Session::get('flash_message.msg') }}
                </div>
            @endif

            <form action="{{ route('professor.perfil.update') }}" method="POST" onsubmit="return confirm('Você tem certeza que deseja salvar as alterações no perfil?');">
                @csrf
                @method('PUT')

                <!-- Nome -->
                <div class="form-group mb-3">
                    <label for="nome">{{ __('Nome') }}</label>
                    <div class="input-group">
                        <input type="text" class="form-control" id="nome" name="nome" value="{{ $usuario->nome }}" readonly>
                        <button class="btn btn-outline-primary" type="button" onclick="toggleEditing('nome')">Editar</button>
                    </div>
                </div>

                <!-- Email -->
                <div class="form-group mb-3">
                    <label for="email">{{ __('Email') }}</label>
                    <div class="input-group">
                        <input type="email" class="form-control" id="email" name="email" value="{{ $usuario->email }}" readonly>
                        <button class="btn btn-outline-primary" type="button" onclick="toggleEditing('email')">Editar</button>
                    </div>
                </div>


                <!-- Login -->

                <div class="form-group">
                    <label for="login">{{ __('Login') }}</label>
                    <input type="text" class="form-control" id="login" name="login" value="{{ $usuario->login }}">
                </div>

                  <!-- Data NAscimento -->

                  <div class="form-group">
                    <label for="data_nascimento">{{ __('Data de Nascimento') }}</label>
                    <input type="date" class="form-control" id="data_nascimento" name="data_nascimento" value="{{ $usuario->data_nascimento }}">
                </div>

                   <!--Telefone-->
                   <div class="form-group">
                    <label for="telefone">{{ __('Telefone') }}</label>
                    <input type="text" class="form-control" id="telefone" name="telefone" value="{{ $usuario->telefone }}">
                </div>

                <!-- Senha -->
                <div class="form-group mb-3">
                    <label for="password">{{ __('Senha') }}</label>
                    <div class="input-group">
                        <input type="password" class="form-control" id="password" name="password" placeholder="Deixe em branco se não quiser alterar a senha" readonly>
                        <button class="btn btn-outline-primary" type="button" onclick="toggleEditing('password')">Editar</button>
                    </div>
                </div>

                <!-- Confirmar Senha -->
                <div class="form-group mb-3">
                    <label for="password_confirmation">{{ __('Confirmar Senha') }}</label>
                    <div class="input-group">
                        <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" placeholder="Deixe em branco se não quiser alterar a senha" readonly>
                        <button class="btn btn-outline-primary" type="button" onclick="toggleEditing('password_confirmation')">Editar</button>
                    </div>
                </div>

                <button type="submit" class="btn btn-success mt-3">{{ __('Salvar') }}</button>
                <a href="{{ route('professor.perfil.index') }}" class="btn btn-secondary mt-3">{{ __('Voltar') }}</a>
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
            field.focus();
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
