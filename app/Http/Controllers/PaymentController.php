<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    public function showPayment(Order $order)
    {
        // Check if user owns this order
        if ($order->user_id !== auth()->id()) {
            abort(403, 'Unauthorized');
        }

        $order->load('orderItems.product');

        return view('payments.payment', compact('order'));
    }

    public function processPayment(Request $request, Order $order)
    {
        // Check if user owns this order
        if ($order->user_id !== auth()->id()) {
            abort(403, 'Unauthorized');
        }

        // Process payment (simulate payment processing)
        $order->update([
            'status' => 'processing', // Change to 'on the way'
            'payment_method' => $request->payment_method,
            'paid_at' => now(),
        ]);

        return redirect()->route('orders.index')
            ->with('success', 'Payment successful! Your order is being processed.');
    }
}