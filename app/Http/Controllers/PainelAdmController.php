<?php

namespace App\Http\Controllers;

use App\Models\Atividades;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use App\Models\Usuarios;
use App\Models\Tipos;
use Carbon\Carbon;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;

class PainelAdmController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
{
    Log::info('Método index do PainelAdmController chamado');

    // Obtém a data atual
    $dataAtual = Carbon::now();
    $diaSemanaAtual = strtolower($dataAtual->locale('pt_BR')->isoFormat('dddd'));
    $diaSemanaAtual = str_replace('-feira', '', $diaSemanaAtual);

    Log::info('Data Atual: ' . $dataAtual->toDateString());
    Log::info('Dia da Semana Atual: ' . $diaSemanaAtual);

    // Filtra as atividades que estão programadas para o dia da semana atual
    $atividades = Atividades::where('dias', 'LIKE', "%{$diaSemanaAtual}%")
                            ->whereDate('data_inicio', '<=', $dataAtual->toDateString())
                            ->whereDate('data_fim', '>=', $dataAtual->toDateString())
                            ->with('instrutor')
                            ->get();

    Log::info('Atividades Recuperadas: ' . $atividades->count());

    $atividadesFiltradas = $atividades->map(function ($atividade) use ($dataAtual, $diaSemanaAtual) {
        // Mapeia os dias da semana para os inteiros usados pelo Carbon
        $diasSemanaMap = [
            'domingo' => Carbon::SUNDAY,
            'segunda' => Carbon::MONDAY,
            'terca' => Carbon::TUESDAY,  // sem acento
            'quarta' => Carbon::WEDNESDAY,
            'quinta' => Carbon::THURSDAY,
            'sexta' => Carbon::FRIDAY,
            'sabado' => Carbon::SATURDAY, // sem acento
        ];

        // Verifica se a atividade é para o dia atual
        if (strpos($atividade->dias, $diaSemanaAtual) !== false) {
            // Se a atividade está dentro do intervalo de datas e é para o dia atual
            if ($dataAtual->between(Carbon::parse($atividade->data_inicio), Carbon::parse($atividade->data_fim))) {
                $atividade->data_ocorrencia = $dataAtual->toDateString();
                return $atividade;
            }
        }

        // Se não for o dia atual, calcula o próximo dia de ocorrência
        $proxDia = $dataAtual->copy()->next($diasSemanaMap[$diaSemanaAtual]);

        // Verifica se a próxima ocorrência está dentro do intervalo da atividade
        if ($proxDia->between(Carbon::parse($atividade->data_inicio), Carbon::parse($atividade->data_fim))) {
            $atividade->data_ocorrencia = $proxDia->toDateString();
            return $atividade;
        }

        return null;
    })->filter();


    Log::info('Atividades Filtradas: ' . $atividadesFiltradas->count());

    return view('administrador.paineladm', ['atividades' => $atividadesFiltradas]);
}


    public function perfilIndex()
{
    $usuario = Auth::user();
    return view('administrador.perfil.index', compact('usuario'));
}


public function perfilEdit($id)
{
    $usuario = Usuarios::findOrFail($id);
    return view('administrador.perfil.edit', compact('usuario'));
}

public function perfilUpdate(Request $request, $id)
{
    $usuario = Usuarios::findOrFail($id);

    $request->validate([
        'nome' => 'required|string|max:255',
        'sobrenome' => 'required|string|max:255',
        'email' => 'required|string|email|max:255|unique:usuarios,email,' . $id,
        'login' => 'required|string|max:255|unique:usuarios,login,' . $id,
        'data_nascimento' => 'required|date',
        'telefone' => 'required|string|max:15',
        'senha' => 'nullable|string|min:8|confirmed',
    ]);

    $usuario->update($request->only('nome', 'sobrenome', 'email', 'login', 'data_nascimento', 'telefone'));

    if ($request->filled('senha')) {
        $usuario->update(['senha' => bcrypt($request->senha)]);
    }

    Session::flash('flash_message', 'Perfil atualizado com sucesso!');
    return redirect()->route('admin.perfil.index');
}


}
