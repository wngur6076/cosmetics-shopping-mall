<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    public function getPriceInWonsAttribute()
    {
        return number_format($this->price);
    }

    public function getDeliveryChargeInWonsAttribute()
    {
        return number_format($this->delivery_charge);
    }
}
