<?php

namespace App\Http\Controllers\EscalaPlantonistas;

use App\gerenciar;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class GerenciarController extends Controller
{
    public function gerenciar()
    {
        return view('EscalaPlantonistas.cadastros.gerenciar');
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


    public function show(gerenciar $gerenciar)
    {
        //
    }


    public function edit(gerenciar $gerenciar)
    {
        //
    }


    public function update(Request $request, gerenciar $gerenciar)
    {
        //
    }

    public function destroy(gerenciar $gerenciar)
    {
        //
    }
}
