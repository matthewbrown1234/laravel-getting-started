<?php

namespace App\Http\Controllers;

use App\Models\OrderHistory;

class OrderHistoryController extends Controller
{
    public function list()
    {
        return OrderHistory::all();
    }
}
