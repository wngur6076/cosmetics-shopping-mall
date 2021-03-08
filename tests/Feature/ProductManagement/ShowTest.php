<?php

namespace Tests\Feature\CosmeticManagement;

use App\Models\Product;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ShowTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    function show_a_valid_product()
    {
        $this->withoutExceptionHandling();
        $product = Product::factory()->create([
            'brand' => 'TONYMOLY',
            'title' => 'Test',
            'price' => 56000,
            'discount_rate' => 56,
            'capacity' => '용량 200ml',
            'quantity' => 3,
            'delivery' => 1,
        ]);

        $response = $this->json('GET', '/api/products/'.$product->id)
            ->assertStatus(200);

        $response->assertJson([
            'brand' => 'TONYMOLY',
            'title' => 'Test',
            'price'=> '56,000',
            'discount_rate' => 56,
            'discount_price' => '24,600',
            'capacity' => '용량 200ml',
            'quantity' => 3,
            'delivery' => 1,
        ]);
    }
}
