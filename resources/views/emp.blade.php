@extends('layouts.app')

@section('content')
<div class="max-w-6xl mx-auto px-4 py-6">
    <h2 class="text-2xl font-bold mb-4">Sales Report</h2>

    {{-- Filter Form --}}
    <form method="GET" action="{{ route('reports.sales') }}" class="mb-6 grid grid-cols-1 md:grid-cols-4 gap-4 bg-white p-4 rounded shadow">
        <div>
            <label for="date" class="block text-sm font-medium text-gray-700">Select Date</label>
            <input type="date" name="date" id="date" value="{{ $filters['date'] ?? '' }}" class="mt-1 block w-full border rounded px-3 py-2 focus:outline-none focus:ring focus:border-blue-300">
        </div>

        <div>
            <label for="employee_id" class="block text-sm font-medium text-gray-700">Select Employee</label>
            <select name="employee_id" id="employee_id" class="mt-1 block w-full border rounded px-3 py-2 focus:outline-none focus:ring focus:border-blue-300">
                <option value="">-- All Employees --</option>
                @foreach($employees as $employee)
                    <option value="{{ $employee->id }}" {{ (isset($filters['employee_id']) && $filters['employee_id'] == $employee->id) ? 'selected' : '' }}>
                        {{ $employee->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="flex items-end">
            <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded w-full">
                Search
            </button>
        </div>
    </form>

    {{-- Totals --}}
    @if($sales->count())
        <div class="mb-4 bg-gray-100 p-4 rounded shadow flex justify-between text-gray-700 font-semibold">
            <div>Total Sales: <span class="text-green-600">UGX {{ number_format($totalAmount) }}</span></div>
            <div>Total Quantity: <span class="text-blue-600">{{ $totalQuantity }}</span></div>
        </div>
    @endif

    {{-- Sales Table --}}
    <div class="overflow-x-auto bg-white rounded shadow">
        <table class="w-full table-auto text-sm text-left">
            <thead class="bg-gray-100 border-b font-medium">
                <tr>
                    <th class="px-4 py-2">#</th>
                    <th class="px-4 py-2">Product</th>
                    <th class="px-4 py-2">Qty</th>
                    <th class="px-4 py-2">Amount</th>
                    <th class="px-4 py-2">Sold By</th>
                    <th class="px-4 py-2">Date</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($sales as $sale)
                    <tr class="border-b hover:bg-gray-50">
                        <td class="px-4 py-2">{{ $sale->id }}</td>
                        <td class="px-4 py-2">{{ $sale->product->name ?? 'N/A' }}</td>
                        <td class="px-4 py-2">{{ $sale->quantity }}</td>
                        <td class="px-4 py-2">UGX {{ number_format($sale->total_amount) }}</td>
                        <td class="px-4 py-2">{{ $sale->user->name ?? 'N/A' }}</td>
                        <td class="px-4 py-2">{{ $sale->created_at->format('Y-m-d H:i') }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="text-center py-4 text-gray-500">No sales found for the selected filters.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{-- Pagination --}}
    <div class="mt-4">
        {{ $sales->withQueryString()->links() }}
    </div>
</div>
@endsection
