<?php
// php artisan make:resource USerResource
namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class USerResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'idUser' => $this->idUser,
            'name' => $this->name,
            'phone' => $this->phone,
        ];
    }
}
