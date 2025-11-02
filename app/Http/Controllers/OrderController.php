<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    /**
     * Show all orders for admin
     */
    public function index()
    {
        // If user is admin, show all orders, otherwise show only user's orders
        if (auth()->user()->is_admin) {
            $orders = Order::with(['user', 'orderItems.product'])
                ->latest()
                ->get();
        } else {
            $orders = Order::where('user_id', auth()->id())
                ->with('orderItems.product')
                ->latest()
                ->get();
        }

        return view('orders.index', compact('orders'));
    }

    /**
     * Show user's orders only
     */
    public function myOrders()
    {
        $orders = Order::where('user_id', auth()->id())
            ->with('orderItems.product')
            ->latest()
            ->get();

        return view('orders.my-orders', compact('orders'));
    }

    /**
     * Show checkout page
     */
    public function checkout()
    {
        $cart = app(CartController::class)->getOrCreateCart();
        $cartItems = $cart->items()->with('product')->get();
        
        if ($cartItems->isEmpty()) {
            return redirect()->route('cart.index')->with('error', 'Your cart is empty.');
        }

        $total = $cartItems->sum(function ($item) {
            return $item->quantity * $item->product->price;
        });

        return view('checkout', compact('cartItems', 'total'));
    }

    /**
     * Process checkout
     */
    public function processCheckout(Request $request)
    {
        $request->validate([
            'shipping_address' => 'required|string|max:255',
            'billing_address' => 'required|string|max:255',
            'payment_method' => 'required|string',
        ]);

        $cart = app(CartController::class)->getOrCreateCart();
        $cartItems = $cart->items()->with('product')->get();

        if ($cartItems->isEmpty()) {
            return redirect()->route('cart.index')->with('error', 'Your cart is empty.');
        }

        // Calculate total
        $total = $cartItems->sum(function ($item) {
            return $item->quantity * $item->product->price;
        });

        // Create order
        $order = Order::create([
            'user_id' => auth()->id(),
            'total_amount' => $total,
            'status' => 'pending',
            'shipping_address' => $request->shipping_address,
            'billing_address' => $request->billing_address,
            'payment_method' => $request->payment_method,
        ]);

        // Create order items
        foreach ($cartItems as $cartItem) {
            $order->orderItems()->create([
                'product_id' => $cartItem->product_id,
                'quantity' => $cartItem->quantity,
                'price' => $cartItem->product->price,
            ]);
        }

        // Clear cart
        $cart->items()->delete();

        return redirect()->route('orders.payment', $order)
            ->with('success', 'Order placed successfully! Please complete the payment.');
    }

    /**
     * Show single order
     */
    public function show(Order $order)
    {
        // Check if user owns this order or is admin
        if ($order->user_id !== auth()->id() && !auth()->user()->is_admin) {
            abort(403, 'Unauthorized');
        }

        $order->load('orderItems.product', 'user');
        
        return view('orders.show', compact('order'));
    }

    /**
     * Store a new order (direct purchase)
     */
    public function store(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1',
            'shipping_address' => 'required|string|max:255',
            'billing_address' => 'required|string|max:255',
        ]);

        $product = Product::findOrFail($request->product_id);
        $total = $product->price * $request->quantity;

        $order = Order::create([
            'user_id' => auth()->id(),
            'total_amount' => $total,
            'status' => 'pending',
            'shipping_address' => $request->shipping_address,
            'billing_address' => $request->billing_address,
            'payment_method' => 'card', // default
        ]);

        // Create order item
        $order->orderItems()->create([
            'product_id' => $product->id,
            'quantity' => $request->quantity,
            'price' => $product->price,
        ]);

        return redirect()->route('orders.payment', $order)
            ->with('success', 'Order placed successfully! Please complete the payment.');
    }

    /**
     * Create order form (admin)
     */
    public function create()
    {
        $products = Product::all();
        return view('orders.create', compact('products'));
    }

    /**
     * Edit order (admin)
     */
    public function edit(Order $order)
    {
        $products = Product::all();
        return view('orders.edit', compact('order', 'products'));
    }

    /**
     * Update order (admin)
     */
    public function update(Request $request, Order $order)
    {
        $request->validate([
            'status' => 'required|string',
            'total_amount' => 'required|numeric|min:0',
        ]);

        $order->update([
            'status' => $request->status,
            'total_amount' => $request->total_amount,
        ]);

        return redirect()->route('orders.index')->with('success', 'Order updated successfully!');
    }

    /**
     * Delete order (admin)
     */
    public function destroy(Order $order)
    {
        $order->delete();
        return redirect()->route('orders.index')->with('success', 'Order deleted successfully!');
    }

    /**
     * Update order status (admin)
     */
    public function updateStatus(Request $request, Order $order)
    {
        $request->validate([
            'status' => 'required|string|in:pending,processing,shipped,delivered,cancelled',
        ]);

        $order->update([
            'status' => $request->status,
        ]);

        return redirect()->back()->with('success', 'Order status updated successfully!');
    }
}