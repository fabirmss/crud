<?php

namespace App\Http\Controllers\Auth;

use App\Enums\MensagensEnum;
use App\Http\Controllers\Controller;
use App\Services\FeedbacksTrait;
use App\User;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Lang;
use Illuminate\Validation\ValidationException;

class LoginController extends Controller
{
    use FeedbacksTrait;
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/admin/dashboard';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    /**
     * Redirect the user after determining they are locked out.
     *
     * @return void
     */
    protected function sendLockoutResponse()
    {
        throw ValidationException::withMessages([
            $this->username() => [Lang::get('auth.throttle', ['seconds' => 120])],
        ])->status(423);
    }

    /**
     * Determine if the user has too many failed login attempts.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return bool
     */
    protected function hasTooManyLoginAttempts(Request $request)
    {
        return $this->limiter()->tooManyAttempts(
            $this->throttleKey($request),
            2
        );
    }

    /**
     * Altera a função de login padrão do Laravel,
     * me permitindo bloquear após várias tentativas de login
     * e exibir mensagens de boas vindas
     *
     * @param Request $request
     *
     * @return mixed
     * @throws ValidationException
     */
    public function login(Request $request)
    {
        $this->validateLogin($request);

        if ($this->hasTooManyLoginAttempts($request)) {
            $this->fireLockoutEvent($request);
            return $this->sendLockoutResponse();
        }

        if(!empty($request->email)) {
            if(User::whereEmail($request->email)->get()->isEmpty()) {
                $this->incrementLoginAttempts($request);

                return $this->redirectWithMessage('login', 'error', '', MensagensEnum::USUARIO_NAO_ENCONTRADO);
            }
        }

        if ($this->attemptLogin($request)) {
            // Verifica se a conta está inativa no admin
            // Se estiver realiza o logout do usuário
            // e bloqueia o acesso
            if (!$this->guard()->getLastAttempted()->ativo) {
                Auth::logout();

                return $this->redirectWithMessage(
                    'login',
                    'error',
                    'Conta inativa',
                    MensagensEnum::DISABLED_ACCOUNT
                );
            }

            $userName = ucwords(strtolower(explode(' ', trim($this->guard()->getLastAttempted()->name))[0]));
            $appName = config('app.name');

            return $this->sendLoginResponse($request)->with([
                'notify' => [
                    'type' => 'success',
                    'title' => "Olá {$userName}",
                    'message' => "Bem vindo ao {$appName}."
                ]
            ]);
        }

        return $this->sendFailedLoginResponse($request);
    }
}
