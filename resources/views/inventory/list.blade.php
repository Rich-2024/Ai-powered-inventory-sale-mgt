{{-- @extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto p-6 bg-white rounded shadow">
    <div class="flex items-center justify-between mb-6">
        <h1 class="text-2xl font-bold text-gray-800">📦 Inventory List</h1>

        <!-- 🔍 Search bar -->
        <form method="GET" action="{{ route('products.index') }}" class="flex">
            <input type="text" name="search" placeholder="Search products..." value="{{ request('search') }}"
                class="border border-gray-300 rounded-l px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-400" />
            <button type="submit"
                class="bg-blue-500 text-white px-4 py-2 rounded-r hover:bg-blue-600 transition duration-200">
                Search
            </button>
        </form>
    </div>

    @if(session('success'))
        <div class="mb-4 p-3 bg-green-100 text-green-700 rounded">
            {{ session('success') }}
        </div>
    @endif

    <div class="overflow-x-auto">
        <table class="min-w-full bg-white border border-gray-200 text-sm">
            <thead class="bg-gray-100 text-gray-700 font-semibold">
                <tr>
                    <th class="px-4 py-2 border-b">SKU</th>
                    <th class="px-4 py-2 border-b">Name</th>
                    <th class="px-4 py-2 border-b">Unit</th>
                    <th class="px-4 py-2 border-b">Original Qty</th>
                    <th class="px-4 py-2 border-b">Qty (Pieces)</th>
                    <th class="px-4 py-2 border-b">Purchase Price</th>
                    <th class="px-4 py-2 border-b">Sell Price</th>
                    <th class="px-4 py-2 border-b">PP/Dozen</th>
                    <th class="px-4 py-2 border-b">SP/Dozen</th>
                    <th class="px-4 py-2 border-b">PP/Carton</th>
                    <th class="px-4 py-2 border-b">SP/Carton</th>
                    <th class="px-4 py-2 border-b">Total Purchase</th>
                    <th class="px-4 py-2 border-b">Total Sell</th>
                    <th class="px-4 py-2 border-b">Profit</th>
                    <th class="px-4 py-2 border-b">Updated</th>
                    <th class="px-4 py-2 border-b text-center">Actions</th>
                </tr>
            </thead>
            <tbody>
                @php
                    $totalPurchaseValue = 0;
                    $totalSellValue = 0;
                @endphp

                @forelse($products as $product)
                    @php
                        $purchaseValue = $product->quantity * $product->purchase_price;
                        $sellValue = $product->quantity * $product->price;
                        $expectedProfit = $sellValue - $purchaseValue;

                        $totalPurchaseValue += $purchaseValue;
                        $totalSellValue += $sellValue;
                    @endphp

                    <tr class="border-t hover:bg-gray-50 text-gray-800">
                        <td class="px-4 py-2">{{ $product->sku }}</td>
                        <td class="px-4 py-2">{{ $product->name }}</td>
                        <td class="px-4 py-2 capitalize">{{ $product->original_unit ?? '-' }}</td>
                        <td class="px-4 py-2">{{ $product->original_quantity ?? '-' }}</td>
                        <td class="px-4 py-2">{{ $product->quantity }}</td>

                        <td class="px-4 py-2 text-blue-600">
                            Ugx: {{ number_format($product->purchase_price, 2) }}
                        </td>
                        <td class="px-4 py-2 text-blue-600">
                            Ugx: {{ number_format($product->price, 2) }}
                        </td>

                        <td class="px-4 py-2 text-blue-600">
                            {{ $product->purchase_price_per_dozen ? 'Ugx: ' . number_format($product->purchase_price_per_dozen, 2) : '-' }}
                        </td>
                        <td class="px-4 py-2 text-green-600">
                            {{ $product->selling_price_per_dozen ? 'Ugx: ' . number_format($product->selling_price_per_dozen, 2) : '-' }}
                        </td>
                        <td class="px-4 py-2 text-blue-600">
                            {{ $product->purchase_price_per_carton ? 'Ugx: ' . number_format($product->purchase_price_per_carton, 2) : '-' }}
                        </td>
                        <td class="px-4 py-2 text-green-600">
                            {{ $product->selling_price_per_carton ? 'Ugx: ' . number_format($product->selling_price_per_carton, 2) : '-' }}
                        </td>

                        <td class="px-4 py-2 text-gray-700">
                            Ugx: {{ number_format($purchaseValue, 2) }}
                        </td>
                        <td class="px-4 py-2 text-gray-700">
                            Ugx: {{ number_format($sellValue, 2) }}
                        </td>
                        <td class="px-4 py-2 text-green-700">
                            Ugx: {{ number_format($expectedProfit, 2) }}
                        </td>
                        <td class="px-4 py-2">
                            {{ $product->updated_at ? $product->updated_at->diffForHumans() : '-' }}
                        </td>

                        <td class="px-4 py-2 text-center">
                            <div class="flex justify-center space-x-2">
                                <a href="{{ route('products.edit', $product->id) }}"
                                    class="bg-blue-500 hover:bg-blue-600 text-white text-xs px-3 py-1 rounded transition"
                                    title="Edit Product">
                                    ✏️ Edit
                                </a>

                                <form action="{{ route('products.destroy', $product->id) }}"
                                    method="POST"
                                    onsubmit="return confirm('Are you sure you want to delete this product?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                        class="bg-red-500 hover:bg-red-600 text-white text-xs px-3 py-1 rounded transition"
                                        title="Delete Product">
                                        🗑️
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="16" class="px-4 py-4 text-center text-gray-500">
                            No products found.
                        </td>
                    </tr>
                @endforelse
            </tbody>

            <tfoot class="bg-gray-50 font-semibold text-gray-800">
                @php
                    $totalExpectedProfit = $totalSellValue - $totalPurchaseValue;
                @endphp
                <tr>
                    <td colspan="11" class="px-4 py-2 text-right">Total Purchase Value:</td>
                    <td class="px-4 py-2">Ugx: {{ number_format($totalPurchaseValue, 2) }}</td>
                    <td class="px-4 py-2 text-right">Total Sell Value:</td>
                    <td class="px-4 py-2">Ugx: {{ number_format($totalSellValue, 2) }}</td>
                    <td colspan="2" class="px-4 py-2 text-right text-green-700">
                        Profit: Ugx: {{ number_format($totalExpectedProfit, 2) }}
                    </td>
                </tr>
            </tfoot>
        </table>
    </div>

    <!-- Pagination -->
    <div class="mt-4">
        {{ $products->appends(request()->query())->links() }}
    </div>
</div>
@endsection --}}
@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-6">
    <h1 class="text-3xl font-semibold text-blue-700 mb-6">Inventory List</h1>

    <!-- Search Form -->
    <form method="GET" action="{{ route('products.index') }}" class="mb-6 max-w-md">
        <input
            type="text"
            name="search"
            value="{{ request('search') }}"
            placeholder="Search by SKU or Name"
            class="w-full border border-blue-300 rounded px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500"
        />
    </form>

    <div class="overflow-x-auto">
        <table class="min-w-full bg-white border border-blue-300 rounded-lg shadow-md">
            <thead class="bg-blue-100 text-blue-700 uppercase text-sm leading-normal">
                <tr>
                    <th class="py-3 px-4 text-left whitespace-nowrap">SKU</th>
                    <th class="py-3 px-4 text-left whitespace-nowrap">Name</th>
                    <th class="py-3 px-4 text-right whitespace-nowrap">Quantity</th>
                    <th class="py-3 px-4 text-left whitespace-nowrap">Unit</th>
                    <th class="py-3 px-4 text-right whitespace-nowrap">Purchase Price</th>
                    <th class="py-3 px-4 text-right whitespace-nowrap">Selling Price</th>
                    <th class="py-3 px-4 text-right whitespace-nowrap">Total Purchase Value</th>
                    <th class="py-3 px-4 text-right whitespace-nowrap">Total Sell Value</th>
                    <th class="py-3 px-4 text-right whitespace-nowrap">Expected Profit</th>
                    <th class="py-3 px-4 text-center whitespace-nowrap">Actions</th>
                </tr>
            </thead>
            <tbody class="text-gray-700 text-sm">
                @forelse ($products as $product)
                <tr class="border-b border-blue-200 hover:bg-blue-50">
                    <td class="py-3 px-4">{{ $product->sku }}</td>
                    <td class="py-3 px-4">{{ $product->name }}</td>
                    <td class="py-3 px-4 text-right">{{ $product->quantity }}</td>
                    <td class="py-3 px-4">{{ ucfirst($product->unit) }}</td>
                    <td class="py-3 px-4 text-right">
                        {{ number_format($product->purchase_price_bulk ?? $product->purchase_price ?? 0, 2) }}
                    </td>
                    <td class="py-3 px-4 text-right">
                        {{ number_format($product->selling_price_bulk ?? $product->price ?? 0, 2) }}
                    </td>
                    <td class="py-3 px-4 text-right font-semibold">
                        {{ number_format($product->total_purchase_value ?? 0, 2) }}
                    </td>
                    <td class="py-3 px-4 text-right font-semibold">
                        {{ number_format($product->total_sell_value ?? 0, 2) }}
                    </td>
                    <td class="py-3 px-4 text-right font-semibold {{ ($product->expected_profit ?? 0) >= 0 ? 'text-green-600' : 'text-red-600' }}">
                        {{ number_format($product->expected_profit ?? 0, 2) }}
                    </td>
                    <td class="py-3 px-4 text-center space-x-2 whitespace-nowrap">
                        <a href="{{ route('products.edit', $product->id) }}"
                           class="inline-block px-3 py-1 bg-blue-600 text-white rounded hover:bg-blue-700 transition duration-150">
                            Edit
                        </a>
                        <form action="{{ route('products.destroy', $product->id) }}" method="POST" class="inline-block" onsubmit="return confirm('Are you sure you want to delete this product?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit"
                                    class="px-3 py-1 bg-red-600 text-white rounded hover:bg-red-700 transition duration-150">
                                Delete
                            </button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="10" class="text-center py-6 text-gray-500 font-semibold">
                        No products were uploaded to the inventory.
                    </td>
                </tr>
                @endforelse
            </tbody>
            @if($products->count())
            <tfoot class="bg-blue-100 text-blue-700 font-semibold">
                <tr>
                    <td colspan="6" class="py-3 px-4 text-right whitespace-nowrap">Totals:</td>
                    <td class="py-3 px-4 text-right whitespace-nowrap">{{ number_format($totalPurchaseValue ?? 0, 2) }}</td>
                    <td class="py-3 px-4 text-right whitespace-nowrap">{{ number_format($totalSellValue ?? 0, 2) }}</td>
                    <td class="py-3 px-4 text-right whitespace-nowrap {{ ($expectedProfit ?? 0) >= 0 ? 'text-green-600' : 'text-red-600' }}">
                        {{ number_format($expectedProfit ?? 0, 2) }}
                    </td>
                    <td></td>
                </tr>
            </tfoot>
            @endif
        </table>
    </div>

    <div class="mt-6">
        {{ $products->withQueryString()->links() }}
    </div>
</div>
@endsection
