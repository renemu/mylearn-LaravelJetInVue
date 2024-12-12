<?php

namespace App\Http\Controllers;
use App\Models\Product;
use Inertia\Inertia;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Menampilkan daftar produk
     */
    public function index()
    {
        // Ambil semua produk dari database
        $products = Product::all();

        // Render halaman produk menggunakan Inertia
        return Inertia::render('Product', [
            'products' => $products
        ]);
    }

    /**
     * Menyimpan produk baru
     */
    public function store(Request $request)
    {
        // Validasi input
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0'
        ]);

        // Buat produk baru
        $product = Product::create($validatedData);

        // Kembalikan produk yang baru dibuat
        return back()->with([
            'products' => $product,
            'success' => 'Produk berhasil ditambahkan'
        ]);
    }

    /**
     * Menampilkan form tambah produk (opsional)
     */
    public function create()
    {
        return Inertia::render('Product/Create');
    }

    /**
     * Menampilkan detail produk (opsional)
     */
    public function show(Product $product)
    {
        return Inertia::render('Product/Show', [
            'product' => $product
        ]);
    }

    /**
     * Menampilkan form edit produk (opsional)
     */
    public function edit(Product $product)
    {
        return Inertia::render('Product/Edit', [
            'product' => $product
        ]);
    }

    /**
     * Memperbarui produk (opsional)
     */
    public function update(Request $request, Product $product)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0'
        ]);

        $product->update($validatedData);

        return redirect()->route('products.index')->with('success', 'Produk berhasil diperbarui');
    }

    /**
     * Menghapus produk (opsional)
     */
    public function destroy(Product $product)
    {
        $product->delete();

        return redirect()->route('products.index')->with('success', 'Produk berhasil dihapus');
    }
}
