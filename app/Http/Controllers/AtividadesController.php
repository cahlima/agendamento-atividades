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
     public function painelAdm()
     {
         // Verifica se o usuário é admin antes de continuar
         $this->authorize('isAdmin', Auth::user());

         // Obtém a data e o dia da semana atual
         $dataAtual = Carbon::now();
         $diaSemanaAtual = strtolower($dataAtual->locale('pt_BR')->isoFormat('dddd'));
         $diaSemanaAtual = str_replace('-feira', '', $diaSemanaAtual);

         // Filtra as atividades que estão programadas para o dia da semana atual e que ainda não ocorreram
         $atividades = Atividades::where('dias', 'LIKE', "%{$diaSemanaAtual}%")
                                 ->whereDate('data_inicio', '<=', $dataAtual->toDateString())
                                 ->whereDate('data_fim', '>=', $dataAtual->toDateString())
                                 ->whereTime('hora', '>=', $dataAtual->toTimeString())
                                 ->with('instrutor')
                                 ->get();

         // Se não houver atividades hoje ou todas as atividades de hoje já passaram, calcula a próxima ocorrência
         if ($atividades->isEmpty()) {
             // Calcula a próxima ocorrência para o mesmo dia da semana na próxima semana
             $proximaOcorrencia = $dataAtual->copy()->next($diaSemanaAtual);

             $atividades = Atividades::where('dias', 'LIKE', "%{$diaSemanaAtual}%")
                                     ->whereDate('data_inicio', '<=', $proximaOcorrencia->toDateString())
                                     ->whereDate('data_fim', '>=', $proximaOcorrencia->toDateString())
                                     ->with('instrutor')
                                     ->get();
         }

         // Ordenar as atividades por horário
         $atividades = $atividades->sortBy('hora');

         return view('administrador.paineladm', ['atividades' => $atividades]);
     }

public function listarAtividades(Request $request)
{
    // Verifica se o usuário é admin antes de continuar
    $this->authorize('isAdmin', Auth::user());

    // Inicializa a query base
    $atividades = Atividades::with('instrutor');

    // Aplica filtros de busca
    if ($request->has('busca')) {
        $atividades->where('atividade', 'like', '%' . $request->busca . '%')
                   ->orWhere('local', 'like', '%' . $request->busca . '%');
    }

    // Filtra por datas se necessário
    $atividades = $atividades->where('data_inicio', '<=', now())
                             ->where('data_fim', '>=', now())
                             ->get();

    return view('administrador.atividades.index', compact('atividades'));
}

    public function listarAtividadesAlunos(Request $request)
    {
        $atividades = Atividades::with(['instrutor', 'horarios']); // Carrega instrutor e horários

        if ($request->has('busca')) {
            $atividades->where('atividade', 'like', '%' . $request->busca . '%')
                       ->orWhere('local', 'like', '%' . $request->busca . '%');
        }
        $atividades = Atividades::where('data_inicio', '<=', now())
                         ->where('data_fim', '>=', now())
                         ->with(['instrutor', 'horarios'])
                         ->get();


        return view('aluno.atividades.listar', compact('atividades'));
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

        $dias = implode(',', $request->dias);
        $instrutor = Usuarios::find($request->instrutor_id)->nome;

        try {
            $instrutor = Usuarios::find($request->instrutor_id)->nome;

            $atividade = Atividades::create([
                'atividade' => $request->atividade,
                'data_inicio' => $request->data_inicio,
                'data_fim' => $request->data_fim,
                'instrutor_id' => $request->instrutor_id,
                'instrutor' => $instrutor, // Inclui o nome do instrutor aqui
                'local' => $request->local,
                'dias' => implode(',', $request->dias),
                'hora' => implode(',', $request->hora),
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

        // Lista atividades onde o professor é o instrutor
        $atividades = Atividades::where('instrutor_id', $user->id)->get();

        // Aqui, o caminho da view foi ajustado para usar a view compartilhada
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

    public function listarAtividadesParaAlunos(Request $request)
{
    // Filtra as atividades de acordo com a busca, caso haja um termo
    $atividades = Atividades::query();

    if ($request->has('busca')) {
        $atividades->where('atividade', 'like', '%' . $request->busca . '%')
                   ->orWhere('local', 'like', '%' . $request->busca . '%');
    }

    // Considera apenas as atividades dentro do período de validade
    $atividades = $atividades->where('data_inicio', '<=', now())
                             ->where('data_fim', '>=', now())
                             ->get();

    // Busca os horários, caso uma atividade específica seja selecionada
    $horarios = [];

    if ($request->has('atividade')) {
        $horarios = Horarios::where('atividade_id', $request->atividade)->get();
    }

    return view('aluno.atividades.listar', compact('atividades', 'horarios'));
}


    // Método para atualizar uma atividade
    public function update(Request $request, $id)
    {
        // Validação dos dados enviados
        $request->validate([
            'atividade' => 'required|string|max:255',
            'data_inicio' => 'required|date',
            'data_fim' => 'required|date|after_or_equal:data_inicio',
            'hora' => 'required',
            'instrutor_id' => 'required|exists:usuarios,id',
            'local' => 'required|string|max:255',
            'dias' => 'required|array',
            'dias.*' => 'in:domingo,segunda,terca,quarta,quinta,sexta,sabado'
        ]);

        try {
            // Buscar a atividade pelo ID
            $atividade = Atividades::findOrFail($id);

            // Atualizar os dados da atividade
            $atividade->update([
                'atividade' => $request->atividade,
                'data_inicio' => $request->data_inicio,
                'data_fim' => $request->data_fim,
                'hora' => $request->hora,
                'instrutor_id' => $request->instrutor_id,
                'local' => $request->local,
                'dias' => implode(',', $request->dias),
            ]);

            Session::flash('success', 'Atividade atualizada com sucesso!');
        } catch (\Exception $e) {
            Log::error('Erro ao atualizar atividade: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Erro ao atualizar atividade. Por favor, tente novamente.');
        }

        return redirect()->route('admin.atividades.index');
    }
}


