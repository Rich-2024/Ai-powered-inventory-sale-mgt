@extends('layouts.admin') {{-- Your admin layout --}}

@section('title', 'Sales & Expenses Report')

@section('content')
@if (session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
@endif

<div class="container my-0">

    <h1 class="mb-4">Sales & Expenses Report</h1>

    {{-- Filter form --}}
    <form method="GET" action="{{ route('sales.report') }}" class="mb-4 row g-3 align-items-center">
        <div class="col-auto">
            <label for="period" class="form-label">Period</label>
            <select id="period" name="period" class="form-select" onchange="toggleCustomDates()">
                <option value="daily" {{ $period == 'daily' ? 'selected' : '' }}>Daily</option>
                <option value="weekly" {{ $period == 'weekly' ? 'selected' : '' }}>Weekly</option>
                <option value="monthly" {{ $period == 'monthly' ? 'selected' : '' }}>Monthly</option>
                <option value="custom" {{ $period == 'custom' ? 'selected' : '' }}>Custom</option>
            </select>
        </div>

        <div class="col-auto custom-date {{ $period == 'custom' ? '' : 'd-none' }}">
            <label for="from" class="form-label">From</label>
            <input type="date" id="from" name="from" class="form-control" value="{{ $from }}">
        </div>

        <div class="col-auto custom-date {{ $period == 'custom' ? '' : 'd-none' }}">
            <label for="to" class="form-label">To</label>
            <input type="date" id="to" name="to" class="form-control" value="{{ $to }}">
        </div>

        <div class="col-auto align-self-end">
            <button type="submit" class="btn btn-primary">Filter</button>
        </div>
    </form>

    {{-- Date range display --}}
    <p><strong>Date range:</strong> {{ $start->format('M d, Y') }} - {{ $end->format('M d, Y') }}</p>

    {{-- Total Sales & Profit --}}
    <div class="row mb-4">
        <div class="col-md-6">
            <div class="alert alert-success">
                <h4>Total Sales Amount</h4>
                <p class="fs-4">${{ number_format($totalSalesAmount, 2) }}</p>
            </div>
        </div>
        <div class="col-md-6">
            <div class="alert alert-info">
                <h4>Total Clean Profit</h4>
                <p class="fs-4">${{ number_format($totalCleanProfit, 2) }}</p>
            </div>
        </div>
    </div>

    {{-- Most Sold Products --}}
    <div class="mb-5">
        <h3>Top 5 Most Sold Products</h3>
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Product</th>
                    <th>Quantity Sold</th>
                    <th>Price per Unit</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($mostSoldProducts as $productName => $data)
                    <tr>
                        <td>{{ $productName }}</td>
                        <td>{{ $data['quantity_sold'] }}</td>
                        <td>${{ number_format($data['price'], 2) }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    {{-- Sales Grouped By Employee --}}
    <div class="mb-5">
        <h3>Sales by Employee</h3>

        @foreach ($groupedByEmployee as $employeeId => $salesGroup)
            @php
                $employeeName = $salesGroup->first()->employee->name ?? 'Unknown Employee';
                $employeeTotalSales = $salesGroup->sum(fn($s) => $s->calculated_total_sale);
                $employeeTotalProfit = $salesGroup->sum(fn($s) => $s->calculated_clean_profit);
            @endphp

            <div class="card mb-3">
                <div class="card-header bg-primary text-white">
                    {{ $employeeName }} — Total Sales: ${{ number_format($employeeTotalSales, 2) }}, Profit: ${{ number_format($employeeTotalProfit, 2) }}
                </div>
                <div class="card-body p-0">
                    <table class="table mb-0">
                        <thead>
                            <tr>
                                <th>Date</th>
                                <th>Product</th>
                                <th>Qty</th>
                                <th>Sale Price</th>
                                <th>Purchase Price</th>
                                <th>Total Sale</th>
                                <th>Clean Profit</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($salesGroup as $sale)
                                <tr>
                                    <td>{{ $sale->created_at->format('M d, Y') }}</td>
                                    <td>{{ $sale->product->name ?? 'N/A' }}</td>
                                    <td>{{ $sale->quantity }}</td>
                                    <td>${{ number_format($sale->calculated_sale_price, 2) }}</td>
                                    <td>${{ number_format($sale->calculated_purchase_price, 2) }}</td>
                                    <td>${{ number_format($sale->calculated_total_sale, 2) }}</td>
                                    <td>${{ number_format($sale->calculated_clean_profit, 2) }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        @endforeach
    </div>

    {{-- Admin Expenses --}}
    <div class="mb-5">
        <h3>Expenses</h3>
        <table class="table table-bordered table-striped">
            <thead class="table-dark">
                <tr>
                    <th>Date</th>
                    <th>Title</th>
                    <th>Category</th>
                    <th>Employee</th>
                    <th>Amount</th>
                    <th>Description</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($adminExpenses as $expense)
                    <tr>
                        <td>{{ \Carbon\Carbon::parse($expense->date)->format('M d, Y') }}</td>
                        <td>{{ $expense->title }}</td>
                        <td>{{ $expense->category }}</td>
                        <td>{{ $expense->employee->name ?? 'N/A' }}</td>
                        <td>${{ number_format($expense->amount, 2) }}</td>
                        <td>{{ $expense->description ?? '-' }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="text-center">No expenses found.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        {{-- Pagination --}}
        <div>
            {{ $adminExpenses->links() }}
        </div>
    </div>

</div>

{{-- JS to toggle custom date inputs --}}
<script>
    function toggleCustomDates() {
        const period = document.getElementById('period').value;
        const customDates = document.querySelectorAll('.custom-date');

        customDates.forEach(el => {
            el.classList.toggle('d-none', period !== 'custom');
        });
    }
    window.onload = toggleCustomDates;
</script>

@endsection
