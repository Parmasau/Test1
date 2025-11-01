<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProductsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Product::create([
            'name' => 'Laptop',
            'description' => 'High-performance laptop',
            'price' => 999.99,
            'stock' => 10,
        ]);
        
        Product::create([
            'name' => 'Smartphone',
            'description' => 'Latest smartphone',
            'price' => 699.99,
            'stock' => 15,
        ]);

        // Optional: Add more sample products
        Product::create([
            'name' => 'Wireless Headphones',
            'description' => 'Noise-cancelling wireless headphones',
            'price' => 199.99,
            'stock' => 25,
        ]);

        Product::create([
            'name' => 'Tablet',
            'description' => '10-inch tablet with stylus',
            'price' => 449.99,
            'stock' => 8,
        ]);

        Product::create([
            'name' => 'Smart Watch',
            'description' => 'Fitness tracking smartwatch',
            'price' => 299.99,
            'stock' => 20,
        ]);
    }
}