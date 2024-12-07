<?php

namespace App\Http\Controllers;
use App\Models\Product;
use Inertia\Inertia;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

class ProductController extends Controller
{
    public function index()
    {
        $product = Product::all();

        return Inertia::render('Product', [
            'products' => $product
        ]);
    }
    public function create()
    {
        return Inertia::render('Prduct/Create');
    }
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required', // Sesuaikan dengan kebutuhan validasi
            'description' => 'required' // Ganti 'email' dengan field yang sesuai
        ]);

        // Buat produk
        $product = Product::create([
            'name' => $request->name, // Gunakan $request->name, bukan title
            'description' => $request->description // Gunakan field yang sesuai
        ]);

        if ($product) {
            return Redirect::route('products.index')->with('message', 'Data Berhasil Disimpan!');
        }

        // Tambahkan penanganan jika produk gagal dibuat
        return Redirect::back()->withErrors('Gagal menyimpan produk');
    }
}
