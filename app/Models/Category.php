<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    protected $hidden = [
        'created_at',
        'updated_at',
        'category_id'
    ];

    /* public function categories()
    {
        return $this->hasMany(Category::class);
    }
 */
    public function categories()
    {
        return $this->hasMany(Category::class)->with('categories');
    }
}
