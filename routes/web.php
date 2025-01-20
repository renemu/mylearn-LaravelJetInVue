<?php

use App\Http\Controllers\PageController;
use App\Http\Controllers\ProductController;
use App\Models\Product;
use App\Models\Page;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;


Route::prefix('/')->group(function () {
    Route::get('/', function () {
        return Inertia::render('Home', [
            // 'canLogin' => Route::has('login'),
            'product' => Product::all(),
            'pages' => Page::all()
        ]);
    })->name('home');
});

Route::middleware([
    'auth:sanctum',
    config(key: 'jetstream.auth_session'),
    'verified',
])->group(function () {
    // Dashboard Routes
    Route::get('admin/dashboard', function () {
        return Inertia::render('Dashboard');
    })->name('dashboard');

    // Product Routes
    Route::prefix('admin/product')->group(callback: function () {
        Route::get('/', [ProductController::class, 'index'])->name('products.index');
        Route::post('/', [ProductController::class, 'store'])->name('products.store');
        Route::get('/create', [ProductController::class, 'create'])->name('products.create');
        Route::get('/product-detail={product}', [ProductController::class, 'show'])->name('products.show');
        Route::get('/{product}/edit', [ProductController::class, 'edit'])->name('products.edit');
        Route::put('/{product}', [ProductController::class, 'update'])->name('products.update');
        Route::delete('/{product}', [ProductController::class, 'destroy'])->name('products.destroy');
    });

    // Pages Routes
    Route::prefix('admin/pages')->group(callback: function () {
        Route::get('/', [PageController::class, 'index'])->name('pages.index');
        Route::post('/', [PageController::class, 'store'])->name('pages.store');
        Route::get('/page-detail={page}', [PageController::class, 'show'])->name('pages.show');
        Route::put('/{page}', [PageController::class, 'update'])->name('pages.update');
    });

});
