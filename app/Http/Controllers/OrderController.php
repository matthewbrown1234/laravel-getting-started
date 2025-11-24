<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderStatus;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Inertia\Inertia;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Order::query()->with('user');

        if ($request->has('sort')) {
            $sortArray = json_decode($request->sort, true);
            if (is_array($sortArray)) {
                foreach ($sortArray as $sortOption) {
                    $col = $sortOption['col'] ?? null;
                    $dir = $sortOption['dir'] ?? null;
                    if ($dir && in_array($col, ['order_date', 'status']) && in_array(strtolower($dir), ['asc', 'desc'])) {
                        $query->orderBy($col, $dir);
                    }
                }
            }
        }

        return Inertia::render('orders/Index', [
            'paginatedOrders' => fn () => $query->
                paginate(request()->per_page ?? 100, ['*'], 'page', request()->page ?? 1),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Order $order)
    {
        return Inertia::render('orders/Edit', [
            'order' => $order->load('user'),
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Order $order)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Order $order)
    {
        if ($order->status === OrderStatus::Shipped && $request->input('status') === OrderStatus::Canceled->value) {
            throw ValidationException::withMessages([
                'error' => ['Cannot cancel a shipped order'],
            ]);
        }

        $validated = $request->validate([
            'status' => ['required', 'string', 'in:pending,shipped,completed,canceled'],
        ]);

        $order->update($validated);

        return redirect()->back()->with('success', 'Order status updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Order $order)
    {
        //
    }
}
