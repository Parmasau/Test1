<?php
// database/seeders/DatabaseSeeder.php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Product;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        // Create a test user if not exists
        $user = User::firstOrCreate(
            ['email' => 'test@example.com'],
            [
                'name' => 'Test User',
                'password' => bcrypt('password'),
                'role' => 'user', // Add the role field
                'location' => 'New York', // Add the location field
            ]
        );

        // Create sample products
        Product::firstOrCreate(
            ['name' => 'Laptop'],
            [
                'description' => 'High-performance laptop with 16GB RAM and 512GB SSD',
                'price' => 999.99,
                'stock' => 10,
            ]
        );

        Product::firstOrCreate(
            ['name' => 'Smartphone'],
            [
                'description' => 'Latest smartphone with 5G and advanced camera',
                'price' => 699.99,
                'stock' => 15,
            ]
        );

        Product::firstOrCreate(
            ['name' => 'Headphones'],
            [
                'description' => 'Wireless noise-cancelling headphones',
                'price' => 199.99,
                'stock' => 20,
            ]
        );

        Product::firstOrCreate(
            ['name' => 'Tablet'],
            [
                'description' => '10-inch tablet with stylus support',
                'price' => 449.99,
                'stock' => 8,
            ]
        );

        $this->command->info('Sample data seeded successfully!');
        $this->command->info('Test user: test@example.com / password');
    }
}