<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;
use App\Models\Product;
use App\Models\User;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Seed categories and their products
        Category::factory()
            ->count(5)
            ->create()
            ->each(function ($category) {
                Product::factory()
                    ->count(10)
                    ->create(['category_id' => $category->id]);
            });

        // Seed 5 random users using factory
        User::factory()->count(5)->create();

        // Create specific admin user
        User::create([
            'name'     => 'Admin User',
            'email'    => 'admin@ecommerce.ps',
            'password' => bcrypt('admin123'),
            // 'is_admin' => true,   // Uncomment only if you added 'is_admin' column to users table
        ]);

        // Create your personal account
        User::create([
            'name'     => 'Izzdden S. R. Alnouno',
            'email'    => 'ie1@smail.ucas.edu.ps',
            'password' => bcrypt('password123'),
        ]);
    }
}
