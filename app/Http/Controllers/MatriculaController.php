<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Atividades;
use App\Models\Matricula;
use App\Models\Usuarios;
use App\Notifications\NotificaUsuarioMatricula;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log; // Adicionado Log
use Illuminate\Support\Facades\Session;

class MatriculaController extends Controller
{
    public function index()
    {
        $id_usuario = auth()->user()->id;
        $matriculas = DB::table('matriculas')
            ->join('usuarios', 'matriculas.usuario_id', '=', 'usuarios.id')
            ->join('atividades', 'matriculas.atividades_id', '=', 'atividades.id')
            ->where('atividades.usuario_id', $id_usuario)
            ->paginate(50);

        return view('matricula.index', compact('matriculas'));
    }

    public function matriculageral()
    {
        $matriculas = DB::table('matriculas')
            ->join('usuarios', 'matriculas.usuario_id', '=', 'usuarios.id')
            ->join('atividades', 'matriculas.atividades_id', '=', 'atividades.id')
            ->paginate(100);

        return view('matricula.matriculageral', compact('matriculas'));
    }

    public function matriculaaluno()
    {
        $usuario = auth()->user();

        if (!$usuario) {
            Log::error('Usuário não autenticado ao acessar matrículas');
            return redirect()->route('login')->with('error', 'Você precisa estar autenticado para acessar essa página.');
        }

        $id_usuario = $usuario->id;
        $matriculas = DB::table('matriculas')
            ->join('usuarios', 'matriculas.usuario_id', '=', 'usuarios.id')
            ->join('atividades', 'matriculas.atividades_id', '=', 'atividades.id')
            ->where('usuarios.id', $id_usuario)
            ->paginate(50);

        return view('matricula.indexaluno', compact('matriculas'));
    }

    public function confirmar($id)
    {
        $matriculas = DB::table('matriculas')
            ->join('usuarios', 'matriculas.usuario_id', '=', 'usuarios.id')
            ->join('atividades', 'matriculas.atividades_id', '=', 'atividades.id')
            ->where('atividades.id', $id)
            ->paginate(50);

        return view('matricula.indexatividades', compact('matriculas'));
    }

    public function adicionar()
    {
        return view('matricula.adicionar');
    }

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


