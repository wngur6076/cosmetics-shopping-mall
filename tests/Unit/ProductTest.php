<?php

namespace Tests\Unit;

use App\Models\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ProductTest extends TestCase
{
    /** @test */
    public function can_get_price_in_wons()
    {
        $product = Product::factory()->make([
            'price' => 5000,
        ]);

        $this->assertEquals('5,000', $product->price_in_wons);
    }

    /** @test */
    public function can_get_delivery_chargee_in_wons()
    {
        $product = Product::factory()->make([
            'delivery_charge' => 2500,
        ]);

        $this->assertEquals('2,500', $product->delivery_charge_in_wons);
    }
}
