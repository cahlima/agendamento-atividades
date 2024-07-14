<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use App\Models\Atividades;
use App\Models\Usuarios;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;

class AtividadesController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    // Exibe o painel administrativo com todas as atividades
    public function index()
    {
        $this->authorize('isAdmin', Auth::user());

        $atividades = Atividades::all();
        return view('administrador.atividades.index', compact('atividades'));
    }

    // Lista apenas as atividades do dia atual
    public function listarAtividades()
    {
        $this->authorize('isAdmin', Auth::user());

        $atividades = Atividades::whereDate('data', Carbon::today())->get();
        return view('administrador.atividades.listar', compact('atividades'));
    }

    // Exibe o formulário para adicionar uma nova atividade
    public function adicionarAtividade()
    {
        $this->authorize('isAdmin', Auth::user());

        $instrutores = Usuarios::where('tipo_id', 2)->get(); // Carregar apenas os instrutores (tipo_id = 2)
        return view('administrador.atividades.adicionar', compact('instrutores'));
    }
    // Salva uma nova atividade no banco de dados
    public function salvarAtividade(Request $request)
    {
        $this->authorize('isAdmin', Auth::user());

        $validator = Validator::make($request->all(), [
            'atividade' => 'required|string|max:255',
            'data' => 'required|date',
            'hora' => 'required|date_format:H:i',
            'professor' => 'required|exists:usuarios,id',
            'local' => 'required|string|max:255'
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        Atividades::create([
            'atividade' => $request->atividade,
            'data' => $request->data,
            'hora' => $request->hora,
            'professor' => $request->instrutor,
            'local' => $request->local,
        ]);

        Session::flash('flash_message', [
            'msg' => "Atividade adicionada com sucesso!",
            'class' => "alert-success"
        ]);
        return redirect()->route('atividades.index');
    }

    // Exibe o formulário para editar uma atividade existente
    public function editarAtividade($id)
    {
        $this->authorize('isAdmin', Auth::user());

        $atividade = Atividades::find($id);
        if (!$atividade) {
            return redirect()->route('atividades.index')->withErrors('Atividade não encontrada.');
        }
        $instrutores = Usuarios::where('tipo_id', 2)->get(); // Carregar apenas os instrutores (tipo_id = 2)
        return view('administrador.atividades.editar', compact('atividade', 'professor'));
    }

    // Atualiza uma atividade existente no banco de dados
    public function atualizarAtividade(Request $request, $id)
    {
        $this->authorize('isAdmin', Auth::user());

        $atividade = Atividades::find($id);
        if (!$atividade) {
            return redirect()->back()->withErrors('Atividade não encontrada.');
        }

        $validator = Validator::make($request->all(), [
            'atividade' => 'required|string|max:255',
            'data' => 'required|date',
            'hora' => 'required|date_format:H:i',
            'professor' => 'required|exists:usuarios,id',
            'local' => 'required|string|max:255'
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $atividade->update([
            'atividade' => $request->atividade,
            'data' => $request->data,
            'hora' => $request->hora,
            'instrutor' => $request->instrutor,
            'local' => $request->local,
        ]);
        Session::flash('flash_message', [
            'msg' => "Atividade atualizada com sucesso!",
            'class' => "alert-success"
        ]);

        return redirect()->route('atividades.index');
    }

    // Deleta uma atividade do banco de dados
    public function deletarAtividade($id)
    {
        $this->authorize('isAdmin', Auth::user());

        $atividade = Atividades::find($id);
        if ($atividade) {
            $atividade->delete();
            Session::flash('flash_message', [
                'msg' => "Atividade excluída com sucesso!",
                'class' => "alert-success"
            ]);
        } else {
            Session::flash('flash_message', [
                'msg' => "Atividade não encontrada.",
                'class' => "alert-danger"
            ]);
        }
        return redirect()->route('atividades.index');
    }

    // Lista atividades para os alunos e professores
    public function listar()
    {
        $usuario = Auth::user();

        // Definindo atividades disponíveis para todos os usuários, ajuste conforme necessário
    $atividadesDisponiveis = Atividades::select('id', 'atividade')->get();

        if ($usuario->isAdmin()) {
            $atividades = Atividades::all();
            return view('administrador.atividades.listar', compact('atividades'));
        } elseif ($usuario->isProfessor()) {
            $atividades = Atividades::where('professor_id', $usuario->id)->get();
            return view('professor.atividades.listar', compact('atividades'));
        } elseif ($usuario->isAluno()) {
            $atividades = Atividades::all();
            return view('aluno.atividades.listar', compact('atividades'));
        }

        return redirect()->back()->with('error', 'Permissão negada.');
    }

    // Lista as atividades matriculadas para o aluno
    public function atividadesMatriculadas()
    {
        $usuario = Auth::user();
        if ($usuario->isAluno()) {
            $atividades = $usuario->atividades()->get();
            return view('aluno.atividades.matriculadas', compact('atividades'));
        }
        return redirect()->back()->with('error', 'Acesso não autorizado.');
    }


    // Matricula e desmatricula aluno em atividades
    public function matricular(Request $request, $id)
    {
        $usuario = Auth::user();
        if ($usuario->isAluno()) {
            $atividade = Atividades::findOrFail($id);
            $usuario->atividades()->attach($atividade);
            return redirect()->route('aluno.atividades.matriculadas')->with('success', 'Matriculado na atividade com sucesso!');
        }
        return redirect()->back()->with('error', 'Operação não permitida.');
    }

    public function desmatricular($id)
    {
        $usuario = Auth::user();
        if ($usuario->isAluno()) {
            $usuario->atividades()->detach($id);
            return redirect()->route('aluno.atividades.matriculadas')->with('success', 'Desmatriculado da atividade com sucesso!');
        }
        return redirect()->back()->with('error', 'Operação não permitida.');
    }

    public function instrutor()
{
    return $this->belongsTo(Usuarios::class, 'professor_id');
}
// Método fictício para mostrar redirecionamento

public function profAtividadesIndex()
    {
        if (Auth::user()->isProfessor()) {
            $atividades = Atividades::where('instrutor_id', Auth::id())->get();
            return view('professor.atividades.listar', compact('atividades'));
        }
        return redirect()->route('professor.atividades.listar')->with('error', 'Acesso não autorizado.');
    }

    public function profAtividadesMatriculadas()
    {
        if (Auth::user()->isProfessor()) {
            $atividades = Auth::user()->atividades()->get(); // Supondo que 'atividades' é uma relação definida no modelo do usuário
            return view('professor.atividades.matriculadas', compact('atividades'));
        }
        return redirect()->back()->with('error', 'Acesso não autorizado.');
    }
}
