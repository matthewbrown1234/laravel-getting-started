<?php

namespace App\Http\Repository;

use App\Models\OrderHistory;

class OrderHistoryRepository
{
    public function findById(int $id): OrderHistory
    {
        return OrderHistory::all()->findOrFail($id);
    }

}
