<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\Review;
use App\Models\Product;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Mockery;

class ProductTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    function can_get_price_in_wons()
    {
        $product = Product::factory()->make([
            'price' => 5000,
        ]);

        $this->assertEquals('5,000', $product->price_in_wons);
    }

    /** @test */
    function can_get_discount_price()
    {
        $product = Product::factory()->make([
            'price' => 42000,
            'discount_rate' => 30
        ]);

        $this->assertEquals('29,400', $product->discount_price);
    }

    /** @test */
    function can_see_the_average_of_the_review_grades()
    {
        $product = Product::factory()->create();

        Review::factory()->create(['grade' => 5, 'product_id' => $product]);
        Review::factory()->create(['grade' => 4, 'product_id' => $product]);
        Review::factory()->create(['grade' => 1, 'product_id' => $product]);

        $this->assertEquals(3, $product->reviewGradeAverage());
    }
}
