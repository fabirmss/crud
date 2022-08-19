<?php

namespace App\Http\Controllers\Admin\Dashboard;

use App\Calendario;
use App\Empresa;
use App\Enums\MensagensEnum;
use App\Escala;
use App\Especialidade;
use App\Http\Controllers\Controller;
use App\Medico;
use App\Periodo;
use App\Services\FeedbacksTrait;
use App\Servico;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

date_default_timezone_set('America/Porto_Velho');

class DashboardController extends Controller
{
    use FeedbacksTrait;

    public function dashboard()
    {
        return view('admin.dashboard.dashboard');
    }

    public function calendar()
    {
        $especialidades = Especialidade::all();
        $servicos = Servico::all();
        $events = Calendario::orderBy('inicio', 'DESC')->get()->map(static function ($event) {
            return [
                'title' => $event->nome,
                'start' => !empty($event->inicio) ? $event->inicio->format('Y-m-d\TH:i:s') : null,
                'end' => !empty($event->fim) ? $event->fim->format('Y-m-d\TH:i:s') : null,
            ];
        })->toArray();

        return view('admin.dashboard.calendar', ['events' => $events,
            "especialidades"=>$especialidades, "servicos"=>$servicos]);
    }


}
