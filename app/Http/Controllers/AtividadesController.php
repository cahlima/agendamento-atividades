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

    // Função para alunos (essa será utilizada para listar atividades públicas)
    public function listarAtividadesPublicas(Request $request)
    {
        $atividades = Atividades::all();
        $horarios = [];

        if ($request->has('atividade')) {
            $horarios = Horarios::where('atividade_id', $request->atividade)->get();
        }

        return view('aluno.atividades.listar', compact('atividades', 'horarios'));
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

        $validator = Validator::make($request->all(), [
            'atividade' => 'required|string|max:255',
            'data_inicio' => 'required|date',
            'data_fim' => 'required|date|after_or_equal:data_inicio',
            'hora' => 'required|array',
            'hora.*' => 'required|date_format:H:i',
            'instrutor_id' => 'required|exists:usuarios,id',
            'local' => 'required|string|max:255',
            'dias' => 'required|array',
            'dias.*' => 'in:domingo,segunda,terca,quarta,quinta,sexta,sabado'
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $dias = implode(',', $request->dias);
        $instrutor = Usuarios::find($request->instrutor_id)->nome;

        try {
            $atividade = Atividades::create([
                'atividade' => $request->atividade,
                'data_inicio' => $request->data_inicio,
                'data_fim' => $request->data_fim,
                'instrutor_id' => $request->instrutor_id,
                'instrutor' => $instrutor,
                'local' => $request->local,
                'dias' => $dias,
            ]);

            foreach ($request->hora as $hora) {
                Horarios::create([
                    'atividade_id' => $atividade->id,
                    'hora' => $hora
                ]);
            }

            Session::flash('flash_message', 'Atividade adicionada com sucesso!');
        } catch (\Exception $e) {
            Log::error('Erro ao criar atividade', ['error' => $e->getMessage()]);
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
            Session::flash('flash_message', 'Atividade excluída com sucesso!');
        } else {
            Session::flash('flash_message', 'Atividade não encontrada.');
        }
        return redirect()->route('admin.atividades.index');
    }

    // Funções para professores
    public function listarParaProfessores()
    {
        $user = Auth::user();
        Log::info('Listando atividades para professor', ['user_id' => $user->id]);

        $atividades = Atividades::where('instrutor_id', $user->id)->get();

        return view('professor.atividades.listar', compact('atividades'));
    }

    public function buscarAtividade($id)
{
    try {
        $atividade = Atividades::with(['horarios', 'instrutor'])->findOrFail($id);

        return response()->json([
            'atividade' => $atividade->atividade,
            'instrutor' => $atividade->instrutor->nome,
            'horarios' => $atividade->horarios,
            'local' => $atividade->local,
            'dias' => $atividade->dias,
        ]);
    } catch (\Exception $e) {
        return response()->json(['error' => 'Ocorreu um erro ao buscar os detalhes da atividade.'], 500);
    }
}

public function buscarHorarios($id)
{
    $horarios = [
        [
            'hora' => '10:00',
            'instrutor' => 'Professor Exemplo',
            'local' => 'Sala 1',
            'dia' => 'segunda'
        ],
        [
            'hora' => '14:00',
            'instrutor' => 'Professor Exemplo',
            'local' => 'Sala 2',
            'dia' => 'terça'
        ]
    ];

    return response()->json($horarios);
}


}
