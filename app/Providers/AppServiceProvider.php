<?php

namespace App\Providers;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\ServiceProvider;
use Laravel\Fortify\Contracts\ResetPasswordViewResponse;
use App\Actions\Fortify\ResetPasswordResponse;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        // Registra a implementação do contrato ResetPasswordViewResponse
        $this->app->singleton(ResetPasswordViewResponse::class, ResetPasswordResponse::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Forçar HTTPS se o ambiente não for local
        if (env('APP_ENV') !== 'local') {
            URL::forceScheme('https');
        }
    }
}
