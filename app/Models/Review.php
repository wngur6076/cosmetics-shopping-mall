<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    use HasFactory;

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public static function boot()
    {
        parent::boot();

        static::created(function($review) {
            $review->product->update(['review_grade' => $review->product->reviewGradeAverage()]);
        });

        static::deleted(function($review) {
            $review->product->update(['review_grade' => $review->product->reviewGradeAverage()]);
        });
    }
}
