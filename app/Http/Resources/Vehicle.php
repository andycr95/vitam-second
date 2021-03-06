<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class Vehicle extends JsonResource
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
            'placa' => $this->placa,
            'model' => $this->model,
            'color' => $this->color,
            'motor' => $this->motor,
            'chasis' => $this->chasis,
        ];
    }
}
