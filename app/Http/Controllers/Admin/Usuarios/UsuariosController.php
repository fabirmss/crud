<?php

namespace App\Http\Controllers\Admin\Usuarios;

use App\Entities\Papel;
use App\Enums\MensagensEnum;
use App\Http\Requests\Admin\User\UserRequest;
use App\Http\Requests\Admin\User\AtualizarSenhaRequest;
use App\Services\GatesTrait;
use App\User;
use Carbon\Carbon;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class UsuariosController extends Controller
{
    use GatesTrait;

    private $user;

    private $papel;

    public function __construct(User $user, Papel $papel)
    {
        $this->user = $user;
        $this->papel = $papel;
    }


    public function index()
    {
        try {
            if (!$this->isAllowed('can-access-usuarios')) {
                return $this->redirectWhenNotAllowed('admin.home');
            }

            $user = User::orderBy('name', 'ASC')->get();

            return view('admin.usuarios.usuarios')->with([
                'usuarios' => $user
            ]);
        } catch (\Exception $e) {
            activity()
                ->performedOn($this->user)
                ->causedBy(Auth::user())
                ->withProperties($e)
                ->log($e->getMessage());

            return $this->redirectWithMessage('admin.home', 'error', '', MensagensEnum::THROW_EXECEPTION);
        }
    }

    public function create()
    {
        try {
            if (!$this->isAllowed('can-create-usuarios')) {
                return $this->redirectWhenNotAllowed('admin.home');
            }

            return view('admin.usuarios.create')->with([
                'model' => $this->user,
                'papeis' => $this->papel->orderBy('nome', 'ASC')->get()
            ]);
        } catch (\Exception $e) {
            activity()
                ->performedOn($this->user)
                ->causedBy(Auth::user())
                ->withProperties($e)
                ->log($e->getMessage());

            return $this->redirectWithMessage('admin.usuarios.index', 'error', '', MensagensEnum::THROW_EXECEPTION);
        }
    }


    public function store(UserRequest $request)
    {
        try {
            if (!$this->isAllowed('can-create-usuarios')) {
                return $this->redirectWhenNotAllowed('admin.home');
            }

            $new_request = $request->all();
            $new_request['email_verified_at'] = Carbon::now();

            $user = $this->user->create($new_request);

            if (empty($user)) {
                return $this->redirectWithMessage('admin.usuarios.index', 'error', '', MensagensEnum::NOT_FOUND);
            }

            $logedUser = Auth::user();
            activity('Usuário criado')
                ->performedOn($user)
                ->causedBy($logedUser)
                ->withProperties($user)
                ->log("Usuário criado por {$logedUser->name}");

            return $this->redirectWithMessage(
                'admin.usuarios.edit',
                'success',
                '',
                MensagensEnum::UPDATED_ITEM,
                $user->hash
            );
        } catch (\Exception $e) {
            activity()
                ->performedOn($this->user)
                ->causedBy(Auth::user())
                ->withProperties($e)
                ->log($e->getMessage());

            return $this->redirectWithMessage('admin.usuarios.index', 'error', '', MensagensEnum::THROW_EXECEPTION);
        }
    }


    public function edit($hash)
    {
        try {
            if (!$this->isAllowed('can-edit-usuarios')) {
                return $this->redirectWhenNotAllowed('admin.home');
            }

            $user = $this->user->where('hash', $hash)->first();

            if (empty($user)) {
                return $this->redirectWithMessage('admin.usuarios.index', 'error', '', MensagensEnum::NOT_FOUND);
            }

            return view('admin.usuarios.edit')->with([
                'model' => $user,
                'papeis' => $this->papel->orderBy('nome', 'ASC')->get()
            ]);
        } catch (\Exception $e) {
            activity()
                ->performedOn($this->user)
                ->causedBy(Auth::user())
                ->withProperties($e)
                ->log($e->getMessage());

            return $this->redirectWithMessage('admin.usuarios.index', 'error', '', MensagensEnum::THROW_EXECEPTION);
        }
    }


    public function update(UserRequest $request, $hash)
    {
        try {
            if (!$this->isAllowed('can-edit-usuarios')) {
                return $this->redirectWhenNotAllowed('admin.home');
            }

            $user = $this->user->where('hash', $hash)->first();

            if (empty($user)) {
                return $this->redirectWithMessage('admin.usuarios.index', 'error', '', MensagensEnum::NOT_FOUND);
            }

            $user->update($request->all());

            $logedUser = Auth::user();
            activity('Usuário atualizado')
                ->performedOn($user)
                ->causedBy($logedUser)
                ->withProperties($user)
                ->log("Usuário atualizado por {$logedUser->name}");

            return $this->redirectWithMessage(
                'admin.usuarios.edit',
                'success',
                '',
                MensagensEnum::UPDATED_ITEM,
                $user->hash
            );
        } catch (\Exception $e) {
            activity()
                ->performedOn($this->user)
                ->causedBy(Auth::user())
                ->withProperties($e)
                ->log($e->getMessage());

            return $this->redirectWithMessage('admin.usuarios.index', 'error', '', MensagensEnum::THROW_EXECEPTION);
        }
    }


    public function destroy($hash)
    {
        try {
            if (!$this->isAllowed('can-delete-usuarios')) {
                return $this->redirectWhenNotAllowed('admin.home');
            }

            $user = $this->user->where('hash', $hash)->first();

            if (empty($user)) {
                return $this->redirectWithMessage('admin.usuarios.index', 'error', '', MensagensEnum::NOT_FOUND);
            }

            if ($user->id === 1) {
                return $this->redirectWithMessage('admin.usuarios.index', 'error', '', MensagensEnum::NOT_ALLOWED_TO_DELETE);
            }

            $logedUser = Auth::user();
            activity('Usuário apagado')
                ->performedOn($user)
                ->causedBy($logedUser)
                ->withProperties($user)
                ->log("Usuário apagado por {$logedUser->name}");

            $user->delete();

            return $this->redirectWithMessage(
                'admin.usuarios.index',
                'success',
                '',
                MensagensEnum::DELETED_ITEM
            );
        } catch (\Exception $e) {
            activity()
                ->performedOn($this->user)
                ->causedBy(Auth::user())
                ->withProperties($e)
                ->log($e->getMessage());

            return $this->redirectWithMessage('admin.usuarios.index', 'error', '', MensagensEnum::THROW_EXECEPTION);
        }
    }

    public function updatePwd(AtualizarSenhaRequest $request)
    {
        try {
            if (!$this->isAllowed('can-edit-usuarios')) {
                return $this->redirectWhenNotAllowed('admin.home');
            }

            $user = $this->user->where('hash', $request->hash)->first();

            if (empty($user)) {
                return $this->redirectWithMessage('admin.usuarios.index', 'error', '', MensagensEnum::NOT_FOUND);
            }

            $user->update($request->all());

            $logedUser = Auth::user();
            activity('Senha alterada')
                ->performedOn($user)
                ->causedBy($logedUser)
                ->withProperties($user)
                ->log("Senha alterada por {$logedUser->name}");

            return $this->redirectWithMessage(
                'admin.usuarios.edit',
                'success',
                '',
                MensagensEnum::ADMIN_PWD_CHANGED,
                $user->hash
            );
        } catch (\Exception $e) {
            activity()
                ->performedOn($this->user)
                ->causedBy(Auth::user())
                ->withProperties($e)
                ->log($e->getMessage());

            return $this->redirectWithMessage('admin.home', 'error', '', MensagensEnum::THROW_EXECEPTION);
        }
    }
}
