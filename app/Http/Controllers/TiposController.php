<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Tipos;

class TiposController extends Controller
{
    public function index()
    {
        $tipos = Tipos::paginate(10);
        return view('tipo.index', compact('tipos'));
    }

    public function adicionar()
    {
        return view('tipo.adicionar');
    }

    public function salvar(Request $request)
    {
        $request->validate([
            'nome' => 'required|string|max:255',
        ]);

        Tipos::create($request->all());
        return redirect()->route('tipo.index')->with('success', 'Tipo adicionado com sucesso.');
    }

    public function editar($id)
    {
        $tipo = Tipos::find($id);
        return view('tipo.editar', compact('tipo'));
    }

    public function atualizar(Request $request, $id)
    {
        $request->validate([
            'nome' => 'required|string|max:255',
        ]);

        $tipo = Tipos::find($id);
        $tipo->update($request->all());
        return redirect()->route('tipo.index')->with('success', 'Tipo atualizado com sucesso.');
    }

    public function deletar($id)
    {
        Tipos::find($id)->delete();
        return redirect()->route('tipo.index')->with('success', 'Tipo deletado com sucesso.');
    }
}
