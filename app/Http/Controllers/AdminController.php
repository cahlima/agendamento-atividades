<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AdminController extends Controller
{
    /**
     * Mostra o formulário para criar uma nova atividade.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('admin.atividades.create');
    }

    /**
     * Armazena uma nova atividade.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        // Lógica para armazenar a atividade
    }

    /**
     * Mostra os detalhes de uma atividade.
     *
     * @param  int  $id
     * @return \Illuminate\View\View
     */
    public function show($id)
    {
        // Lógica para mostrar os detalhes de uma atividade
    }

    /**
     * Mostra o formulário para editar uma atividade.
     *
     * @param  int  $id
     * @return \Illuminate\View\View
     */
    public function edit($id)
    {
        // Lógica para mostrar o formulário de edição de uma atividade
    }

    /**
     * Atualiza uma atividade existente.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, $id)
    {
        // Lógica para atualizar uma atividade
    }

    /**
     * Remove uma atividade.
     *
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy($id)
    {
        // Lógica para remover uma atividade
    }
}
