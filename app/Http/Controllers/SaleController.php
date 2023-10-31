<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\TicketController;

class SaleController extends Controller
{
    protected $ticketController;

    public function __construct(TicketController $ticketController)
    {
        $this->ticketController = $ticketController;
    }

    public function index()
    {
        $events = DB::table('venda')->where('evento_status', '=', 1)->get();
        // dd($events );
        return $events;
    }

    public function generateSale(Request $request)
    {
        // dd($request);

        $tipoIngressoId = $request->tipoIngressoId;
        $clientID = $request->clientID;
        $eventID = $request->eventID;
        $pdv_id = 141;
        $login = 'admin';
        $typeTicketValue = 70;
        $codeTicket = 886644882;

        $ticketValues = DB::table('tipo_ingresso')
            ->select('*')
            ->where('tipo_ingresso_id', $tipoIngressoId)
            ->first(); // Use "first" para obter apenas o primeiro resultado

        if (!$ticketValues || !$ticketValues->tipo_ingresso_id) {
            return response()->json(['message' => 'Erro ticketValues'], 400);
        }


        $vendaID  = DB::select(DB::raw("SELECT nextval('gen_venda')"))[0]->nextval;

        DB::table('venda')->insert([
            'venda_id' => $vendaID,
            'cliente_id' => $clientID,
            'venda_data_hora' => now(), // Para usar a data/hora atual, você pode usar a função now()
            'venda_status' => 0,
            'pdv_id' => $pdv_id,
            'login' => 'admin',
            'tipo_retirada_id' => 9,
        ]);

        DB::table('venda_pagamento')->insert([
            'venda_pagamento_id' => DB::raw('nextval(\'gen_venda_pagamento\')'),
            'venda_id' => $vendaID,
            'venda_pagamento_status' => 3,
            'venda_pagamento_data_pago' => now(),
            'venda_pagamento_chave' => 8866471219,
            'venda_pagamento_valor' => 120,
            'forma_pagamento_id' => 3,
        ]);

        DB::table('venda_itens')->insert([
            'venda_itens_id' => DB::raw('nextval(\'gen_venda_itens\')'),
            'tipo_ingresso_id' => $ticketValues->tipo_ingresso_id,
            'venda_id' => $vendaID,
        ]);

        $key = 'bRuD5WYw5wd0rdHR9yLlM6wt2vteuiniQBqE70nAuhU=';

        //function my_encrypt($data, $key) {
        // Remove the base64 encoding from our key
        $encryption_key = base64_decode($key);
        // Generate an initialization vector
        $iv = openssl_random_pseudo_bytes(openssl_cipher_iv_length('aes-256-cbc'));
        // Encrypt the data using AES 256 encryption in CBC mode using our encryption key and initialization vector.
        $encrypted = openssl_encrypt($vendaID, 'aes-256-cbc', $encryption_key, 0, "254f830c42c937fb");
        // The $iv is just as important as the key for decrypting, so save it with our encrypted data using a unique separator (::)
        $venda_id_cifrado = base64_encode($encrypted . '::' . $iv);

        $urlVoucher = 'https://ticketsimples.com/loja/voucher_multi_seg.php?id=' . $venda_id_cifrado;


        $res = $this->ticketController->genTicket($vendaID, $eventID, $tipoIngressoId, $typeTicketValue, $typeTicketValue, $login, $pdv_id, $codeTicket);
        return response()->json(['message' => 'Ok', 'saleID' => $vendaID, 'urlVoucher' => $urlVoucher], 200);;
    }

    public function ticketsUser(Request $request)
    {
        $clientID = $request->input('clientID');

        if (!$clientID) {
            return response()->json(['message' => 'erro clientID'], 400);
        }

        $resDB = DB::table('venda')
            ->where('cliente_id', $clientID)
            ->get();

        return response()->json($resDB);
    }

    public function removeSale(Request $request)
    {
        $saleID = $request->input('saleID');

        if (!$saleID) {
            return response()->json(['message' => 'erro saleID'], 400);
        }

        // Execute as consultas DELETE usando o Query Builder do Laravel
        DB::table('venda_itens')->where('venda_id', $saleID)->delete();
        DB::table('venda_pagamento')->where('venda_id', $saleID)->delete();
        DB::table('ingresso')->where('venda_id', $saleID)->delete();
        DB::table('venda')->where('venda_id', $saleID)->delete();

        return response()->json(['message' => 'Itens da venda excluídos com sucesso'], 200);
    }
}
