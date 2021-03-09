<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Product;
use App\Models\Review;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        foreach (config('project.category') as $i => $name) {
            $category = Category::create(['name' => is_numeric($i) ? $name: $i]);
            if (!is_numeric($i)) {
                foreach ($name as $i => $name2) {
                    $category2 = $category->categories()->create(['name' => is_numeric($i) ? $name2: $i]);
                    if (!is_numeric($i)) {
                        foreach ($name2 as $i => $name3) {
                            $category3 = $category2->categories()->create(['name' => is_numeric($i) ? $name3: $i]);
                        }
                    }
                }
            }
        }

        Product::factory(10)->create()->each(function ($p) {
            $p->reviews()->saveMany(
                Review::factory(rand(1, 10))->make(['product_id' => $p->id])
            );
        });
    }
}
