<?php

namespace Database\Factories;

use App\Models\Category;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class ProductFactory extends Factory
{
    public function definition(): array
    {
        $name = $this->faker->words(rand(2, 6), true);

        return [
            'category_id'   => Category::factory(),
            'name'          => $name,
            'slug'          => Str::slug($name) . '-' . $this->faker->unique()->numberBetween(1000, 999999),
            'price'         => $this->faker->randomFloat(2, 4.99, 999.99),
            'description'   => $this->faker->realTextBetween(80, 300),
            'image'         => null,  // مؤقت – بنضيف رفع صور لاحقًا
            'stock'         => $this->faker->numberBetween(0, 150),
            'is_featured'   => $this->faker->boolean(20),
        ];
    }
}
