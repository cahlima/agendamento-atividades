<?php

namespace App\Policies;

use App\Models\Usuarios;
use Illuminate\Auth\Access\HandlesAuthorization;

class UsuarioPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any models.
     *
     * @param  \App\Models\Usuarios  $user
     * @return mixed
     */
    public function viewAny(Usuarios $user)
    {
        return $user->isAluno() || $user->isAdmin();
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\Models\Usuarios  $user
     * @param  \App\Models\Usuarios  $model
     * @return mixed
     */
    public function view(Usuarios $user, Usuarios $model)
    {
        return $user->isAluno() || $user->id === $model->id || $user->isAdmin();
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  \App\Models\Usuarios  $user
     * @return mixed
     */
    public function create(Usuarios $user)
    {
        return $user->isAdmin();
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\Models\Usuarios  $user
     * @param  \App\Models\Usuarios  $model
     * @return mixed
     */
    public function update(Usuarios $user, Usuarios $model)
    {
        return $user->isAdmin() || $user->id === $model->id;
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\Usuarios  $user
     * @param  \App\Models\Usuarios  $model
     * @return mixed
     */
    public function delete(Usuarios $user, Usuarios $model)
    {
        return $user->isAdmin();
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \App\Models\Usuarios  $user
     * @param  \App\Models\Usuarios  $model
     * @return mixed
     */
    public function restore(Usuarios $user, Usuarios $model)
    {
        return $user->isAdmin();
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \App\Models\Usuarios  $user
     * @param  \App\Models\Usuarios  $model
     * @return mixed
     */
    public function forceDelete(Usuarios $user, Usuarios $model)
    {
        return $user->isAdmin();
    }
}
