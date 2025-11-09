<?php

use App\Http\Repository\OrderHistoryRepository;
use App\Integrations\Ecom\Product;
use App\Models\OrderHistory;
use App\Services\ExternalApiClient;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use Laravel\Fortify\Features;

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canRegister' => Features::enabled(Features::registration()),
    ]);
})->name('home');

Route::get('dashboard', function () {
    $fakestoreapi = new ExternalApiClient('https://fakestoreapi.com/');
    $products = Product::collect($fakestoreapi->get('/products'));
    $maybeOrderHistory = null;
    try {
        $maybeOrderHistory = (new OrderHistoryRepository)->findById(5);
    } catch (Exception $e) {
        $maybeOrderHistory = null;
    }

    return Inertia::render('Dashboard', [
        'products' => $products,
        'orderHistory' => OrderHistory::all(),
        'singleOrderHistory' => $maybeOrderHistory,
    ]);
})->middleware(['auth', 'verified'])->name('dashboard');

require __DIR__.'/settings.php';
