<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $products = [
            [
                'name' => 'Espresso',
                'description' => 'Strong and bold espresso shot',
                'price' => 120,
                'stock' => 10,
                'image' => 'espresso.jpg',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Cappuccino',
                'description' => 'Creamy coffee with steamed milk',
                'price' => 150,
                'stock' => 5,
                'image' => 'cappuccino.jpg',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Latte',
                'description' => 'Smooth coffee with lots of milk',
                'price' => 160,
                'stock' => 0,
                'image' => 'latte.jpg',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Mocha',
                'description' => 'Chocolate flavored coffee delight',
                'price' => 170,
                'stock' => 8,
                'image' => 'mocha.jpg',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Americano',
                'description' => 'Classic black coffee',
                'price' => 130,
                'stock' => 12,
                'image' => 'americano.jpg',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Macchiato',
                'description' => 'Espresso with a dash of milk',
                'price' => 140,
                'stock' => 3,
                'image' => 'macchiato.jpg',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        foreach ($products as $product) {
            Product::create($product);
        }

        $this->command->info('✅ Products seeded successfully!');
    }
}