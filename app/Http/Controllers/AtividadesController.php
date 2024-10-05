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
use Carbon\Carbon;

class AtividadesController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    // ADMINISTRADOR
    public function listarAtividades(Request $request)
    {
        // Verifica se o usuário é admin antes de continuar
        $this->authorize('isAdmin', Auth::user());


             // Obtém todas as atividades únicas para o dropdown
    $atividades = Atividades::select('atividade')->distinct()->get();

        // Inicializa a query base
        $atividades = Atividades::with('instrutor');

        // Aplica filtros de busca para atividade/local
        if ($request->has('busca')) {
            $atividades->where(function ($query) use ($request) {
                $query->where('atividade', 'like', '%' . $request->busca . '%')
                      ->orWhere('local', 'like', '%' . $request->busca . '%');
            });
        }

        // Filtro para buscar pelo nome do instrutor
        if ($request->has('instrutor')) {
            $atividades->whereHas('instrutor', function ($query) use ($request) {
                $query->where('nome', 'like', '%' . $request->instrutor . '%');
            });
        }

        // Obtém todas as atividades e instrutores para popular o dropdown
        $todasAtividades = Atividades::all();
        $instrutores = \App\Models\Usuarios::where('tipo_id', 3)->get(); // Considerando que tipo_id 3 representa instrutores

        // Executa a consulta final
        $atividades = $atividades->get();

        return view('administrador.atividades.index', compact('atividades', 'todasAtividades', 'instrutores'));
    }

    public function adicionarAtividade()
    {
        $this->authorize('isAdmin', Auth::user());
        $instrutores = Usuarios::where('tipo_id', 3)->get(); // Obtém todos os instrutores
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
            'hora' => 'required|date_format:H:i', // Trata `hora` como um único horário
            'instrutor_id' => 'required|exists:usuarios,id',
            'local' => 'required|string|max:255',
            'dias' => 'required|array',
            'dias.*' => 'in:domingo,segunda,terca,quarta,quinta,sexta,sabado'
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        try {
            $atividade = Atividades::create([
                'atividade' => $request->atividade,
                'data_inicio' => $request->data_inicio,
                'data_fim' => $request->data_fim,
                'instrutor_id' => $request->instrutor_id,
                'local' => $request->local,
                'dias' => implode(',', $request->dias),  // Converte o array de dias para string
                'hora' => $request->hora,  // Armazena apenas um horário
            ]);

            Session::flash('flash_message', 'Atividade adicionada com sucesso!');
        } catch (\Exception $e) {
            Log::error('Erro ao criar atividade', ['error' => $e->getMessage()]);
            return redirect()->back()->withErrors('Erro ao criar atividade. Por favor, tente novamente.')->withInput();
        }

        return redirect()->route('admin.atividades.index');
    }
    public function update(Request $request, $id)
{
    $request->validate([
        'atividade' => 'required|string|max:255',
        'data_inicio' => 'required|date',
        'data_fim' => 'required|date|after_or_equal:data_inicio',
        'hora' => 'required|date_format:H:i',  // Confirma que `hora` é um único valor no formato correto (H:i)
        'instrutor_id' => 'required|exists:usuarios,id',
        'local' => 'required|string|max:255',
        'dias' => 'required|array',  // Confirma que `dias` é um array
        'dias.*' => 'in:domingo,segunda,terca,quarta,quinta,sexta,sabado'  // Cada dia deve ser válido
    ]);

    try {
        $atividade = Atividades::findOrFail($id);

        $atividade->update([
            'atividade' => $request->atividade,
            'data_inicio' => $request->data_inicio,
            'data_fim' => $request->data_fim,
            'instrutor_id' => $request->instrutor_id,
            'local' => $request->local,
            'dias' => implode(',', $request->dias),  // Converte o array de dias para uma string separada por vírgulas
            'hora' => $request->hora,  // Armazena apenas um horário
        ]);

        Session::flash('success', 'Atividade atualizada com sucesso!');
    } catch (\Exception $e) {
        Log::error('Erro ao atualizar atividade: ' . $e->getMessage());
        return redirect()->back()->with('error', 'Erro ao atualizar atividade. Por favor, tente novamente.');
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

    // ALUNO

    public function listarAtividadesAlunos(Request $request)
{
    $usuario = Auth::user();

    // Recupera as atividades nas quais o aluno já está matriculado
    $atividadesMatriculadas = $usuario->atividades()
                                      ->with(['instrutor', 'horarios'])
                                      ->get();

    // Recupera as atividades nas quais o aluno ainda não está matriculado
    $atividadesQuery = Atividades::whereNotIn('id', $atividadesMatriculadas->pluck('id'))
                                ->with(['instrutor', 'horarios']);

    // Aplica filtros de busca para atividade/local
    if ($request->has('busca')) {
        $atividadesQuery->where(function ($query) use ($request) {
            $query->where('atividade', 'like', '%' . $request->busca . '%')
                  ->orWhere('local', 'like', '%' . $request->busca . '%');
        });
    }

    // Pagina as atividades para garantir a disponibilidade do método links()
    $atividades = $atividadesQuery->paginate(10); // Apenas paginate(), sem get()

    return view('aluno.atividades.listar', compact('atividades', 'atividadesMatriculadas'));
}


// PROFESSOR
public function listarParaProfessores(Request $request)
{
    $user = Auth::user();

    if ($user) {
        Log::info('Listando todas as atividades do Centro Cultural para professor', ['user_id' => $user->id]);
    }

    // Criação da query base para listar atividades com instrutor e horários
    $atividadesQuery = Atividades::with(['instrutor', 'horarios']);

    // Filtro de busca por atividade ou local
    if ($request->has('busca')) {
        $atividadesQuery->where(function ($query) use ($request) {
            $query->where('atividade', 'like', '%' . $request->busca . '%')
                  ->orWhere('local', 'like', '%' . $request->busca . '%');
        });
    }

    // Obter a lista de atividades para exibir na tabela
    $atividades = $atividadesQuery->get();

    // Obter todas as atividades únicas para o dropdown
    $todasAtividades = Atividades::select('atividade')->distinct()->get();

    // Obter todos os instrutores
    $instrutores = Usuarios::where('tipo_id', 3)->distinct()->get();

    return view('atividades.listar', compact('atividades', 'instrutores', 'todasAtividades'));
}


    /*public function buscarAtividade($id)
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
        // Exemplo básico de horários. Deve ser substituído por lógica real.
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
    }*/
}
