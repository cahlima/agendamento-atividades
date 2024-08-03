<?php

namespace App\Services;

use App\Models\Usuarios;

class UserTypeManager
{
    public function assignType(Usuarios $usuario, $tipoId)
    {
        $usuario->tipo_id = $tipoId;
        $usuario->save();
    }

    public function updateType(Usuarios $usuario, $tipoId)
    {
        $usuario->tipo_id = $tipoId;
        $usuario->save();
    }
}
