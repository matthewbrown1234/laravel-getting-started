<?php

namespace Database\Seeders;

use App\Models\OrderHistory;
use App\Models\OrderHistoryItem;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $orderHistoryList = OrderHistory::factory(10)->create();
        foreach ($orderHistoryList as $orderHistory) {
            OrderHistoryItem::factory(
                rand(1, 10)
            )->create([
                'order_history_id' => $orderHistory->id,
            ]);
        }
    }

}
