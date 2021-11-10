<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class Receita extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'cliente_id' => $this->cliente_id,
            'data' => $this->data,
            'total' => $this->total,
            'estado_receita' => $this->estado_receita,
            'medicamentos' => $this->medicamentos,
            'cliente' => $this->cliente,
            'farmaceutico' => $this->farmaceutico
        ];
    }
}
