@extends('layouts.app') {{-- Or use your actual layout name --}}

@section('content')
<div class="max-w-7xl mx-auto p-6">
    <h1 class="text-2xl font-semibold mb-6 text-gray-800">Employee Dashboard</h1>

    {{-- Summary Cards --}}
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
        <div class="bg-white shadow rounded-lg p-5 text-center">
            <h2 class="text-sm text-gray-500">Today's Sales</h2>
            <p class="text-2xl font-bold text-blue-600">UGX {{ number_format($todaySales, 0) }}</p>
        </div>
        <div class="bg-white shadow rounded-lg p-5 text-center">
            <h2 class="text-sm text-gray-500">This Month's Sales</h2>
            <p class="text-2xl font-bold text-green-600">UGX {{ number_format($monthlySales, 0) }}</p>
        </div>
        <div class="bg-white shadow rounded-lg p-5 text-center">
            <h2 class="text-sm text-gray-500">Total Products Sold</h2>
            <p class="text-2xl font-bold text-indigo-600">{{ number_format($totalProductsSold) }}</p>
        </div>
    </div>

    {{-- Recent Sales Table --}}
    <div class="bg-white shadow rounded-lg overflow-hidden">
        <div class="p-4 border-b">
            <h3 class="text-lg font-semibold text-gray-700">Recent Sales</h3>
        </div>
        <table class="w-full table-auto text-sm text-left">
            <thead class="bg-gray-100 text-gray-600 uppercase text-xs">
                <tr>
                    <th class="px-4 py-2">Product</th>
                    <th class="px-4 py-2">Quantity</th>
                    <th class="px-4 py-2">Total</th>
                    <th class="px-4 py-2">Date</th>
                </tr>
            </thead>
            <tbody class="text-gray-700">
                @forelse($recentSales as $sale)
                    <tr class="border-b hover:bg-gray-50">
                        <td class="px-4 py-2">{{ $sale->product->name ?? 'N/A' }}</td>
                        <td class="px-4 py-2">{{ $sale->quantity }}</td>
                        <td class="px-4 py-2">UGX {{ number_format($sale->price, 0) }}</td>
                        <td class="px-4 py-2">{{ $sale->created_at->format('d M Y H:i') }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="px-4 py-4 text-center text-gray-500">No sales recorded yet.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
