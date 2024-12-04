<?php

use App\Models\Product;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use Illuminate\Http\Request;

Route::post('products/create', function (Request $request) {
    $validated = $request->validate([
        'name' => 'required|string',
        'slug' => 'required|string',
    ]);

    // Add user_id to the validated array
    $validated['user_id'] = auth()->user()->id;

    $product_slug = $validated['slug'];

    Product::create($validated);

    return redirect()->route('products.show', [auth()->user()->id, $product_slug]);
})->name('products.create');

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        return Inertia::render('Dashboard');
    })->name('dashboard');
    Route::get('/dashboard', fn() => Inertia::render('Dashboard'))->name('dashboard');
    Route::get('/product', fn() => Inertia::render('Product'))->name('product');
});
