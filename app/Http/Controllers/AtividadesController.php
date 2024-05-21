<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Atividades;
use App\Models\Usuarios;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class AtividadesController extends Controller
{
    public function index()
    {
        $atividades = Atividades::with('usuario')->paginate(10);

        return view('atividades.index', compact('atividades'));
    }

    public function professor()
    {
        $id_usuario = auth()->user()->id;

        $atividades = Atividades::where('usuario_id', $id_usuario)->paginate(10);

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
