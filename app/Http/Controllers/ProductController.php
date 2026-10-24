<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    // Menampilkan daftar produk
    public function index(Request $request)
    {
        $search = $request->input('search');
        
        $products = Product::with('category')
            ->when($search, function ($query, $search) {
                return $query->where('name', 'like', "%{$search}%")
                             ->orWhere('sku', 'like', "%{$search}%");
            })
            ->paginate(10);

        return view('products.index', compact('products'));
    }

    // Menampilkan form tambah produk
    public function create()
    {
        $categories = Category::all();
        return view('products.create', compact('categories'));
    }

    // Menyimpan data produk baru
    public function store(Request $request)
    {
        $validated = $request->validate([
            'sku' => ['required', 'unique:products,sku'],
            'name' => ['required', 'max:150'],
            'category_id' => ['required', 'exists:categories,id'],
            'price' => ['required', 'numeric', 'min:0'],
            'stock' => ['required', 'integer', 'min:0'],
        ], [
            'sku.required' => 'Kolom SKU wajib diisi.',
            'sku.unique' => 'SKU ini sudah terdaftar.',
            'name.required' => 'Nama produk wajib diisi.',
            'category_id.required' => 'Kategori wajib dipilih.',
            'price.required' => 'Harga wajib diisi.',
            'stock.required' => 'Stok wajib diisi.',
        ]);

        Product::create($validated);

        return redirect()->route('products.index')->with('success', 'Produk berhasil ditambahkan!');
    }

    // Menampilkan form edit produk
    public function edit(Product $product)
    {
        $categories = Category::all();
        return view('products.edit', compact('product', 'categories'));
    }

    // Memproses update data produk
    public function update(Request $request, Product $product)
    {
        $validated = $request->validate([
            'sku' => ['required', 'unique:products,sku,' . $product->id],
            'name' => ['required', 'max:150'],
            'category_id' => ['required', 'exists:categories,id'],
            'price' => ['required', 'numeric', 'min:0'],
            'stock' => ['required', 'integer', 'min:0'],
        ], [
            'sku.required' => 'Kolom SKU wajib diisi.',
            'sku.unique' => 'SKU ini sudah terdaftar.',
            'name.required' => 'Nama produk wajib diisi.',
            'category_id.required' => 'Kategori wajib dipilih.',
            'price.required' => 'Harga wajib diisi.',
            'stock.required' => 'Stok wajib diisi.',
        ]);

        $product->update($validated);

        return redirect()->route('products.index')->with('success', 'Produk berhasil diperbarui!');
    }

    // Menghapus produk
    public function destroy(Product $product)
    {
        $product->delete();

        return redirect()->route('products.index')->with('success', 'Produk berhasil dihapus!');
    }
}