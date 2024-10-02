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

        // Inicializa a query base
        $atividades = Atividades::with('instrutor');

        // Aplica filtros de busca para atividade/local e instrutor
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

        // Se nenhum filtro for aplicado, exibe todas as atividades
        if (!$request->has('busca') && !$request->has('instrutor')) {
            $atividades = $atividades->get(); // Exibe todas as atividades se nenhum filtro for aplicado
        } else {
            // Se houver filtros, aplique-os e busque as atividades
            $atividades = $atividades->get();
        }

        return view('administrador.atividades.index', compact('atividades'));
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

        try {
            $instrutor = Usuarios::find($request->instrutor_id)->nome;

            $atividade = Atividades::create([
                'atividade' => $request->atividade,
                'data_inicio' => $request->data_inicio,
                'data_fim' => $request->data_fim,
                'instrutor_id' => $request->instrutor_id,
                'local' => $request->local,
                'dias' => implode(',', $request->dias),  // Converte o array de dias para string
                'hora' => implode(',', $request->hora),  // Converte o array de horários para string
            ]);



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

    public function update(Request $request, $id)
{
    // Valida os campos
    $request->validate([
        'atividade' => 'required|string|max:255',
        'data_inicio' => 'required|date',
        'data_fim' => 'required|date|after_or_equal:data_inicio',
        'hora' => 'required|array',  // Confirma que `hora` é um array
        'hora.*' => 'required|date_format:H:i',  // Cada item deve estar no formato correto (H:i)
        'instrutor_id' => 'required|exists:usuarios,id',
        'local' => 'required|string|max:255',
        'dias' => 'required|array',  // Confirma que `dias` é um array
        'dias.*' => 'in:domingo,segunda,terca,quarta,quinta,sexta,sabado'  // Cada dia deve ser válido
    ]);

    try {
        // Busca a atividade no banco de dados
        $atividade = Atividades::findOrFail($id);

        // Atualiza os dados da atividade
        $atividade->update([
            'atividade' => $request->atividade,
            'data_inicio' => $request->data_inicio,
            'data_fim' => $request->data_fim,
            'instrutor_id' => $request->instrutor_id,
            'local' => $request->local,
            'dias' => implode(',', $request->dias),  // Converte o array de dias para uma string separada por vírgulas
            'hora' => implode(',', $request->hora),  // Converte o array de horários para uma string separada por vírgulas
        ]);

        // Flash de sucesso
        Session::flash('success', 'Atividade atualizada com sucesso!');
    } catch (\Exception $e) {
        // Log de erro e mensagem de falha
        Log::error('Erro ao atualizar atividade: ' . $e->getMessage());
        return redirect()->back()->with('error', 'Erro ao atualizar atividade. Por favor, tente novamente.');
    }

    // Redireciona para a listagem de atividades após a atualização
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
        $atividades = Atividades::whereNotIn('id', $atividadesMatriculadas->pluck('id'))
                                ->with(['instrutor', 'horarios']);

        // Aplica filtros de busca
        if ($request->has('busca')) {
            $atividades->where(function ($query) use ($request) {
                $query->where('atividade', 'like', '%' . $request->busca . '%')
                      ->orWhere('local', 'like', '%' . $request->busca . '%');
            });
        }

        $atividades = $atividades->paginate(10);


        return view('aluno.atividades.listar', compact('atividades', 'atividadesMatriculadas'));
    }

    // PROFESSOR
    public function listarParaProfessores(Request $request)
    {
        // Obtém o usuário autenticado
        $user = Auth::user();

        // Verifica se o usuário está autenticado
        if ($user) {
            Log::info('Listando todas as atividades do Centro Cultural para professor', ['user_id' => $user->id]);
        }

        // Lista todas as atividades do Centro Cultural, carregando o instrutor e horários relacionados
        $atividades = Atividades::with(['instrutor', 'horarios']) // Carrega as relações
            ->when($request->busca, function ($query) use ($request) {
                // Filtro de busca opcional por nome da atividade ou local
                return $query->where('atividade', 'like', '%' . $request->busca . '%')
                             ->orWhere('local', 'like', '%' . $request->busca . '%');
            })
            ->get();

        // Retorna a view com as atividades filtradas ou todas as atividades
        return view('atividades.listar', compact('atividades'));
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
    }
}
