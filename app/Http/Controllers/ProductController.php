<?php

namespace App\Http\Controllers;
use App\Models\Product;
// use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function products()
    {
        return $this->hadMany(Product::class);
    }
}
