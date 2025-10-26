@extends('layouts.app')

@section('content')
<div class="max-w-6xl mx-auto p-6 bg-white rounded shadow">
    <div class="flex items-center justify-between mb-6">
        <h1 class="text-2xl font-bold">Full Inventory Details</h1>
        <a href="{{ route('products.index') }}"
           class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 transition">
            Back to Inventory List
        </a>
    </div>

    <div class="overflow-x-auto">
        <table class="min-w-full bg-white border border-gray-200">
            <thead class="bg-gray-100">
                <tr class="text-left text-sm font-semibold text-gray-700">
                    <th class="px-4 py-2 border-b">SKU</th>
                    <th class="px-4 py-2 border-b">Product Name</th>
                    <th class="px-4 py-2 border-b">Initial Quantity</th>
                    <th class="px-4 py-2 border-b">Current Quantity</th>
                    <th class="px-4 py-2 border-b">Updated At</th>
                </tr>
            </thead>
            <tbody>
                @forelse($products as $product)
                <tr class="border-t hover:bg-gray-50 text-gray-800 text-sm">
                    <td class="px-4 py-2">{{ $product->sku }}</td>
                    <td class="px-4 py-2">{{ $product->name }}</td>
                    <td class="px-4 py-2">{{ $product->initial_quantity }}</td>
                    <td class="px-4 py-2">{{ $product->quantity }}</td>
                    <td class="px-4 py-2">{{ $product->updated_at->diffForHumans() }}</td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="px-4 py-6 text-center text-gray-500">
                        No products found.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-6">
        {{ $products->withQueryString()->links() }}
    </div>
</div>
@endsection
