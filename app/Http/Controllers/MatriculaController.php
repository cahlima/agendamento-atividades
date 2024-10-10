<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Matricula;
use App\Models\Atividades;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class MatriculaController extends Controller
{
    // Método para matricular um usuário em uma atividade
    public function matricular($id)
{
    // Verifica se o usuário está autenticado
    $usuario = Auth::user();

    if (!$usuario) {
        return redirect()->route('login')->with('error', 'Você precisa estar logado para realizar uma matrícula.');
    }

    Log::info('Iniciando matrícula para usuário:', ['user_id' => $usuario->id, 'atividade_id' => $id]);

    DB::beginTransaction();

    try {
        $atividade = Atividades::findOrFail($id);
        Log::info('Atividade encontrada:', ['atividade_id' => $atividade->id]);

        // Verifica se o usuário já está matriculado nesta atividade
        if (Matricula::where('usuario_id', $usuario->id)->where('atividade_id', $id)->exists()) {
            Log::info('Usuário já está matriculado na atividade:', ['user_id' => $usuario->id, 'atividade_id' => $id]);
            return redirect()->route('aluno.atividades.matriculadas')->with('error', 'Você já está matriculado nesta atividade.');
        }

        Matricula::create([
            'usuario_id' => $usuario->id,
            'atividade_id' => $atividade->id,
            'status' => 'confirmado',
            'tipo_id' => $usuario->tipo_id,
        ]);

        Log::info('Matrícula criada com sucesso para usuário:', ['user_id' => $usuario->id, 'atividade_id' => $atividade->id]);

        DB::commit();
        return redirect()->route('aluno.atividades.matriculadas')->with('success', 'Matriculado com sucesso.');
    } catch (\Exception $e) {
        DB::rollback();
        Log::error('Erro ao matricular usuário:', ['error' => $e->getMessage(), 'user_id' => $usuario->id, 'atividade_id' => $id]);
        return redirect()->route('aluno.atividades.listarAluno')->with('error', 'Erro ao matricular: ' . $e->getMessage());
    }
}

    // Método para desmatricular um usuário de uma atividade
    public function desmatricular($id)
    {
        // Verifica se o usuário está autenticado
        $usuario = Auth::user();

        if (!$usuario) {
            return redirect()->route('login')->with('error', 'Você precisa estar logado para desmatricular-se.');
        }

        DB::beginTransaction();

        try {
            $matricula = Matricula::where('usuario_id', $usuario->id)
                                  ->where('atividade_id', $id)
                                  ->firstOrFail();

            // Desmatricula o usuário da atividade
            $matricula->delete();

            DB::commit();
            Log::info('Usuário desmatriculado com sucesso', ['user_id' => $usuario->id, 'atividade_id' => $id]);
            return redirect()->route('aluno.atividades.matriculadas')->with('success', 'Desmatriculado com sucesso.');
        } catch (\Exception $e) {
            DB::rollback();
            Log::error('Erro ao desmatricular usuário', ['error' => $e->getMessage(), 'user_id' => $usuario->id, 'atividade_id' => $id]);
            return redirect()->route('aluno.atividades.matriculadas')->with('error', 'Erro ao desmatricular: ' . $e->getMessage());
        }
    }

    // Método para listar todas as matrículas (admin)
    public function matriculageral()
    {
        $matriculas = Matricula::with(['usuario', 'atividade'])->get();
        return view('matriculas.geral', compact('matriculas'));
    }

    public function matriculaaluno()
{
    // Verifica se o usuário está autenticado
    $usuario = Auth::user();

    if (!$usuario) {
        return redirect()->route('login')->with('error', 'Você precisa estar logado para acessar suas matrículas.');
    }

    // Obtenha as atividades matriculadas do usuário e carregue as informações de dias e horários
    $atividadesMatriculadas = $usuario->atividades()->with(['instrutor'])->get();

    // Calcula a próxima ocorrência e formata os dias da semana corretamente
    $atividadesMatriculadas->map(function ($atividade) {
        $diasSemanaMap = [
            'domingo' => \Carbon\Carbon::SUNDAY,
            'segunda' => \Carbon\Carbon::MONDAY,
            'terca' => \Carbon\Carbon::TUESDAY,
            'quarta' => \Carbon\Carbon::WEDNESDAY,
            'quinta' => \Carbon\Carbon::THURSDAY,
            'sexta' => \Carbon\Carbon::FRIDAY,
            'sabado' => \Carbon\Carbon::SATURDAY,
        ];

        $dias = explode(',', $atividade->dias);
        $proxDia = null;
        $dataAtual = \Carbon\Carbon::now();

        foreach ($dias as $dia) {
            $dia = trim($dia);
            if (isset($diasSemanaMap[$dia])) {
                $proxDia = $dataAtual->copy()->next($diasSemanaMap[$dia]);

                // Define a próxima ocorrência da atividade
                if ($proxDia->greaterThanOrEqualTo($dataAtual)) {
                    $atividade->data_ocorrencia = $proxDia->toDateString();
                    break;
                }
            }
        }

        // Formatação de dias e horários
        $atividade->dias_formatados = implode(', ', array_map('ucfirst', explode(',', $atividade->dias)));
        return $atividade;
    });

    return view('aluno.atividades.matriculadas', compact('atividadesMatriculadas'));
}


}

