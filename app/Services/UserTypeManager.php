<?php

namespace App\Services;

use App\Models\Usuarios;
use Illuminate\Support\Facades\Log;

class UserTypeManager
{
    public function assignType(Usuarios $usuario, $tipoId)
    {
        // Usando \Log::info corretamente com a primeira letra maiúscula
        Log::info('Atribuindo tipo ao usuário', ['usuario_id' => $usuario->id, 'tipo_id' => $tipoId]);

        $usuario->tipo_id = $tipoId;
        $usuario->save();

        Log::info('Tipo atribuído ao usuário', ['usuario_id' => $usuario->id, 'tipo_id_atual' => $usuario->tipo_id]);
    }

    public function updateType(Usuarios $usuario, $tipoId)
    {
        Log::info('Atualizando tipo de usuário', ['usuario_id' => $usuario->id, 'tipo_id_antigo' => $usuario->tipo_id, 'tipo_id_novo' => $tipoId]);

        $usuario->tipo_id = $tipoId;
        $usuario->save();

        Log::info('Tipo de usuário atualizado', ['usuario_id' => $usuario->id, 'tipo_id_atual' => $usuario->tipo_id]);
    }
}
