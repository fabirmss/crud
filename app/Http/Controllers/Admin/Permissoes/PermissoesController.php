<?php

namespace App\Http\Controllers\Admin\Permissoes;

use App\Entities\Permissao;
use App\Enums\MensagensEnum;
use App\Http\Requests\Admin\Permissoes\PermissoesRequest;
use App\Services\GatesTrait;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

/**
 * Class PermissoesController
 *
 * @package App\Http\Controllers\Admin\Permissoes
 */
class PermissoesController extends Controller
{
    // Trait criado para verificar permissões e retornar feedbacks
    use GatesTrait;

    /**
     * @var Permissao
     */
    private $permissao;

    /**
     * PermissoesController constructor.
     *
     * @param Permissao $permissao
     */
    public function __construct(Permissao $permissao)
    {
        $this->permissao = $permissao;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try {
            if (!$this->isAllowed('can-access-permissoes')) {
                return $this->redirectWhenNotAllowed('admin.home');
            }

            return view('admin.permissoes.permissoes')->with([
                'permissoes' => $this->permissao->orderBy('nome', 'ASC')->paginate(25)
            ]);
        } catch (\Exception $e) {
            activity()
                ->performedOn($this->permissao)
                ->causedBy(Auth::user())
                ->withProperties($e)
                ->log($e->getMessage());

            return $this->redirectWithMessage('admin.home', 'error', '', MensagensEnum::THROW_EXECEPTION);
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        try{
            if (!$this->isAllowed('can-create-permissoes')) {
                return $this->redirectWhenNotAllowed('admin.home');
            }

            return view('admin.permissoes.create')->with([
                'model' => $this->permissao
            ]);
        } catch (\Exception $e) {
            activity()
                ->performedOn($this->permissao)
                ->causedBy(Auth::user())
                ->withProperties($e)
                ->log($e->getMessage());

            return $this->redirectWithMessage('admin.home', 'error', '', MensagensEnum::THROW_EXECEPTION);
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  PermissoesRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(PermissoesRequest $request)
    {
        try {
            if (!$this->isAllowed('can-create-permissoes')) {
                return $this->redirectWhenNotAllowed('admin.home');
            }

            $permissao = $this->permissao->create($request->all());

            if (!empty($permissao)) {
                $logedUser = Auth::user();
                activity('Permissão criada')
                    ->performedOn($permissao)
                    ->causedBy($logedUser)
                    ->withProperties($permissao)
                    ->log("Permissão criada por {$logedUser->name}");

                return $this->redirectWithMessage(
                    'admin.permissoes.edit',
                    'success',
                    '',
                    MensagensEnum::CREATED_ITEM,
                    $permissao->hash
                );
            }
        } catch (\Exception $e) {
            activity()
                ->performedOn($this->permissao)
                ->causedBy(Auth::user())
                ->withProperties($e)
                ->log($e->getMessage());

            return $this->redirectWithMessage('admin.home', 'error', '', MensagensEnum::THROW_EXECEPTION);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $hash
     * @return \Illuminate\Http\Response
     */
    public function edit($hash)
    {
        try {
            if (!$this->isAllowed('can-edit-permissoes')) {
                return $this->redirectWhenNotAllowed('admin.home');
            }

            $permissao = $this->permissao->where('hash', $hash)->first();

            if (empty($permissao)) {
                return $this->redirectWithMessage('admin.home', 'error', '', MensagensEnum::NOT_FOUND);
            }

            return view('admin.permissoes.edit')->with([
                'model' => $permissao
            ]);
        } catch (\Exception $e) {
            activity()
                ->performedOn($this->permissao)
                ->causedBy(Auth::user())
                ->withProperties($e)
                ->log($e->getMessage());

            return $this->redirectWithMessage('admin.home', 'error', '', MensagensEnum::THROW_EXECEPTION);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  PermissoesRequest  $request
     * @param  string  $hash
     * @return \Illuminate\Http\Response
     */
    public function update(PermissoesRequest $request, $hash)
    {
        try {
            if (!$this->isAllowed('can-edit-permissoes')) {
                return $this->redirectWhenNotAllowed('admin.home');
            }

            $permissao = $this->permissao->where('hash', $hash)->first();

            if (empty($permissao)) {
                return $this->redirectWithMessage('admin.home', 'error', '',
                    MensagensEnum::NOT_FOUND);
            }

            $permissao->update($request->all());

            $logedUser = Auth::user();
            activity('Permissão atualizada')
                ->performedOn($permissao)
                ->causedBy($logedUser)
                ->withProperties($permissao)
                ->log("Permissão atualizada por {$logedUser->name}");

            return $this->redirectWithMessage(
                'admin.permissoes.edit',
                'success',
                '',
                MensagensEnum::UPDATED_ITEM,
                $permissao->hash
            );
        } catch (\Exception $e) {
            activity()
                ->performedOn($this->permissao)
                ->causedBy(Auth::user())
                ->withProperties($e)
                ->log($e->getMessage());

            return $this->redirectWithMessage('admin.home', 'error', '', MensagensEnum::THROW_EXECEPTION);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  string  $hash
     * @return \Illuminate\Http\Response
     */
    public function destroy($hash)
    {
        try {
            if (!$this->isAllowed('can-delete-permissoes')) {
                return $this->redirectWhenNotAllowed('admin.home');
            }

            $permissao = $this->permissao->where('hash', $hash)->first();

            if (empty($permissao)) {
                return $this->redirectWithMessage('admin.home', 'error', '', MensagensEnum::NOT_FOUND);
            }

            $logedUser = Auth::user();
            activity('Permissão apagada')
                ->performedOn($permissao)
                ->causedBy($logedUser)
                ->withProperties($permissao)
                ->log("Permissão apagada por {$logedUser->name}");

            $permissao->delete();

            return $this->redirectWithMessage(
                'admin.permissoes.index',
                'success',
                '',
                MensagensEnum::DELETED_ITEM
            );
        } catch (\Exception $e) {
            activity()
                ->performedOn($this->permissao)
                ->causedBy(Auth::user())
                ->withProperties($e)
                ->log($e->getMessage());

            return $this->redirectWithMessage('admin.home', 'error', '', MensagensEnum::THROW_EXECEPTION);
        }
    }
}
