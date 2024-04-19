<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class Atividades extends Controller
{
    public function index (Request $request)
    {
        $atividades = [
            'volei',
            'futebol',
            'xadrez'
        ];


return view('atividades',compact('atividades'));

    }
}
