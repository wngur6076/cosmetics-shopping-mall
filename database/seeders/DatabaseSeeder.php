<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\Review;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        Product::factory(50)->create()->each(function ($p) {
            $p->reviews()->saveMany(
                Review::factory(rand(1, 10))->make(['product_id' => $p->id])
            );
        });
    }
}
