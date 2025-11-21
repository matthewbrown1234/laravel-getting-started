<?php

namespace App\Http\Controllers;

use App\Models\OrderHistory;
use Inertia\Inertia;

// todo: switch to resource model?
class OrderHistoryController extends Controller
{
    public function list()
    {
        return Inertia::render('order-history/List', [
            'orderHistoryList' => OrderHistory::with('user')->get(),
        ]);
    }
}
