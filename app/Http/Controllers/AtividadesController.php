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

        $validator = Validator::make($request->all(), [
            'atividade' => 'required|string|max:255',
            'data_inicio' => 'required|date',
            'data_fim' => 'required|date|after_or_equal:data_inicio',
            'hora' => 'required|array',
            'hora.*' => 'date_format:H:i',
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
        Log::info('Listando atividades para professor:', ['user_id' => $user->id]);

        $atividades = $user->atividadesAlocadas;

        return view('professor.atividades.listar', compact('atividades'));
    }

    public function buscarAtividades(Request $request)
    {
        $user = Auth::user();
        $busca = $request->input('busca');

        $atividades = $user->atividadesAlocadas()
                           ->where('titulo', 'like', '%' . $busca . '%')
                           ->orWhere('local', 'like', '%' . $busca . '%')
                           ->get();

        return view('professor.atividades.listar', compact('atividades'));
    }

    // Função para alunos (apenas exemplo, pode ser removido se não for necessário)
    public function listarAtividadesPublicas()
    {
        $atividades = Atividades::all();
        return view('atividades.listar', compact('atividades'));
    }
}
