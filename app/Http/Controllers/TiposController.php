<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Tipos;

class TiposController extends Controller
{
    // Exibe uma lista paginada de tipos de usuários
    public function index()
    {
        $tipos = Tipos::paginate(10);
        return view('tipo.index', compact('tipos'));
    }

    // Exibe o formulário para adicionar um novo tipo de usuário
    public function adicionar()
    {
        return view('tipo.adicionar');
    }

    // Salva um novo tipo de usuário no banco de dados
    public function salvar(Request $request)
    {
        $request->validate([
            'nome' => 'required|string|max:255',
        ]);

        Tipos::create($request->all());
        return redirect()->route('tipo.index')->with('success', 'Tipo adicionado com sucesso.');
    }

    // Exibe o formulário para editar um tipo de usuário existente
    public function editar($id)
    {
        $tipo = Tipos::find($id);
        return view('tipo.editar', compact('tipo'));
    }

    // Atualiza os dados de um tipo de usuário existente
    public function atualizar(Request $request, $id)
    {
        $request->validate([
            'nome' => 'required|string|max:255',
        ]);

        $tipo = Tipos::find($id);
        $tipo->update($request->all());
        return redirect()->route('tipo.index')->with('success', 'Tipo atualizado com sucesso.');
    }

    // Deleta um tipo de usuário existente
    public function deletar($id)
    {
        Tipos::find($id)->delete();
        return redirect()->route('tipo.index')->with('success', 'Tipo deletado com sucesso.');
    }
}
