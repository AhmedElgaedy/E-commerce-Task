<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Product;
use App\Http\Requests\OrderRequest;
use Illuminate\Http\Request;
use App\Events\OrderPlaced;

class OrderController extends Controller
{
    public function store(OrderRequest $request)
    {
        $validated = $request->validated();

        $order = Order::create([
            'user_id' => auth()->id(),
            'total_price' => $this->calculateTotal($validated['products']),
        ]);

        foreach ($validated['products'] as $productData) {
            $product = Product::find($productData['id']);
            $order->products()->attach($product->id, [
                'quantity' => $productData['quantity'],
                'price' => $product->price,
                'total' => $product->price * $productData['quantity'],
            ]);
        }

        event(new OrderPlaced($order));

        return response()->json($order, 201);
    }

    public function show($id)
    {
        $order = Order::with('products')->findOrFail($id);
        return response()->json($order);
    }

    protected function calculateTotal($products)
    {
        $total = 0;
        foreach ($products as $product) {
            $total += Product::find($product['id'])->price * $product['quantity'];
        }
        return $total;
    }
}
