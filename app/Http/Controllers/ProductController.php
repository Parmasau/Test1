<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    // Show all products (in a Blade view)
    public function index()
    {
        $products = Product::all();
        return view('products.index', compact('products'));
    }

    // Show order form for a specific product
    public function order(Product $product)
    {
        return view('products.order', compact('product'));
    }

    // Store a new product
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'stock' => 'integer|min:0',
        ]);

        $product = Product::create($request->all());
        return response()->json([
            'status'=>'Success',
            'message' => 'Product created Successfully',
            'data' => $product, 201
        ]);
    }

    // Show one product
    public function show(Product $product)
    {
        return response()->json([
            'status'=>'Success',
            'message' => 'Product retrieved Successfully',
            'data' => $product
        ]);
    }

    // Update product
    public function update(Request $request, Product $product)
    {
        $request->validate([
            'name' => 'string|max:255',
            'description' => 'string|max:255',
            'price' => 'numeric|min:0',
            'stock' => 'integer|min:0',
        ]);

        $product->update($request->all());
        return response()->json([
            'status'=> 'success',
            'message' => 'Product updated Successfully',
            'data' => $product
        ]);
    }

    // Delete product
    public function destroy(Product $product)
    {
        $product->delete();
        return response()->json([
            'status'=>'success',
            'message' => 'Product deleted'
        ]);
    }
}