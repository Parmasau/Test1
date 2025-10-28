<x-app-layout>
    <x-slot name="title">New Order</x-slot>

    <div class="max-w-lg mx-auto bg-white rounded-2xl shadow-lg p-8">
        <h2 class="text-2xl font-bold text-amber-800 mb-6">Create New Order</h2>

        <form action="{{ route('orders.store') }}" method="POST" class="space-y-4">
            @csrf
            <div>
                <label class="block text-gray-700 font-semibold mb-2">Select Product</label>
                <select name="product_id" class="w-full border-gray-300 rounded-lg focus:ring-amber-500 focus:border-amber-500">
                    @foreach ($products as $product)
                        <option value="{{ $product->id }}">{{ $product->name }} — ${{ $product->price }}</option>
                    @endforeach
                </select>
            </div>

            <div>
                <label class="block text-gray-700 font-semibold mb-2">Quantity</label>
                <input type="number" name="quantity" min="1" class="w-full border-gray-300 rounded-lg focus:ring-amber-500 focus:border-amber-500">
            </div>

            <button type="submit" class="w-full bg-amber-600 text-white py-2 rounded-lg hover:bg-amber-700 transition">Place Order</button>
        </form>
    </div>
</x-app-layout>
