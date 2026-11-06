<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::orderByDesc('id')->get();

        return view('products.index', compact('products'));
    }

    public function create()
    {
        return view('products.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:180',
            'game' => [
                'required',
                Rule::in([
                    'Mobile Legends',
                    'Free Fire',
                    'Genshin Impact',
                    'Valorant',
                ]),
            ],
            'rank_name' => 'required|string|max:100',
            'description' => 'required|string',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'rating' => 'required|numeric|min:0|max:9.9',
            'image_url' => 'required|string|max:600',
        ]);

        Product::create($validated);

        return redirect()
            ->route('products.index')
            ->with('success', 'Produk berhasil ditambahkan!');
    }

    public function edit(Product $product)
    {
        return view('products.edit', compact('product'));
    }

    public function update(Request $request, Product $product)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:180',
            'game' => [
                'required',
                Rule::in([
                    'Mobile Legends',
                    'Free Fire',
                    'Genshin Impact',
                    'Valorant',
                ]),
            ],
            'rank_name' => 'required|string|max:100',
            'description' => 'required|string',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'rating' => 'required|numeric|min:0|max:9.9',
            'image_url' => 'required|string|max:600',
        ]);

        $product->update($validated);

        return redirect()
            ->route('products.index')
            ->with('success', 'Produk berhasil diperbarui!');
    }

    
public function destroy(Product $product)
    {
        $product->delete();

        return redirect()
            ->route('products.index')
            ->with('success', 'Produk berhasil dihapus!');
    }

}