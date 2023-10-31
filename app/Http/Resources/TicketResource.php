<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class TicketResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        // dd($request);

        return [
            'eventID' => $this->eventID,
            'pdv' => $this->pdv,
            'login' => $this->login,
            'tipoIngressoId' => $this->tipoIngressoId,
            'var_tipo_ingresso_valor' => $this->var_tipo_ingresso_valor,
            'ingresso_codigo' => $this->ingresso_codigo,
            'vendaId' => $this->vendaId,
            'preco' => $this->preco,
        ];
    }
}
