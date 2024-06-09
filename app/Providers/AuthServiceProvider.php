<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;
use App\Models\Usuarios;
use App\Policies\UsuarioPolicy;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        Usuarios::class => UsuarioPolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        // Defining Gates
        Gate::define('isAdmin', function ($user) {
            return $user->tipo_id == 1; // Assuming tipo_id 1 is for Admin
        });

        Gate::define('isAluno', function ($user) {
            return $user->tipo_id == 3; // Assuming tipo_id 3 is for Aluno
        });

        Gate::define('isProfessor', function ($user) {
            return $user->tipo_id == 2; // Assuming tipo_id 2 is for Professor
        });

        // Other Gates can be defined here
    }
}
