<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use App\Models\Atividades;
use App\Models\Usuarios;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;

class AtividadesController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function listarAtividades()
    {
        $this->authorize('isAdmin', Auth::user());
        $atividades = Atividades::with('instrutor')->get();
        return view('administrador.atividades.index', compact('atividades'));
    }
    public function adicionarAtividade()
    {
        $this->authorize('isAdmin', Auth::user());
        $instrutores = Usuarios::where('tipo_id', 3)->get();
        return view('administrador.atividades.adicionar', compact('instrutores'));
    }

    public function editarAtividade($id)
    {
        $this->authorize('isAdmin', Auth::user());

        $atividade = Atividades::find($id);
        if (!$atividade) {
            return redirect()->route('admin.atividades.index')->withErrors('Atividade não encontrada.');
        }
        $instrutores = Usuarios::where('tipo_id', 3)->get();
        return view('administrador.atividades.editar', compact('atividade', 'instrutores'));
    }



    public function salvarAtividade(Request $request)
{
    $this->authorize('isAdmin', Auth::user());

    Log::info('Iniciando validação dos dados da atividade.', ['dados' => $request->all()]);

    $validator = Validator::make($request->all(), [
        'atividade' => 'required|string|max:255',
        'data_inicio' => 'required|date',
        'data_fim' => 'required|date|after_or_equal:data_inicio',
        'hora' => 'required|date_format:H:i',
        'instrutor_id' => 'required|exists:usuarios,id',
        'local' => 'required|string|max:255',
        'dias' => 'required|array',
        'dias.*' => 'in:domingo,segunda,terca,quarta,quinta,sexta,sabado'
    ]);

    if ($validator->fails()) {
        Log::error('Validação dos dados falhou.', ['erros' => $validator->errors()]);
        return redirect()->back()->withErrors($validator)->withInput();
    }

    $dias = implode(',', $request->dias);
    $instrutor = Usuarios::find($request->instrutor_id)->nome; // Obter o nome do instrutor

    try {
        Log::info('Tentando criar nova atividade.', [
            'atividade' => $request->atividade,
            'data_inicio' => $request->data_inicio,
            'data_fim' => $request->data_fim,
            'hora' => $request->hora,
            'instrutor_id' => $request->instrutor_id,
            'instrutor' => $instrutor, // Adicionar o nome do instrutor
            'local' => $request->local,
            'dias' => $dias,
        ]);

        Atividades::create([
            'atividade' => $request->atividade,
            'data_inicio' => $request->data_inicio,
            'data_fim' => $request->data_fim,
            'hora' => $request->hora,
            'instrutor_id' => $request->instrutor_id,
            'instrutor' => $instrutor, // Adicionar o nome do instrutor
            'local' => $request->local,
            'dias' => $dias,
        ]);

        Log::info('Atividade criada com sucesso.');

        Session::flash('flash_message', [
            'msg' => "Atividade adicionada com sucesso!",
            'class' => "alert-success"
        ]);
    } catch (\Exception $e) {
        Log::error('Erro ao criar atividade.', ['erro' => $e->getMessage()]);
        return redirect()->back()->withErrors('Erro ao criar atividade. Por favor, tente novamente.')->withInput();
    }

    return redirect()->route('admin.atividades.index');
}


    public function update(Request $request, $id)
{
    $this->authorize('isAdmin', Auth::user());

    $atividade = Atividades::find($id);
    if (!$atividade) {
        return redirect()->back()->withErrors('Atividade não encontrada.');
    }

    $validator = Validator::make($request->all(), [
        'atividade' => 'required|string|max:255',
        'data_inicio' => 'required|date',
        'data_fim' => 'required|date|after_or_equal:data_inicio',
        'hora' => 'required|date_format:H:i',
        'instrutor_id' => 'required|exists:usuarios,id',
        'local' => 'required|string|max:255',
        'dias' => 'required|array',
        'dias.*' => 'in:domingo,segunda,terca,quarta,quinta,sexta,sabado'
    ]);

    if ($validator->fails()) {
        return redirect()->back()->withErrors($validator)->withInput();
    }

    $dias = implode(',', $request->dias);
    $instrutor = Usuarios::find($request->instrutor_id)->nome; // Obter o nome do instrutor

    $atividade->update([
        'atividade' => $request->atividade,
        'data_inicio' => $request->data_inicio,
        'data_fim' => $request->data_fim,
        'hora' => $request->hora,
        'instrutor_id' => $request->instrutor_id,
        'instrutor' => $instrutor,
        'local' => $request->local,
        'dias' => $dias,
    ]);

    Session::flash('flash_message', [
        'msg' => "Atividade atualizada com sucesso!",
        'class' => "alert-success"
    ]);

    return redirect()->route('admin.atividades.index');
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
        return redirect()->route('admin.atividades.index');
    }

    public function buscarHorarios($id)
    {
        // Implemente a lógica para buscar horários de uma atividade específica
    }

    public function buscarAtividades($id)
    {
        // Implemente a lógica para buscar uma atividade específica
    }

    public function listarAtividadesPublicas()
    {
        $atividades = Atividades::all();
        return view('atividades.listar', compact('atividades'));
    }
   

    public function index()
{
    $atividades = Atividades::all()->map(function($atividade) {
        $diasSemana = explode(',', $atividade->dias);
        $proximasAtividades = $this->calcularProximasAtividades($atividade->data_inicio, $atividade->data_fim, $diasSemana);
        $atividade->proximas_atividades = $proximasAtividades ?? [];
        return $atividade;
    });

    return view('administrador.atividades.index', compact('atividades'));
}


    private function calcularProximasAtividades($dataInicio, $dataFim, $diasSemana)
    {
        $proximasAtividades = [];
        $dataAtual = Carbon::parse($dataInicio);
        $dataFim = Carbon::parse($dataFim);

        while ($dataAtual->lte($dataFim)) {
            if (in_array($dataAtual->format('l'), $diasSemana)) {
                $proximasAtividades[] = $dataAtual->format('d/m/Y');
            }
            $dataAtual->addDay();
        }

        return $proximasAtividades;
    }
}
