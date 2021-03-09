<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\Review;
use App\Models\Product;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ReviewTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    function review_is_created_the_product_grade_is_updated()
    {
        $product = Product::factory()->create();

        Review::factory()->create(['grade' => 5, 'product_id' => $product->id]);
        $this->assertEquals(5, $product->fresh()->review_grade);

        Review::factory()->create(['grade' => 1, 'product_id' => $product->id]);
        $this->assertEquals(3, $product->fresh()->review_grade);
    }

    /** @test */
    function review_is_deleted_the_product_grade_is_updated()
    {
        $product = Product::factory()->create();
        $review1 = Review::factory()->create(['grade' => 5, 'product_id' => $product->id]);
        $review2 = Review::factory()->create(['grade' => 1, 'product_id' => $product->id]);
        $this->assertEquals(3, $product->fresh()->review_grade);

        $review2->delete();
        $this->assertEquals(5, $product->fresh()->review_grade);

        $review1->delete();
        $this->assertEquals(0, $product->fresh()->review_grade);
    }
}
