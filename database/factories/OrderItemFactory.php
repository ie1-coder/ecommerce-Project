<?php

namespace Database\Factories;

use App\Models\Category;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class ProductFactory extends Factory
{
    public function definition(): array
    {
        return [
            'category_id' => Category::factory(),
            'name' => $this->faker->words(3, true),
            'slug' => Str::slug($this->faker->words(3, true)),
            'price' => $this->faker->randomFloat(2, 10, 500),
            'description' => $this->faker->paragraph(),
            'image' => 'products/default.jpg', 
            'stock' => $this->faker->numberBetween(0, 100),
            'is_featured' => $this->faker->boolean(20),
        ];
    }
}
