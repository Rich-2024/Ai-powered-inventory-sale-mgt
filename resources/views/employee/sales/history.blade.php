@extends('layouts.app')

@section('head')
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" />
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet" />
@endsection

@section('content')
<div class="container mt-0">
  <div class="card shadow-lg border-0">
   <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
  <h4 class="mb-0"><i class="bi bi-clock-history"></i> Sales History</h4>
  <div>
    <a href="/expenses/create" class="btn btn-light btn-sm me-2">
      <i class="bi bi-cash-stack"></i> Record Daily Expense
    </a>
    <a href="{{ route('employee.dashboard') }}" class="btn btn-light btn-sm">
      <i class="bi bi-arrow-left-circle"></i> Back to Dashboard
    </a>
  </div>
</div>

    <div class="card-body">
      <form method="GET" action="{{ route('employee.sales.history') }}" class="row g-3 mb-4">
        <div class="col-md-3">
          <label for="period" class="form-label fw-semibold">Select Period</label>
          <select id="period" name="period" class="form-select" onchange="this.form.submit()">
            <option value="today" {{ request('period')=='today' ? 'selected' : '' }}>Today</option>
            <option value="week" {{ request('period')=='week' ? 'selected' : '' }}>This Week</option>
            <option value="month" {{ request('period')=='month' ? 'selected' : '' }}>This Month</option>
            <option value="all" {{ request('period')=='all' ? 'selected' : '' }}>All Time</option>
          </select>
        </div>
        <div class="col-md-4">
          <label for="search" class="form-label fw-semibold">Search Product</label>
          <input type="text" id="search" name="search" class="form-control" placeholder="Product name or ID" value="{{ request('search') }}">
        </div>
        <div class="col-md-2 d-flex align-items-end">
          <button type="submit" class="btn btn-primary w-100"><i class="bi bi-search"></i> Search</button>
        </div>
        <div class="col-md-3 d-flex align-items-end justify-content-end">
          <a href="{{ route('employee.sales.report', request()->all()) }}" target="_blank" class="btn btn-success">
            <i class="bi bi-file-earmark-text"></i> View Sale Report
          </a>
        </div>
      </form>

      @if($sales->isEmpty())
        <div class="alert alert-warning text-center">
          <i class="bi bi-exclamation-triangle"></i> No sales found for the selected period.
        </div>
      @else
      <div class="table-responsive">
        <table class="table table-striped table-hover align-middle">
          <thead class="table-dark">
            <tr>
              <th>#</th>
              <th>Product Name</th>
              <th>Unit Price (UGX)</th>
              <th>Quantity Sold</th>
              <th>Total Amount (UGX)</th>
              <th>Sale Date</th>
            </tr>
          </thead>
          <tbody>
            @foreach ($sales as $index => $sale)
            <tr>
              <td>{{ $loop->iteration + ($sales->currentPage() - 1) * $sales->perPage() }}</td>
              <td>{{ $sale->product->name }}</td>
              <td>{{ number_format($sale->product->price) }}</td>
              <td>{{ $sale->quantity }}</td>
              <td>{{ number_format($sale->total_amount) }}</td>
              <td>{{ $sale->created_at->format('d-M-Y H:i') }}</td>
            </tr>
            @endforeach
          </tbody>
        </table>
      </div>

      <div class="d-flex justify-content-between align-items-center">
        <div>
          <strong>Total Sales:</strong> UGX {{ number_format($totalSales) }}
        </div>
        <div>
          {{ $sales->withQueryString()->links() }}
        </div>
      </div>

      <hr />

      <h5 class="text-primary"><i class="bi bi-bar-chart-line-fill"></i> Most Sold Products ({{ ucfirst(request('period') ?? 'period') }})</h5>
      @if($mostSold->isEmpty())
        <p class="text-muted">No product sales data available.</p>
      @else
      <table class="table table-bordered table-hover">
        <thead class="table-secondary">
          <tr>
            <th>Product Name</th>
            <th>Total Quantity Sold</th>
          </tr>
        </thead>
        <tbody>
          @foreach ($mostSold as $product)
          <tr>
            <td>{{ $product->name }}</td>
            <td>{{ $product->total_quantity }}</td>
          </tr>
          @endforeach
        </tbody>
      </table>
      @endif

      @endif
    </div>
  </div>
</div>
@endsection
