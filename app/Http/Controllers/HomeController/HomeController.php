<?php

namespace App\Http\Controllers\HomeController;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

/**
 * Class HomeController
 *
 * @package App\Http\Controllers\HomeController
 */
class HomeController extends Controller
{
    /**
     * Retorna a view da tela inicial do sistema
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function home()
    {
        // No laravel você quando você chama a função view(), por padrão
        // ele já pega o caminho inicial (resources/views/).
        // A partir desse ponto é só você informar qual o nome da pasta e
        // qual o nome do arquivo que você quer carregar.
        // Pode ser utilizado o . (ponto) ou a / (barra)
        return view('auth.login');
    }
}
