<?php

namespace Database\Factories;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Product>
 */
class ProductFactory extends Factory
{
    protected $model = Product::class;
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->words(3, true),
            'category_id' => Category::factory(),
            'price' => $this->faker->randomFloat(2, 10, 500),
            'image' => $this->faker->imageUrl(640, 480, 'products', true),
            'quantity' => $this->faker->numberBetween(1, 100),
            'views' => $this->faker->numberBetween(0, 1000),
            'description' => $this->faker->paragraph(),
            'rating' => $this->faker->randomFloat(1, 0, 5),
            'status' => $this->faker->randomElement(['in stock', 'out of stock', 'coming soon']),
            'discount_price' => $this->faker->optional()->randomFloat(2, 5, 300),
            'import_price' => $this->faker->optional()->randomFloat(2, 5, 400),
        ];
    }
}
