<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function reviews()
    {
        return $this->hasMany(Review::class);
    }

    public function getPriceInWonsAttribute()
    {
        return number_format($this->price);
    }

    public function getDiscountPriceAttribute()
    {
        return number_format(
            floor((((100 - $this->discount_rate) * 0.01) * $this->price) * 0.01) * 100
        );
    }

    public function reviewCount()
    {
        return $this->reviews()->count();
    }

    public function reviewGradeAverage()
    {
        return round($this->reviews()->pluck('grade')->average());
    }

    public function posterUrl()
    {
        return \Storage::disk('public')->url($this->poster_image_path);
    }
}
