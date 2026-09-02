<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class ProductFactory extends Factory
{
    public function definition(): array
    {
        $categories = [
            'Hardware',
            'Electrical',
            'Plumbing'
        ];

        $products = [
            [
                'category' => $categories[0],
                'name' => 'hammer',
                'price' => 250,
            ],
            [
                'category' => $categories[1],
                'name' => 'extension wire',
                'price' => 450,
            ],
            [
                'category' => $categories[2],
                'name' => 'water pipe',
                'price' => 180,
            ],
        ];

        $product = $this->faker->randomElement($products);

        $name = ucwords(
            strtolower(
                trim($product['name'])
            )
        );

        return [
            'name' => $name,
            'slug' => Str::slug($name) . '-' . $this->faker->unique()->numberBetween(1, 10000),
            'category' => ucwords(
                strtolower(
                    trim($product['category'])
                )
            ),
            'price' => $product['price'],
            'quantity' => $this->faker->numberBetween(1, 100),
            'status' => 'Available',
        ];
    }
}
