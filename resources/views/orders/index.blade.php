<x-app-layout>
    <x-slot name="title">Orders</x-slot>

    <div class="flex justify-between items-center mb-6">
        <h2 class="text-3xl font-bold text-amber-800">Orders</h2>
        <a href="{{ route('orders.create') }}" class="bg-amber-600 text-white px-4 py-2 rounded-lg hover:bg-amber-700 transition">+ New Order</a>
    </div>

    <div class="grid gap-6">
        @foreach ($orders as $order)
            <div class="bg-white rounded-xl shadow-lg p-6">
                <h3 class="text-xl font-semibold text-amber-700">Order #{{ $order->id }}</h3>
                <p class="text-gray-600">Product: {{ $order->product->name }}</p>
                <p class="text-gray-600">Quantity: {{ $order->quantity }}</p>
                <p class="text-gray-600">Total: ${{ $order->total }}</p>
                <p class="text-gray-400 text-sm mt-2">Placed on {{ $order->created_at->format('M d, Y') }}</p>
            </div>
        @endforeach
    </div>
</x-app-layout>
