<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserUpdateRequest extends FormRequest
{
    public function authorize()
    {
        return true; // Modifique se necessário para validar a autorização
    }

    public function rules()
    {
        $userId = $this->route('id'); // Obtém o ID do usuário da rota

        return [
            'nome' => 'required|string|max:255',
            'sobrenome' => 'required|string|max:255',
            'login' => 'required|string|max:255|unique:usuarios,login,' . $userId,
            'email' => 'required|string|email|max:255|unique:usuarios,email,' . $userId,
            'senha' => 'nullable|string|min:8|confirmed',
            'data_nascimento' => 'required|date',
            'telefone' => 'required|string|max:15',
            'tipo_id' => 'required|integer|exists:tipos,id'
        ];
    }
}
