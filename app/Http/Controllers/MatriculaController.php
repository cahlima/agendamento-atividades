<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Atividades;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;

class MatriculaController extends Controller
{
    public function matricular($id)
    {
        $usuario = Auth::guard('web')->user();

        DB::beginTransaction();

        try {
            $atividade = Atividades::findOrFail($id);

            // Verifica se o usuário já está matriculado na atividade
            if ($usuario->atividades()->where('atividades.id', $id)->exists()) {
                return redirect()->route('aluno.atividades.matriculadas')->with('error', 'Você já está matriculado nesta atividade.');
            }

            // Matricula o usuário na atividade
            $usuario->atividades()->attach($atividade);

            DB::commit();
            return redirect()->route('aluno.atividades.matriculadas')->with('success', 'Matriculado com sucesso.');
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->route('aluno.atividades.matriculadas')->with('error', 'Erro ao matricular: ' . $e->getMessage());
        }
    }
}
