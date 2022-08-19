<?php

namespace App\Http\Controllers\Admin\Papeis;

use App\Entities\Papel;
use App\Entities\Permissao;
use App\Enums\MensagensEnum;
use App\Http\Requests\Admin\Papeis\PapeisRequest;
use App\Services\GatesTrait;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class PapeisController extends Controller
{
    // Trait criado para verificar permissões e retornar feedbacks
    use GatesTrait;

    private $papel;

    private $permissao;

    public function __construct(Papel $papel, Permissao $permissao)
    {
        $this->papel = $papel;
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
            if (!$this->isAllowed('can-access-papeis')) {
                return $this->redirectWhenNotAllowed('admin.home');
            }

            return view('admin.papeis.papeis')->with([
                'papeis' => $this->papel->orderBy('nome', 'ASC')->paginate(25)
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
            if (!$this->isAllowed('can-create-papeis')) {
                return $this->redirectWhenNotAllowed('admin.home');
            }

            return view('admin.papeis.create')->with([
                'model' => $this->papel,
                'permissoes' => $this->permissao->all()
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
     * @param  PapeisRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(PapeisRequest $request)
    {
        try {
            if (!$this->isAllowed('can-create-papeis')) {
                return $this->redirectWhenNotAllowed('admin.home');
            }

            $papel = $this->papel->create($request->all());
            $papel->permissoes()->sync($request->permissoes);

            $logedUser = Auth::user();
            activity('Papel criado')
                ->performedOn($papel)
                ->causedBy($logedUser)
                ->withProperties($papel)
                ->log("Papel criado por {$logedUser->name}");

            return $this->redirectWithMessage(
                'admin.papeis.edit',
                'success',
                '',
                MensagensEnum::CREATED_ITEM,
                $papel->hash
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
     * Show the form for editing the specified resource.
     *
     * @param  string  $hash
     * @return \Illuminate\Http\Response
     */
    public function edit($hash)
    {
        try {
            if (!$this->isAllowed('can-edit-papeis')) {
                return $this->redirectWhenNotAllowed('admin.home');
            }

            $papel = $this->papel->whereHash($hash)->first();

            if (empty($papel)) {
                return $this->redirectWithMessage('admin.home', 'error', '', MensagensEnum::NOT_FOUND);
            }

            return view('admin.papeis.edit')->with([
                'model' => $papel,
                'permissoes' => $this->permissao->all()
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
     * @param  PapeisRequest  $request
     * @param  string  $hash
     * @return \Illuminate\Http\Response
     */
    public function update(PapeisRequest $request, $hash)
    {
        try {
            if (!$this->isAllowed('can-edit-papeis')) {
                return $this->redirectWhenNotAllowed('admin.home');
            }

            $papel = $this->papel->whereHash($hash)->first();

            if (empty($papel)) {
                return $this->redirectWithMessage('admin.home', 'error', '', MensagensEnum::NOT_FOUND);
            }

            $papel->update($request->all());
            $papel->permissoes()->sync($request->permissoes);

            $logedUser = Auth::user();
            activity('Papel atualizado')
                ->performedOn($papel)
                ->causedBy($logedUser)
                ->withProperties($papel)
                ->log("Papel atualizado por {$logedUser->name}");

            return $this->redirectWithMessage(
                'admin.papeis.edit',
                'success',
                '',
                MensagensEnum::UPDATED_ITEM,
                $papel->hash
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
            if (!$this->isAllowed('can-delete-papeis')) {
                return $this->redirectWhenNotAllowed('admin.home');
            }

            $papel = $this->papel->whereHash($hash)->first();

            if (empty($papel)) {
                return $this->redirectWithMessage('admin.home', 'error', '', MensagensEnum::NOT_FOUND);
            }

            if ($papel->id === 1) {
                return $this->redirectWithMessage('admin.papeis.index', 'error', '', MensagensEnum::NOT_ALLOWED_TO_DELETE);
            }

            $logedUser = Auth::user();
            activity('Papel apagado')
                ->performedOn($papel)
                ->causedBy($logedUser)
                ->withProperties($papel)
                ->log("Papel apagado por {$logedUser->name}");

            $papel->delete();

            return $this->redirectWithMessage(
                'admin.papeis.index',
                'success',
                '',
                MensagensEnum::DELETED_ITEM,
                $papel->hash
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
