<?php

namespace App\Http\Controllers\EscalaPlantonistas;

use App\gerenciarCadastro;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class GerenciarCadastroController extends Controller
{
    public function gerenciarCadastros()
    {
     return view('EscalaPlantonistas.cadastros.garenciar-cadastros');

    }


    public function index()
    {
        //
    }


    public function create()
    {
        //
    }


    public function store(Request $request)
    {
        //
    }


    public function show(gerenciarCadastro $gerenciarCadastro)
    {
        //
    }


    public function edit(gerenciarCadastro $gerenciarCadastro)
    {
        //
    }


    public function update(Request $request, gerenciarCadastro $gerenciarCadastro)
    {
        //
    }

    public function destroy(gerenciarCadastro $gerenciarCadastro)
    {
        //
    }
}
