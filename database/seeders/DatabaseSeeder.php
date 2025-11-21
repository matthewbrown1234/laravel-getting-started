<?php

namespace Database\Seeders;

use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $orders = Order::factory(100)->create();
        foreach ($orders as $order) {
            OrderItem::factory(
                rand(1, 10)
            )->create([
                'order_id' => $order->id,
            ]);
        }
    }

}
