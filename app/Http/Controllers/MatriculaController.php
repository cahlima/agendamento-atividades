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
                Log::info('Usuário já matriculado na atividade', ['user_id' => $usuario->id, 'atividade_id' => $id]);
                return redirect()->route('aluno.atividades.listar')->with('error', 'Você já está matriculado nesta atividade.');
            }

            // Matricula o usuário na atividade
            $usuario->atividades()->attach($atividade->id);

            DB::commit();
            Log::info('Usuário matriculado com sucesso', ['user_id' => $usuario->id, 'atividade_id' => $id]);
            return redirect()->route('aluno.atividades.listar')->with('success', 'Matriculado com sucesso.');
        } catch (\Exception $e) {
            DB::rollback();
            Log::error('Erro ao matricular usuário', ['error' => $e->getMessage(), 'user_id' => $usuario->id, 'atividade_id' => $id]);
            return redirect()->route('aluno.atividades.listar')->with('error', 'Erro ao matricular: ' . $e->getMessage());
        }
    }

    public function desmatricular($id)
    {
        $usuario = Auth::guard('web')->user();

        DB::beginTransaction();

        try {
            $atividade = Atividades::findOrFail($id);

            // Verifica se o usuário está matriculado na atividade antes de desmatricular
            if (!$usuario->atividades()->where('atividades.id', $id)->exists()) {
                Log::info('Usuário não está matriculado na atividade', ['user_id' => $usuario->id, 'atividade_id' => $id]);
                return redirect()->route('aluno.atividades.matriculadas')->with('error', 'Você não está matriculado nesta atividade.');
            }

            // Desmatricula o usuário da atividade
            $usuario->atividades()->detach($atividade->id);

            DB::commit();
            Log::info('Usuário desmatriculado com sucesso', ['user_id' => $usuario->id, 'atividade_id' => $id]);
            return redirect()->route('aluno.atividades.matriculadas')->with('success', 'Desmatriculado com sucesso.');
        } catch (\Exception $e) {
            DB::rollback();
            Log::error('Erro ao desmatricular usuário', ['error' => $e->getMessage(), 'user_id' => $usuario->id, 'atividade_id' => $id]);
            return redirect()->route('aluno.atividades.matriculadas')->with('error', 'Erro ao desmatricular: ' . $e->getMessage());
        }
    }

    public function matriculageral()
    {
        // Lógica do método para exibir as matrículas gerais
        $matriculas = Atividades::all(); // Supondo que "Atividades" representa as matrículas gerais
        return view('matriculas.geral', compact('matriculas'));
    }
}
