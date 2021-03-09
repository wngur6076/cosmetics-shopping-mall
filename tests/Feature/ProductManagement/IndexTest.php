<?php

namespace Tests\Feature\CosmeticManagement;

use Mockery;
use Tests\TestCase;
use App\Models\Review;
use App\Models\Product;
use App\Models\ConfirmationNumberGenerator;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class IndexTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    function user_can_view_the_product_list_in_detail()
    {
        $this->withoutExceptionHandling();
        $product = Product::factory()->create([
            'confirmation_number' => 'PRODUCTCONFIRMATION1234',
            'brand' => 'TONYMOLY',
            'title' => 'Test',
            'price' => 56000,
            'discount_rate' => 56,
            'capacity' => '용량 200ml',
            'quantity' => 3,
            'delivery' => 0,
        ]);
        Review::factory()->create(['grade' => 5, 'product_id' => $product->id]);
        Review::factory()->create(['grade' => 3, 'product_id' => $product->id]);

        $response = $this->json('GET', '/api/products');

        $response->assertStatus(200)
            ->assertJson(['data' => [
                [
                    'confirmation_number' => 'PRODUCTCONFIRMATION1234',
                    'poster_image' => config('app.url').'/storage/posters/apple.jpg',
                    'brand' => 'TONYMOLY',
                    'title' => 'Test',
                    'price'=> '56,000',
                    'discount_rate' => 56,
                    'discount_price' => '24,600',
                    'capacity' => '용량 200ml',
                    'quantity' => 3,
                    'delivery' => 0,
                    'review_count' => 2,
                    'review_grade' => 4,
                ]
            ]]);
    }

    /** @test */
    function user_can_view_a_product_listing()
    {
        Product::factory(3)->create();

        $response = $this->json('GET', '/api/products');

        $response->assertStatus(200)
            ->assertJsonStructure([
                'data' => [
                    '*' => ['confirmation_number', 'brand', 'title', 'price', 'discount_rate', 'discount_price',
                        'capacity', 'quantity', 'delivery', 'review_count', 'review_grade', 'poster_image']
                ],
                'links' => ['first', 'last', 'prev', 'next'],
                'meta' => [
                    'current_page', 'last_page', 'from', 'to', 'path', 'per_page', 'total'
                ],
            ]);
    }

    /** @test */
    function user_can_select_number_of_pagination()
    {
        for ($i = 0; $i < 20; $i++) {
            Product::factory()->create(['title' => 'Product '.$i]);
        }

        $response = $this->json('GET', '/api/products?per_page=10');
        $response->assertJsonCount(10, 'data');

        $response = $this->json('GET', '/api/products?per_page=20');
        $response->assertJsonCount(20, 'data');
    }

    /** @test */
    function pagination_for_products_works()
    {
        //  1페이지
        for ($i = 0; $i < 10; $i++) {
            Product::factory()->create(['title' => 'Product '.$i]);
        }

        // 2페이지
        for ($i = 10; $i < 20; $i++) {
            Product::factory()->create(['title' => 'Product '.$i]);
        }
        $response = $this->json('GET', '/api/products?per_page=10');

        $response->assertJsonFragment(['title' => 'Product 0']);
        $response->assertJsonFragment(['title' => 'Product 9']);

        $response = $this->json('GET', '/api/products?page=2&per_page=10');

        $response->assertJsonFragment(['title' => 'Product 10']);
        $response->assertJsonFragment(['title' => 'Product 19']);
    }

    /** @test */
    function sort_price_low_to_high()
    {
        Product::factory()->create([
            'title' => 'Product Middle',
            'price' => 15000,
        ]);
        Product::factory()->create([
            'title' => 'Product Low',
            'price' => 10000,
        ]);
        Product::factory()->create([
            'title' => 'Product High',
            'price' => 20000,
        ]);

        $response = $this->json('GET', '/api/products?sort=price&order=asc');

        $response->assertSeeInOrder(['Product Low', 'Product Middle', 'Product High']);
    }

    /** @test */
    function sort_price_high_to_low()
    {
        Product::factory()->create([
            'title' => 'Product Middle',
            'price' => 15000,
        ]);
        Product::factory()->create([
            'title' => 'Product Low',
            'price' => 10000,
        ]);
        Product::factory()->create([
            'title' => 'Product High',
            'price' => 20000,
        ]);

        $response = $this->json('GET', '/api/products?sort=price&order=desc');

        $response->assertSeeInOrder(['Product High', 'Product Middle', 'Product Low']);
    }
}
