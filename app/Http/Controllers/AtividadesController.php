<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use App\Models\Atividades;
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
        $atividades = Atividades::all();
        return view('administrador.atividades.index', compact('atividades'));
    }

    // Lista apenas as atividades do dia atual
    public function listarAtividades()
    {
        $atividades = Atividades::whereDate('data', Carbon::today())->get();
        return view('administrador.atividades.listar', compact('atividades'));
    }

    // Exibe o formulário para adicionar uma nova atividade
       public function adicionarAtividade()
    {
        $instrutores = Usuarios::where('tipo_id', 2)->get(); // Carregar apenas os instrutores (tipo_id = 2)
        return view('administrador.atividades.adicionar', compact('instrutores'));
    }
    
    // Salva uma nova atividade no banco de dados
    public function salvarAtividade(Request $request)
    {
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
    
        Atividades::create([
            'atividade' => $request->atividade,
            'data' => $request->data,
            'hora' => $request->hora,
            'instrutor' => $request->instrutor,
            'local' => $request->local,
        ]);
    
        Session::flash('flash_message', [
            'msg' => "Atividade adicionada com sucesso!",
            'class' => "alert-success"
        ]);
        return redirect()->route('atividades.listar');
    }
    

    // Exibe o formulário para editar uma atividade existente
    public function editarAtividade($id)
{
    $atividade = Atividades::find($id);
    if (!$atividade) {
        return redirect()->route('atividades.listar')->withErrors('Atividade não encontrada.');
    }
    $instrutores = Usuarios::where('tipo_id', 2)->get(); // Carregar apenas os instrutores (tipo_id = 2)
    return view('administrador.atividades.editar', compact('atividade', 'instrutores'));
}

public function atualizarAtividade(Request $request, $id)
{
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
        'instrutor' => $request->instrutor,
        'local' => $request->local,
    ]);
    Session::flash('flash_message', [
        'msg' => "Atividade atualizada com sucesso!",
        'class' => "alert-success"
    ]);

    return redirect()->route('atividades.listar');
}


    // Deleta uma atividade do banco de dados
    public function deletarAtividade($id)
    {
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

    // Lista atividades para os alunos
    public function listar(Request $request)
    {
        $atividadesDisponiveis = Atividades::all();

        $query = Atividades::query();

        if ($request->filled('atividade_id')) {
            $query->where('id', $request->atividade_id);
        }

        // Coletando horários disponíveis das atividades
        $horariosDisponiveis = Atividades::pluck('hora')->unique();

        $atividades = $query->paginate(10);

        return view('aluno.atividades.listar', compact('atividadesDisponiveis', 'horariosDisponiveis', 'atividades'));
    }
}
