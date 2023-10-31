<?php

namespace App\Http\Controllers;

use App\Http\Resources\EventoResource;
use App\Models\Evento;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class EventoController extends Controller
{
    public function index()
    {
        // Consulta para recuperar todos os produtos da tabela "produtos"
        $events = DB::table('evento')->where('evento_status', '=', 1)->get();
        // dd($events );
        return $events;


        // try {
        //     $pdo = DB::connection()->getPdo();
        //     // A conexão foi bem-sucedida, você pode executar consultas aqui
        //     echo "Conexão bem-sucedida!";
        // } catch (\Exception $e) {
        //     // A conexão falhou, lide com o erro
        //     echo "Erro na conexão: " . $e->getMessage();
        // }
    }
}
