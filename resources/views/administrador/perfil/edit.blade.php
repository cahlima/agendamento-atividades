<!-- resources/views/perfil/edit.blade.php -->
@extends('layouts.base')

@section('content')
<div class="container mt-5">
    <div class="card">
        <div class="card-header">
            <h2>{{ __('Editar Perfil') }}</h2>
        </div>
        <div class="card-body">
            <form action="{{ route('admin.perfil.update') }}" method="POST" id="editProfileForm">
                @csrf
                <div class="mb-3">
                    <label for="tipo_id" class="form-label">{{ __('Tipo') }}</label>
                    <input type="text" class="form-control" id="tipo_id" name="tipo_id" value="{{ $usuario->tipo->descricao }}" disabled>
                </div>
                <div class="mb-3">
                    <label for="nome" class="form-label">{{ __('Nome') }}</label>
                    <input type="text" class="form-control" id="nome" name="nome" value="{{ old('nome', $usuario->nome) }}" required>
                </div>
                <div class="mb-3">
                    <label for="sobrenome" class="form-label">{{ __('Sobrenome') }}</label>
                    <input type="text" class="form-control" id="sobrenome" name="sobrenome" value="{{ old('sobrenome', $usuario->sobrenome) }}" required>
                </div>
                <div class="mb-3">
                    <label for="email" class="form-label">{{ __('Email') }}</label>
                    <input type="email" class="form-control" id="email" name="email" value="{{ old('email', $usuario->email) }}" required>
                </div>
                <div class="mb-3">
                    <label for="data_nascimento" class="form-label">{{ __('Data de Nascimento') }}</label>
                    <input type="date" class="form-control" id="data_nascimento" name="data_nascimento" value="{{ old('data_nascimento', $usuario->data_nascimento) }}" required>
                </div>
                <div class="mb-3">
                    <label for="telefone" class="form-label">{{ __('Telefone') }}</label>
                    <input type="text" class="form-control" id="telefone" name="telefone" value="{{ old('telefone', $usuario->telefone) }}" required>
                </div>
                <div class="mb-3">
                    <label for="login" class="form-label">{{ __('Login') }}</label>
                    <input type="text" class="form-control" id="login" name="login" value="{{ old('login', $usuario->login) }}" required>
                </div>
                <div class="mb-3">
                    <label for="senha" class="form-label">{{ __('Senha') }}</label>
                    <input type="password" class="form-control" id="senha" name="senha">
                </div>
                <div class="mb-3">
                    <label for="password_confirmation" class="form-label">{{ __('Confirmar Senha') }}</label>
                    <input type="password" class="form-control" id="password_confirmation" name="password_confirmation">
                </div>
                <button type="button" class="btn btn-primary" onclick="showEditProfileModal()">{{ __('Salvar') }}</button>
                <a href="{{ route('admin.perfil.edit') }}" class="btn btn-secondary">{{ __('Voltar') }}</a>
            </form>
        </div>
    </div>
</div>

<!-- Modal de confirmação -->
<div class="modal fade" id="editProfileModal" tabindex="-1" aria-labelledby="editProfileModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editProfileModalLabel">{{ __('Confirmar Alterações') }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                {{ __('Tem certeza de que deseja salvar as alterações?') }}
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{{ __('Cancelar') }}</button>
                <button type="button" class="btn btn-primary" onclick="submitEditProfileForm()">{{ __('Salvar') }}</button>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
function showEditProfileModal() {
    var modal = new bootstrap.Modal(document.getElementById('editProfileModal'));
    modal.show();
}

function submitEditProfileForm() {
    document.getElementById('editProfileForm').submit();
}
</script>
@endsection
