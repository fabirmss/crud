<?php

namespace App\Http\Controllers\EscalaPlantonistas;

use App\Acessos;
use App\Cliente;
use App\Canal;
use App\Http\Controllers\Controller;
use App\Services\GatesTrait;
use Illuminate\Http\Request;

class AcessosController extends Controller
{

    use GatesTrait;


    public function index()
    {

    $search = request('search');

    if($search){



    }

    }

    public function create()
    {
        $acessos =  Acessos::orderBy('id')->paginate(5);
        $clientes = Cliente::all();
        $canais = Canal::all();
        return view("EscalaPlantonistas.cadastro-acessos", ["acessos"=>$acessos,
            "canal"=>$canais, "clientes"=>$clientes]);
    }

    public function store(Request $request)
    {
        $request->validate([
            "minutos"=>"required|numeric|min:3",
            "date"=>"required|date",
            "cliente"=>"required|string",
            "canal"=>"required|string",
        ]);

        $acesso = new Acessos;
        $acesso->minutos = $request->minutos;
        $acesso->date = $request->date;
        $acesso->idcliente = $request->cliente;
        $acesso->idcanal = $request->canal;
        $isSaved = $acesso->save();

        if ($isSaved){
            return $this->redirectWithMessage(
                'escala.cadastrar-acessos.show',
                'success',
                '',
                'Minutos assistidos cadastrada! '
            );
        }
        return $this->redirectWithMessage(
            'escala.cadastrar-acessos.show',
            'error',
            '',
            "Não foi possível salvar!");
    }


    public function show(Acesso $acesso)
    {

    }

    public function selectCanal() {
        $canal = $_POST['canal'];
        $results = DB::select('select  from padrao where id = ?', [1]);

        // return response()->view('list', $results);
    }
}
