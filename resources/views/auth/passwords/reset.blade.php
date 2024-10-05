@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
            <div class="card-header">{{ __('Redefinir Senha') }}</div>

            <div class="card-body">
                <form method="POST" action="{{ route('password.update') }}">
                    @csrf

                    <input type="hidden" name="token" value="{{ $token ?? '' }}">
                    <input type="hidden" name="email" value="{{ $email ?? '' }}">

                  <!-- Campo Senha -->
<div class="form-group row">
    <label for="password" class="col-md-4 col-form-label text-md-right">{{ __('Senha') }}</label>

    <div class="col-md-6">
        <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">

        @error('password')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
    </div>
</div>

<!-- Campo Confirmar Senha -->
<div class="form-group row">
    <label for="password_confirmation" class="col-md-4 col-form-label text-md-right">{{ __('Confirmar Senha') }}</label>

    <div class="col-md-6">
        <input id="password_confirmation" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password">
    </div>
</div>


                    <!-- Botão de Submissão -->
                    <div class="form-group row mb-0">
                        <div class="col-md-8 offset-md-4">
                            <button type="submit" class="btn btn-primary">
                                {{ __('Redefinir Senha') }}
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </main>
    </div>
</div>
@endsection
