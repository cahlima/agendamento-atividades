<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Atividades;
use App\Models\Matricula;
use App\Models\Usuarios;
use App\Notifications\NotificaUsuarioMatricula;
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
        $usuario = auth()->user();

        if (!$usuario) {
            Log::error('Usuário não autenticado ao tentar matricular-se');
            return redirect()->route('login')->with('error', 'Você precisa estar autenticado para acessar essa página.');
        }

        $atividades = Atividades::find($id);
        $id_usuario = $usuario->id;

        $dados = [
            "atividades_id" => $id,
            "usuario_id" => $id_usuario,
            "status" => 1,
        ];

        $matricula = Matricula::create($dados);
        $id_atividades = $matricula->atividades_id;
        $atividades = Atividades::find($id_atividades);
        $id_professor = $atividades->usuario_id;
        $professor = Usuarios::find($id_professor);

        // Notificar o professor
        $professor->notify(new NotificaUsuarioMatricula($professor, $matricula));

        $matriculas = DB::table('matriculas')
            ->join('usuarios', 'matriculas.usuario_id', '=', 'usuarios.id')
            ->join('atividades', 'matriculas.atividades_id', '=', 'atividades.id')
            ->where('usuarios.id', $id_usuario)
            ->paginate(100);

        return view('matricula.indexaluno', compact('matriculas'));
    }

    public function salvar(Request $request)
    {
        $dados = $request->all();
        $matriculas = Matricula::create($dados);

        Session::flash('flash_message', [
            'msg' => "Registro adicionado com sucesso!",
            'class' => "alert-success"
        ]);

        return redirect()->route('matricula.adicionar');
    }

    public function editar($id)
    {
        $matriculas = Matricula::find($id);

        return view('matricula.editar', compact('matriculas'));
    }

    public function editaraluno($id)
    {
        $matriculas = Matricula::find($id);

        return view('matricula.editaraluno', compact('matriculas'));
    }

    public function atualizar(Request $request, $id)
    {
        $matriculas = Matricula::find($id);
        $dados = $request->all();
        $matriculas->update($dados);

        $id_usuario = auth()->user()->id;
        $id_atividades = $matriculas->atividades_id;
        $atividades = Atividades::find($id_atividades);
        $id_aluno = $matriculas->usuario_id;
        $aluno = Usuarios::find($id_aluno);

        $aluno->notify(new NotificaUsuarioMatricula($aluno, $matriculas));

        Session::flash('flash_message', [
            'msg' => "Registro atualizado com sucesso!",
            'class' => "alert-success"
        ]);

        return redirect()->route('matricula.index');
    }

    public function atualizaraluno(Request $request, $id)
    {
        $matriculas = Matricula::find($id);
        $dados = $request->all();
        $matriculas->update($dados);

        Session::flash('flash_message', [
            'msg' => "Registro atualizado com sucesso!",
            'class' => "alert-success"
        ]);

        return redirect()->route('matricula.aluno');
    }

    public function deletar($id)
    {
        Matricula::find($id)->delete();

        Session::flash('flash_message', [
            'msg' => "Registro excluído com sucesso!",
            'class' => "alert-success"
        ]);

        return redirect()->route('matricula.index');
    }
}
