<?php

namespace App\Http\Controllers;

use App\Http\Resources\TicketResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TicketController extends Controller
{
    public function store(Request $request)
    {
        dd($request);
        // $ticket = DB::table('tabela_ingressos')->insert([
        //     'ingresso_id' => 1,
        //     'ingresso_codigo' => 'ABC123',
        //     'venda_pagamento_obs' => 'Observação de pagamento',
        //     'tipo_ingresso_id' => 2,
        //     'ingresso_data_emissao' => '2023-10-30',
        //     'ingresso_cod_barra' => '1234567890',
        //     'login' => 'usuariologin',
        //     'pdv_id' => 3,
        //     'evento_id' => 4,
        //     'ingresso_valor' => 50.00,
        //     'venda_id' => 5,
        //     'ingresso_forma_pagamento' => 'Cartão de Crédito',
        //     'ingresso_valor_pago' => 50.00,
        // ]);
        // dd($events );
        // return $ticket;
    }

    public function getTypeTickets(string $eventID)
    {
        // dd($eventID);
        $row = DB::table('grupo_ingresso')->where('evento_id', '=', $eventID)->get();
        return $row;
    }

    public function genTicket($saleId, $eventID, $tyTicketId, $typeTicketValue, $price, $login, $pdv, $codeTIcket)
    {
        return DB::table('ingresso')->insert([
            'ingresso_id' => DB::raw('nextval(\'gen_ingresso\')'),
            'ingresso_codigo' => $codeTIcket,
            'venda_pagamento_obs' => 'venda site',
            'tipo_ingresso_id' => $tyTicketId,
            'ingresso_data_emissao' => now(),
            'ingresso_cod_barra' => DB::raw('(select to_char(current_timestamp, \'MSDUSDd\'))'),
            'login' => $login,
            'pdv_id' => $pdv,
            'evento_id' => $eventID,
            'ingresso_valor' => $typeTicketValue,
            'venda_id' => $saleId,
            'ingresso_forma_pagamento' => '3',
            'ingresso_valor_pago' => $price,
        ]);
    }

    public function getTypeticketDesc(Request $request)
    {
        $gii = $request->input('grupo_ingresso_id');
        $tit = $request->input('tipo_ingresso_tipo');

        if (!$gii) {
            return response()->json(['message' => 'erro gii'], 400);
        }

        if (!$tit) {
            return response()->json(['message' => 'erro tit'], 400);
        }

        $groupTickets = DB::table('tipo_ingresso')
            ->where('grupo_ingresso_id', $gii)
            ->where('tipo_ingresso_tipo', 'LIKE', '%' . $tit . '%')
            ->get();

        return response()->json($groupTickets);
    }
}
