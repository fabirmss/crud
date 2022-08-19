<?php

namespace App\Http\Controllers\EscalaPlantonistas;


use App\Canal;
use App\Empresa;
use App\Http\Controllers\Controller;
use App\Services\GatesTrait;
use Illuminate\Http\Request;

class CanalController extends Controller
{
    use GatesTrait;
    public function index()
    {

    }

    public function create()
    {
        $canais =  Canal::orderBy('id')->paginate(5);
        return view("EscalaPlantonistas.cadastro-canal", ["canais"=>$canais]);
    }

    public function store(Request $request)
    {
        $request->validate([
            "nome"=>"required|string|min:3",
        ]);

        $canal = new Canal();
        $canal->nome = $request->nome;
        $isSaved = $canal->save();

        if ($isSaved){
            return $this->redirectWithMessage(
                'escala.cadastrar-canal.show',
                'success',
                '',
                'Canal cadastrado! '
            );
        }
        return $this->redirectWithMessage(
            'escala.cadastrar-canal.show',
            'error',
            '',
            "Não foi possível salvar o canal!");
    }


    public function show()
    {

    }

    public function edit($id)
    {

        $canais =  Canal::where('id', $id)->first();

        if (!empty($canais)){

            return view("EscalaPlantonistas.edita-canal", ["canal"=>$canais]);

        }else{

            return redirect()->route('escala.cadastrar-canal.store');
        }
    }

    public function update(Request $request, $id, Canal $canal)
    {

        $canal ->find($id)->update([
            'nome' => $request->nome,
        ]);

        return redirect()->route('escala.cadastrar-canal.store');
    }

    public function destroy(Request $request, $id, Canal $canal)
    {
        Canal::where('id', $id)->delete();
        return redirect()->route('escala.cadastrar-canal.store');
    }
}
