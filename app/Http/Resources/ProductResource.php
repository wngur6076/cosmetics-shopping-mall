<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'brand' => $this->brand,
            'title' => $this->title,
            'price' => $this->price_in_wons,
            'discount_rate' => $this->discount_rate,
            'capacity' => $this->capacity,
            'quantity' => $this->quantity,
            'delivery_charge' => $this->delivery_charge_in_wons,
        ];
    }
}
