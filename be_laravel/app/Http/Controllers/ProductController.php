<?php

namespace App\Http\Controllers;

use App\Http\Requests\InsertProductRequest;
use App\Http\Requests\ProductRequest;
use App\Http\Requests\UpdateProductRequest;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{

    public function insert(InsertProductRequest $request){
        $product = new Product();
        $product->name = $request->name;
        $product->price = $request->price;
        $product->status = true;
        $product->description = $request->description;
        $product->created_by = auth()->id();
        $product->created_at = now();
        $product->save();

        return redirect()->route('products.index')->with('success', 'Produk berhasil disimpan!');
    }

    public function dashboard(ProductRequest $request)
    {
        $query = Product::query();

        // 🔍 GLOBAL SEARCH (name + description)
        if ($request->filled('search')) {
            $search = $request->search;

            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('description', 'like', "%{$search}%");
            });
        }

        // 🔍 FILTER price (optional kalau mau tetap ada)
        if ($request->filled('price')) {
            $query->where('price', $request->price);
        }

        // 🔍 FILTER status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $perPage = $request->pagination ?? 10;

        $products = $query->latest()->paginate($perPage);

        return view('dashboard', compact('products'));
    }

    public function update(UpdateProductRequest $request, $id)
    {
        $product = Product::findOrFail($id);

        $product->update([
            'name' => $request->name,
            'price' => $request->price,
            'status' => $request->status,
            'description' => $request->description,
        ]);

        return redirect()
            ->route('dashboard')
            ->with('success', 'Product berhasil diupdate');
    }

    public function delete($id)
    {
        $product = Product::findOrFail($id);

        if(!$product){
            return redirect()
            ->route('dashboard')
            ->with('warning', 'Produk Tidak Ditemukan');
        }

        $product->update([
            'status' => false,
        ]);

        return redirect()
            ->route('dashboard')
            ->with('success', 'Product berhasil di hapus');
    }

}
