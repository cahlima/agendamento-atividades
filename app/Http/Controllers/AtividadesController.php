<?php

namespace App\Http\Controllers;

use App\Models\Horarios;
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

    public function index()
    {
        $this->authorize('isAdmin', Auth::user());
        $atividades = Atividades::with('professor')->get();
        return view('administrador.atividades.index', compact('atividades'));
    }



    public function listarAtividades()
    {
        $this->authorize('isAdmin', Auth::user());

        $atividades = Atividades::whereDate('data', Carbon::today())->get();
        return view('administrador.atividades.listar', compact('atividades'));
    }

    public function adicionarAtividade()
    {
        $this->authorize('isAdmin', Auth::user());

        $instrutores = Usuarios::where('tipo_id', 2)->get();
        return view('administrador.atividades.adicionar', compact('instrutores'));
    }

    public function salvarAtividade(Request $request)
{
    $this->authorize('isAdmin', Auth::user());

    // Validação dos dados
    $validator = Validator::make($request->all(), [
        'atividade' => 'required|string|max:255',
        'data' => 'required|date',
        'hora' => 'required|date_format:H:i',
        'instrutor' => 'required|exists:usuarios,id',
        'local' => 'required|string|max:255'
    ]);

    if ($validator->fails()) {
        return redirect()->back()->withErrors($validator)->withInput();
    }

    // Criação da nova atividade
    Atividades::create([
        'atividade' => $request->atividade,
        'data' => $request->data,
        'hora' => $request->hora,
        'instrutor_id' => $request->instrutor,
        'local' => $request->local,
    ]);

    // Mensagem de sucesso
    Session::flash('flash_message', [
        'msg' => "Atividade adicionada com sucesso!",
        'class' => "alert-success"
    ]);

    return redirect()->route('atividades.index');
}
    public function editarAtividade($id)
    {
        $this->authorize('isAdmin', Auth::user());

        $atividade = Atividades::find($id);
        if (!$atividade) {
            return redirect()->route('atividades.index')->withErrors('Atividade não encontrada.');
        }
        $instrutores = Usuarios::where('tipo_id', 2)->get();
        return view('administrador.atividades.editar', compact('atividade', 'instrutores'));
    }

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
            'instrutor' => 'required|exists:usuarios,id',
            'local' => 'required|string|max:255'
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $atividade->update([
            'atividade' => $request->atividade,
            'data' => $request->data,
            'hora' => $request->hora,
            'instrutor_id' => $request->instrutor,
            'local' => $request->local,
        ]);
        Session::flash('flash_message', [
            'msg' => "Atividade atualizada com sucesso!",
            'class' => "alert-success"
        ]);

        return redirect()->route('atividades.index');
    }

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

    public function listar(Request $request)
{
    $usuario = Auth::user();
    $query = Atividades::query();

    if ($usuario->isAdmin()) {
        if ($request->has('search')) {
            $query->where('atividade', 'like', '%' . $request->search . '%');
        }
        $atividades = $query->with('professor')->paginate(10);
        return view('administrador.atividades.listar', compact('atividades'));
    } elseif ($usuario->isProfessor()) {
        if ($request->has('search')) {
            $query->where('atividade', 'like', '%' . $request->search . '%');
        }
        $atividades = $query->with('professor')->where('instrutor_id', $usuario->id)->paginate(10);
        return view('professor.atividades.listar', compact('atividades'));
    } elseif ($usuario->isAluno()) {
        if ($request->has('search')) {
            $query->where('atividade', 'like', '%' . $request->search . '%');
        }
        $atividades = $query->with('professor')->paginate(10);
        return view('aluno.atividades.listar', compact('atividades'));
    } else {
       return redirect()->back()->with('error', 'Permissão negada.');
}
}

    public function atividadesMatriculadas()
    {
        $usuario = Auth::user();
        if ($usuario->isAluno()) {
            $atividades = $usuario->atividades()->with('professor')->paginate(10);
            return view('aluno.atividades.matriculadas', compact('atividades'));
        }
        return redirect()->back()->with('error', 'Acesso não autorizado.');
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
            $atividades = Auth::user()->atividades()->get();
            return view('professor.atividades.matriculadas', compact('atividades'));
        }
        return redirect()->back()->with('error', 'Acesso não autorizado.');
    }

    public function buscarHorarios($id)
    {
        $horarios = Horarios::where('atividade_id', $id)->get();
        return response()->json($horarios);
    }

    public function buscarAtividades($id)
    {
        $atividade = Atividades::with('professor')->find($id);
        return response()->json([$atividade]);
    }
}

