<?php

namespace App\Http\Controllers\EscalaPlantonistas;


use App\Cliente;
use App\Http\Controllers\Controller;
use App\Services\GatesTrait;
use Illuminate\Http\Request;

class ClienteController extends Controller
{
    use GatesTrait;
    public function index()
    {

    }

    public function create()
    {
        $clientes =  Cliente::orderBy('id')->paginate(5);
        return view("EscalaPlantonistas.cadastro-cliente", ["clientes"=>$clientes]);
    }

    public function store(Request $request)
    {
        $request->validate([
            "nome"=>"required|string|min:3",
        ]);

        $cliente = new Cliente();
        $cliente->nome = $request->nome;
        $isSaved = $cliente->save();

        if ($isSaved){
            return $this->redirectWithMessage(
                'escala.cadastrar-cliente.show',
                'success',
                '',
                'Cliente cadastrado! '
            );
        }
        return $this->redirectWithMessage(
            'escala.cadastrar-cliente.show',
            'error',
            '',
            "Não foi possível salvar o cliente!");
    }


    public function show()
    {

    }

    public function edit($id)
    {
        $clientes =  Cliente::where('id', $id)->first();

        if (!empty($clientes)){

            return view("EscalaPlantonistas.edita-cliente", ["cliente"=>$clientes]);

        }else{

            return redirect()->route('escala.cadastrar-cliente.store');
        }
    }

    public function update(Request $request, $id, Cliente $cliente)
    {

        $cliente ->find($id)->update([
            'nome' => $request->nome,
        ]);

        return redirect()->route('escala.cadastrar-cliente.store');
    }

    public function destroy(Request $request, $id, Cliente $cliente)
    {
        Cliente::where('id', $id)->delete();
        return redirect()->route('escala.cadastrar-cliente.store');
    }
}

