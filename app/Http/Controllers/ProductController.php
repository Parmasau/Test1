<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProductController extends Controller
{
    /**
     * Display all products with quantity controls
     */
    public function index()
    {
        $products = Product::all();
        return view('products.index', compact('products'));
    }

    /**
     * Show the form for creating a new product (web view)
     */
    public function create()
    {
        return view('products.create');
    }

    /**
     * Store a new product (web form submission)
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'image' => 'nullable|string|max:255',
        ]);

        Product::create($request->all());

        return redirect()->route('products.index')
            ->with('success', 'Product created successfully!');
    }

    /**
     * Show one product (web view)
     */
    public function show(Product $product)
    {
        return view('products.show', compact('product'));
    }

    /**
     * Show the form for editing a product (web view)
     */
    public function edit(Product $product)
    {
        return view('products.edit', compact('product'));
    }

    /**
     * Update product (web form submission)
     */
    public function update(Request $request, Product $product)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'image' => 'nullable|string|max:255',
        ]);

        $product->update($request->all());

        return redirect()->route('products.index')
            ->with('success', 'Product updated successfully!');
    }

    /**
     * Delete product (web)
     */
    public function destroy(Product $product)
    {
        $product->delete();

        return redirect()->route('products.index')
            ->with('success', 'Product deleted successfully!');
    }

    /**
     * Show shipping form for direct purchase
     */
    public function showShipping(Product $product, $quantity = 1)
    {
        if ($product->stock < $quantity) {
            return redirect()->route('products.index')
                ->with('error', 'Not enough stock available!');
        }

        return view('products.shipping', compact('product', 'quantity'));
    }

    /**
     * Process direct product purchase (Fixed version)
     */
    public function directPurchase(Request $request, Product $product)
    {
        // Ensure user is authenticated
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Please log in to place an order.');
        }

        $request->validate([
            'quantity' => 'required|integer|min:1|max:' . $product->stock,
            'shipping_address' => 'required|string|max:500',
            'phone' => 'required|string|max:20',
            'city' => 'required|string|max:100',
            'payment_method' => 'required|string|in:mpesa,card',
        ]);

        // Check stock availability
        if ($product->stock < $request->quantity) {
            return redirect()->back()->with('error', 'Not enough stock available!');
        }

        // Calculate total (product price + shipping)
        $subtotal = $product->price * $request->quantity;
        $shipping = 100; // Fixed shipping cost
        $total = $subtotal + $shipping;

        // Create order with authenticated user ID
        $order = Order::create([
            'user_id' => Auth::id(),
            'total_amount' => $total,
            'status' => 'pending',
            'shipping_address' => $request->shipping_address,
            'phone' => $request->phone,
            'city' => $request->city,
            'payment_method' => $request->payment_method,
        ]);

        // Create order item
        $order->orderItems()->create([
            'product_id' => $product->id,
            'quantity' => $request->quantity,
            'price' => $product->price,
        ]);

        // Update product stock
        $product->decrement('stock', $request->quantity);

        // Redirect to payment page
        return redirect()->route('orders.payment', $order)
            ->with('success', 'Order confirmed! Please complete your payment.');
    }

    /**
     * Process payment and complete order
     */
    public function processPayment(Request $request, Order $order)
    {
        // Check if user owns this order
        if ($order->user_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }

        // Update order status to processing (on the way)
        $order->update([
            'status' => 'processing',
            'paid_at' => now(),
        ]);

        return redirect()->route('orders.index')
            ->with('success', 'Payment successful! Your order is on the way.');
    }

    // ========== CART & ORDER METHODS ==========

    /**
     * Add to cart (session-based)
     */
    public function addToCart(Request $request, $id)
    {
        $product = Product::findOrFail($id);
        $cart = session()->get('cart', []);

        // Check stock availability
        if ($product->stock < 1) {
            return redirect()->back()->with('error', 'Product is out of stock!');
        }

        if(isset($cart[$id])) {
            // Check if adding one more would exceed stock
            if ($cart[$id]['quantity'] + 1 > $product->stock) {
                return redirect()->back()->with('error', 'Not enough stock available!');
            }
            $cart[$id]['quantity']++;
        } else {
            $cart[$id] = [
                "name" => $product->name,
                "quantity" => 1,
                "price" => $product->price,
                "image" => $product->image
            ];
        }

        session()->put('cart', $cart);
        return redirect()->back()->with('success', 'Product added to cart successfully!');
    }

    /**
     * View cart
     */
    public function cart()
    {
        $cart = session()->get('cart', []);
        $total = 0;
        
        foreach($cart as $item) {
            $total += $item['price'] * $item['quantity'];
        }

        return view('products.cart', compact('cart', 'total'));
    }

    /**
     * Update cart quantity
     */
    public function updateCart(Request $request, $id)
    {
        $cart = session()->get('cart', []);
        $product = Product::findOrFail($id);

        if(isset($cart[$id])) {
            $newQuantity = $request->quantity;
            
            if ($newQuantity < 1) {
                unset($cart[$id]);
            } else {
                if ($newQuantity > $product->stock) {
                    return redirect()->back()->with('error', 'Not enough stock available!');
                }
                $cart[$id]['quantity'] = $newQuantity;
            }
            
            session()->put('cart', $cart);
        }

        return redirect()->back()->with('success', 'Cart updated successfully');
    }

    /**
     * Remove from cart
     */
    public function removeFromCart($id)
    {
        $cart = session()->get('cart', []);
        
        if(isset($cart[$id])) {
            unset($cart[$id]);
            session()->put('cart', $cart);
        }

        return redirect()->back()->with('success', 'Product removed successfully');
    }

    /**
     * Clear entire cart
     */
    public function clearCart()
    {
        session()->forget('cart');
        return redirect()->route('products.index')->with('success', 'Cart cleared successfully');
    }

    /**
     * Checkout page
     */
    public function checkout()
    {
        $cart = session()->get('cart', []);
        
        if(empty($cart)) {
            return redirect()->route('products.index')->with('error', 'Your cart is empty!');
        }

        // Validate stock before checkout
        foreach($cart as $id => $item) {
            $product = Product::find($id);
            if (!$product || $product->stock < $item['quantity']) {
                return redirect()->route('cart')->with('error', "Product {$item['name']} is out of stock or quantity not available!");
            }
        }

        $total = 0;
        foreach($cart as $item) {
            $total += $item['price'] * $item['quantity'];
        }

        return view('products.checkout', compact('cart', 'total'));
    }

    /**
     * Process order from cart
     */
    public function processOrder(Request $request)
    {
        // Ensure user is authenticated
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Please log in to place an order.');
        }

        $cart = session()->get('cart', []);
        
        if(empty($cart)) {
            return redirect()->route('products.index')->with('error', 'Your cart is empty!');
        }

        $request->validate([
            'shipping_address' => 'required|string|max:500',
            'billing_address' => 'nullable|string|max:500',
            'phone' => 'required|string|max:20',
            'city' => 'required|string|max:100',
            'payment_method' => 'required|string|in:mpesa,card',
        ]);

        // Validate stock and calculate total
        $total = 0;
        foreach($cart as $id => $item) {
            $product = Product::find($id);
            if (!$product) {
                return redirect()->route('cart')->with('error', "Product {$item['name']} no longer exists!");
            }
            if ($product->stock < $item['quantity']) {
                return redirect()->route('cart')->with('error', "Product {$item['name']} is out of stock!");
            }
            $total += $item['price'] * $item['quantity'];
        }

        // Add shipping cost
        $total += 100;

        // Create order
        $order = Order::create([
            'user_id' => Auth::id(),
            'total_amount' => $total,
            'status' => 'pending',
            'shipping_address' => $request->shipping_address,
            'billing_address' => $request->billing_address ?? $request->shipping_address,
            'phone' => $request->phone,
            'city' => $request->city,
            'payment_method' => $request->payment_method,
        ]);

        // Create order items and update stock
        foreach($cart as $id => $item) {
            OrderItem::create([
                'order_id' => $order->id,
                'product_id' => $id,
                'quantity' => $item['quantity'],
                'price' => $item['price'],
            ]);

            // Update product stock
            $product = Product::find($id);
            $product->decrement('stock', $item['quantity']);
        }

        // Clear cart
        session()->forget('cart');

        return redirect()->route('orders.payment', $order)
            ->with('success', 'Order placed successfully! Please proceed with payment.');
    }

    /**
     * Show user orders
     */
    public function myOrders()
    {
        $orders = Order::where('user_id', Auth::id())->with('orderItems.product')->latest()->get();
        return view('orders.index', compact('orders'));
    }

    /**
     * Show order details
     */
    public function showOrder(Order $order)
    {
        // Check if user owns this order
        if($order->user_id != Auth::id()) {
            abort(403, 'Unauthorized action.');
        }

        $order->load('orderItems.product');
        
        return view('orders.show', compact('order'));
    }
}