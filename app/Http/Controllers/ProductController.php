<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Http\Requests\ProductRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $cacheKey = 'products_' . implode('_', $request->only(['name', 'min_price', 'max_price']));

        return Cache::remember($cacheKey, 60, function () use ($request) {
            return Product::query()
                ->when($request->name, fn($query) => $query->where('name', 'like', "%{$request->name}%"))
                ->when($request->min_price, fn($query) => $query->where('price', '>=', $request->min_price))
                ->when($request->max_price, fn($query) => $query->where('price', '<=', $request->max_price))
                ->paginate(10);
        });
    }

    public function store(ProductRequest $request)
    {
        $product = Product::create($request->validated());
        return response()->json($product, 201);
    }

    public function update(ProductRequest $request, Product $product)
    {
        $product->update($request->validated());
        return response()->json($product);
    }
}
