<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    public function run()
    {
        $products = [
            [
                'name' => 'Chester',
                'price' => 20000,
                'description' => 'Makanan Kucing 1kg'
            ],
            [
                'name' => 'Chat Choice',
                'price' => 25000,
                'description' => 'Makanan kucing untuk kitten & adult (1kg & 800g)'
            ],
            [
                'name' => 'Product 3',
                'price' => 300000,
                'description' => 'Description for product 3'
            ],
        ];

        foreach ($products as $product) {
            Product::create($product);
        }
    }
}