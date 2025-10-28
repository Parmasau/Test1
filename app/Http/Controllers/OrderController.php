<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    // Show all orders
    public function index()
    {
        $orders = Order::with('product')->get();
        return view('orders.index', compact('orders'));
    }

    // Store a new order
    public function store(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1',
            'total_price' => 'required|numeric|min:0',
        ]);

        Order::create([
            'product_id' => $request->product_id,
            'quantity' => $request->quantity,
            'total_price' => $request->total_price,
        ]);

        return redirect()->route('orders.index')->with('success', 'Order placed successfully!');
    }

    // Show one order
    public function show(Order $order)
    {
        return view('orders.show', compact('order'));
    }

    // Other resource methods...
    public function create()
    {
        $products = Product::all();
        return view('orders.create', compact('products'));
    }

    public function edit(Order $order)
    {
        $products = Product::all();
        return view('orders.edit', compact('order', 'products'));
    }

    public function update(Request $request, Order $order)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1',
            'total_price' => 'required|numeric|min:0',
        ]);

        $order->update([
            'product_id' => $request->product_id,
            'quantity' => $request->quantity,
            'total_price' => $request->total_price,
        ]);

        return redirect()->route('orders.index')->with('success', 'Order updated successfully!');
    }

    public function destroy(Order $order)
    {
        $order->delete();
        return redirect()->route('orders.index')->with('success', 'Order deleted successfully!');
    }
}