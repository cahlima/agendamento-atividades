<?php

namespace App\Http\Controllers;

use App\Models\Horarios;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use App\Models\Atividades;
use App\Models\Usuarios;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class AtividadesController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    // Funções para administradores
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
        'hora' => 'required|array', // Mudança: hora agora é um array de horários
        'hora.*' => 'date_format:H:i', // Validação para cada horário no array
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
            'instrutor_id' => $request->instrutor_id,
            'instrutor' => $instrutor,
            'local' => $request->local,
            'dias' => $dias,
        ]);

        // Criar a atividade
        $atividade = Atividades::create([
            'atividade' => $request->atividade,
            'data_inicio' => $request->data_inicio,
            'data_fim' => $request->data_fim,
            'instrutor_id' => $request->instrutor_id,
            'instrutor' => $instrutor,
            'local' => $request->local,
            'dias' => $dias,
        ]);

        // Salvar os horários na tabela `horarios`
        foreach ($request->hora as $hora) {
            Horarios::create([
                'atividade_id' => $atividade->id,
                'hora' => $hora
            ]);
        }

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

    //Função para aluno

    public function buscarHorarios($id)
    {
        $horarios = Horarios::where('atividade_id', $id)->get(['hora']); // Pegando os horários relacionados à atividade
        return response()->json($horarios); // Certifique-se de que isso está retornando corretamente
    }



public function buscarAtividade($id)
{
    $atividade = Atividades::find($id);
    return response()->json($atividade);
}

    public function listarAtividadesPublicas()
    {
        $atividades = Atividades::all();
        return view('atividades.listar', compact('atividades'));
    }

    public function listar()
    {
        $atividades = Atividades::all(); // ou alguma outra lógica para recuperar as atividades
        return view('aluno.atividades.listar', compact('atividades'));
    }

public function atividadesMatriculadas()
{
    $user = Auth::user();
    $atividadesMatriculadas = $user->atividades()->paginate(10); // Paginação de 10 itens por página

    return view('aluno.atividades.matriculadas', compact('atividadesMatriculadas'));
}


    //funcao para professores

public function listarParaProfessores()
{
    $user = Auth::user();
    Log::info('Listando atividades para professor:', ['user_id' => $user->id]);

    return view('professor.atividades.index');
}

    public function profAtividadesIndex()
    {
        $user = Auth::user();

        if ($user->role !== 'professor') {
            abort(403, 'Acesso negado');
        }

        $atividades = $user->atividades;
        return view('professor.atividades.index', compact('atividades'));
    }


    public function profAtividadesMatriculadas()
    {
        $user = Auth::user();
        $atividades = $user->atividades;

        return view('professor.atividades.matriculadas', compact('atividades'));
    }
}
