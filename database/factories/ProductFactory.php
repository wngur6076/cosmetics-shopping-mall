<?php

namespace Database\Factories;

use App\Models\Product;
use App\Models\RandomConfirmationNumberGenerator;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProductFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Product::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'confirmation_number' => (new RandomConfirmationNumberGenerator)->generate(),
            'poster_image_path' => 'posters/apple.jpg',
            'brand' => $this->faker->word,
            'title' => rtrim($this->faker->sentence(rand(2, 4)), "."),
            'price' => $this->faker->randomNumber(5),
            'discount_rate' => $this->faker->numberBetween(0, 100),
            'capacity' => $this->faker->randomElement(['용량 100ml', '용량 200ml', '용량 500ml']),
            'quantity' => $this->faker->numberBetween(1, 50),
            'delivery' => $this->faker->randomElement([0, 1, 2]),
        ];
    }
}
