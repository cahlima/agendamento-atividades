
@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Dashboard') }}</div>

                <div class="card-body">
                @dump(auth()->user())
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    {{ __('Você esta no painel Administrativo ') }}
                   @if (auth()->user()->unreadNotifications)
                        @foreach (auth()->user()->unreadNotifications as $notification)
                        <div class="alert alert-warning alert-dismissible fade show" role="alert">
                            <strong>Olá {{auth()->user()->nome}}</strong>,
                            {{$notification->data['mensagem']}}
                        </div>
                        @endforeach
@endif 

                </div>
            </div>
        </div>
    </div>
</div>
@endsection
