@extends('layouts.app')

@section('title', 'Sales Report')

@section('content')
<div class="container mx-auto px-4 py-6">

    {{-- 🔙 Back to Dashboard --}}
    <div class="mb-4 text-right">
        <a href="{{ route('admin.dashboard') }}"
           class="inline-flex items-center gap-2 bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded shadow transition duration-200">
            <i class="bi bi-arrow-left-circle"></i> Back to Dashboard
        </a>
    </div>

    <h1 class="text-2xl font-bold mb-4 text-gray-800">Sales Report</h1>

    {{-- 📋 Report Parameters --}}
    <div class="mb-6 p-4 bg-gray-100 rounded shadow">
        <h2 class="text-lg font-semibold mb-2 text-gray-700">Report Parameters</h2>
        <p><strong>Admin ID:</strong> {{ $validated['admin_id'] }}</p>
        <p><strong>Start Date:</strong> {{ \Carbon\Carbon::parse($validated['start_date'])->format('d M Y') }}</p>
        <p><strong>End Date:</strong> {{ \Carbon\Carbon::parse($validated['end_date'])->format('d M Y') }}</p>
    </div>

    {{-- 📦 Sales Data --}}
    @if($sales->isEmpty())
        <p class="text-center text-gray-500 italic">No sales found for the selected period.</p>
    @else
        <div class="overflow-x-auto">
            <table class="min-w-full bg-white shadow rounded border border-gray-200">
                <thead class="bg-blue-600 text-white">
                    <tr>
                        <th class="py-3 px-5 text-left">Date</th>
                        <th class="py-3 px-5 text-left">Product</th>
                        <th class="py-3 px-5 text-left">Sold By</th>
                        <th class="py-3 px-5 text-right">Quantity</th>
                        <th class="py-3 px-5 text-right">Total Amount (UGX)</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($sales as $sale)
                        <tr class="border-b border-gray-200 hover:bg-gray-50">
                            <td class="py-3 px-5">{{ $sale->created_at->format('d M Y H:i') }}</td>
                            <td class="py-3 px-5">{{ $sale->product->name ?? 'N/A' }}</td>
                            <td class="py-3 px-5">{{ $sale->user->name ?? 'N/A' }}</td>
                            <td class="py-3 px-5 text-right">{{ $sale->quantity }}</td>
                            <td class="py-3 px-5 text-right">{{ number_format($sale->total_amount, 2) }}</td>
                        </tr>
                    @endforeach
                    <tr class="bg-gray-100 font-semibold">
                        <td colspan="3" class="py-3 px-5 text-right">Totals:</td>
                        <td class="py-3 px-5 text-right">{{ $totalQuantity }}</td>
                        <td class="py-3 px-5 text-right">{{ number_format($totalSalesAmount, 2) }}</td>
                    </tr>
                </tbody>
            </table>
        </div>
    @endif
</div>
@endsection
