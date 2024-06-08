<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Atividades;
use Illuminate\Support\Facades\Session;

class AtividadesController extends Controller
{
    // Método para determinar o tipo de usuário
    private function getUserType()
    {
        return auth()->usuario()->type; // Supondo que o campo 'type' armazene o tipo de usuário
    }

    public function index()
    {
        $userType = $this->getUserType();

        switch ($userType) {
            case 'admin':
                // Administrador vê todas as atividades
                $atividades = Atividades::with('usuario')->paginate(10);
                break;

            case 'professor':
                // Professor vê apenas suas atividades
                $atividades = Atividades::where('usuario_id', auth()->id())->paginate(10);
                break;

            case 'aluno':
                // Aluno vê apenas atividades relacionadas a ele
                $atividades = Atividades::whereHas('alunos', function ($query) {
                    $query->where('aluno_id', auth()->id());
                })->paginate(10);
                break;

            default:
                // Se não for nenhum dos tipos acima, redirecionar ou lançar exceção
                abort(403, 'Acesso não autorizado.');
        }

        return view('atividades.index', compact('atividades'));
    }

    public function professor()
    {
        // Este método é específico para professores
        $userType = $this->getUserType();

        if ($userType != 'professor') {
            abort(403, 'Acesso não autorizado.');
        }

        $atividades = Atividades::where('usuario_id', auth()->id())->paginate(10);

        return view('atividades.index', compact('atividades'));
    }

    public function create()
    {
        return view('atividades.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'titulo' => 'required|string|max:255',
            'descricao' => 'nullable|string',
            'usuario_id' => 'required|exists:usuarios,id', // Assumindo que o campo usuario_id está presente no formulário
        ]);

        Atividades::create($data);

        Session::flash('flash_message', [
            'msg' => "Registro adicionado com sucesso!",
            'class' => "alert-success"
        ]);

        return redirect()->route('atividades.index');
    }

    public function show($id)
    {
        $atividade = Atividades::with('usuario')->findOrFail($id);

        return view('atividades.show', compact('atividade'));
    }

    public function edit($id)
    {
        $atividade = Atividades::findOrFail($id);

        return view('atividades.edit', compact('atividade'));
    }

    public function update(Request $request, $id)
    {
        $data = $request->validate([
            'titulo' => 'required|string|max:255',
            'descricao' => 'nullable|string',
            'usuario_id' => 'required|exists:usuarios,id', // Assumindo que o campo usuario_id está presente no formulário
        ]);

        $atividade = Atividades::findOrFail($id);
        $atividade->update($data);

        Session::flash('flash_message', [
            'msg' => "Registro atualizado com sucesso!",
            'class' => "alert-success"
        ]);

        return redirect()->route('atividades.index');
    }

    public function destroy($id)
    {
        $atividade = Atividades::findOrFail($id);
        $atividade->delete();

        Session::flash('flash_message', [
            'msg' => "Registro excluído com sucesso!",
            'class' => "alert-success"
        ]);

        return redirect()->route('atividades.index');
    }
}
