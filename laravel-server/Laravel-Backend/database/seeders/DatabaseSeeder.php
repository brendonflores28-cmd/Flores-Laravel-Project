<?php

namespace Database\Seeders;

use App\Models\Address;
use App\Models\Category;
use App\Models\Order;
use App\Models\OrderProduct;
use App\Models\Product;
use App\Models\Review;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $categories = Category::factory(5)->create();

        $products = Product::factory(2000)
            ->recycle($categories)
            ->create();

        $users = User::factory(20)->create();

        $users->each(function ($user) {
            Address::factory(rand(1, 2))
                ->for($user)
                ->create();
        });

        $orders = $users->flatMap(function ($user) {
            return Order::factory(rand(0, 5))
                ->for($user)
                ->create();
        });

        $orders->each(function ($order) use ($products) {
            $orderProducts = $products->random(rand(1, 4));

            foreach ($orderProducts as $product) {
                OrderProduct::factory()
                    ->for($order)
                    ->for($product)
                    ->create();
            }
        });

        $products->each(function ($product) use ($users) {
            $reviewers = $users->random(rand(0, 8));

            foreach ($reviewers as $user) {
                Review::factory()
                    ->for($user)
                    ->for($product)
                    ->create();
            }
        });
    }
}
