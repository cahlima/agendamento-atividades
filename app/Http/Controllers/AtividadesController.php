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
        return view('administrador.atividades.adicionar');
    }

    // Salva uma nova atividade no banco de dados
    public function salvarAtividade(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'atividade' => 'required|string|max:255',
            'data' => 'required|date',
            'hora' => 'required|date_format:H:i',
            'instrutor' => 'required|string|max:255',
            'local' => 'required|string|max:255'
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        Atividades::create($request->only(['atividade', 'data', 'hora', 'instrutor', 'local']));

        Session::flash('flash_message', [
            'msg' => "Atividade adicionada com sucesso!",
            'class' => "alert-success"
        ]);
        return redirect()->route('atividades.index');
    }

    // Exibe o formulário para editar uma atividade existente
    public function editarAtividade($id)
{
    $atividade = Atividades::find($id);
    if (!$atividade) {
        return redirect()->back()->withErrors('Atividade não encontrada.');
    }
    return view('administrador.atividades.editar', compact('atividade'));
}

// Atualiza uma atividade no banco de dados
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
        'instrutor' => 'required|string|max:255',
        'local' => 'required|string|max:255'
    ]);

    if ($validator->fails()) {


        return redirect()->back()->withErrors($validator)->withInput();
    }


    $data = $request->only(['atividade', 'data', 'hora', 'instrutor', 'local']);


    $result = $atividade->update($data);

 

    Session::flash('flash_message', [
        'msg' => "Atividade atualizada com sucesso!",
        'class' => "alert-success"
    ]);

    return redirect()->route('atividades.index');
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
}
