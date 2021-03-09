<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'confirmation_number' => $this->confirmation_number,
            'poster_image' => $this->posterUrl(),
            'brand' => $this->brand,
            'title' => $this->title,
            'price' => $this->price_in_wons,
            'discount_rate' => $this->discount_rate,
            'discount_price' => $this->discount_price,
            'capacity' => $this->capacity,
            'quantity' => $this->quantity,
            'delivery' => $this->delivery,
            'review_count' => $this->reviewCount(),
            'review_grade' => $this->review_grade,
        ];
    }
}
