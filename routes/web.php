<?php

use App\Integrations\Ecom\Product;
use App\Models\OrderItem;
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

    return Inertia::render('Dashboard', [
        'products' => $products,
        'orderItems' => OrderItem::all(),
    ]);
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::resource('orders', 'App\Http\Controllers\OrderController');
});

require __DIR__.'/settings.php';
