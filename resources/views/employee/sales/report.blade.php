@extends('layouts.app')

@section('head')
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
@endsection

@section('content')
<div class="container mt-0">
  <h2 class="mb-4"><i class="bi bi-bar-chart-line-fill"></i> Sales Report</h2>

  <form method="GET" action="{{ route('employee.sales.report') }}" class="row g-3 mb-4 align-items-end">
    <div class="col-md-3">
      <label for="period" class="form-label fw-semibold">Select Period</label>
      <select name="period" id="period" class="form-select" onchange="toggleCustomDates()">
        <option value="daily" {{ old('period', $period) == 'daily' ? 'selected' : '' }}>Today (Daily)</option>
        <option value="weekly" {{ old('period', $period) == 'weekly' ? 'selected' : '' }}>This Week</option>
        <option value="monthly" {{ old('period', $period) == 'monthly' ? 'selected' : '' }}>This Month</option>
        <option value="custom" {{ old('period', $period) == 'custom' ? 'selected' : '' }}>Custom Range</option>
      </select>
    </div>

    <div class="col-md-3" id="fromDateDiv" style="display: {{ old('period', $period) == 'custom' ? 'block' : 'none' }};">
      <label for="from" class="form-label fw-semibold">From</label>
      <input type="date" name="from" id="from" class="form-control" value="{{ old('from', $from) }}">
    </div>

    <div class="col-md-3" id="toDateDiv" style="display: {{ old('period', $period) == 'custom' ? 'block' : 'none' }};">
      <label for="to" class="form-label fw-semibold">To</label>
      <input type="date" name="to" id="to" class="form-control" value="{{ old('to', $to) }}">
    </div>

    <div class="col-md-3">
      <button type="submit" class="btn btn-primary px-4">
        <i class="bi bi-search"></i> Filter
      </button>
      <a href="{{ route('employee.sales.report') }}" class="btn btn-secondary ms-2 px-4">
        <i class="bi bi-arrow-clockwise"></i> Reset
      </a>
    </div>
  </form>

  <div class="card shadow-sm border-0">
    <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
      <h5 class="mb-0"><i class="bi bi-box-seam"></i> Products Sold</h5>
      <span>Total Sales: <strong class="text-warning">UGX {{ number_format($totalSalesAmount, 0) }}</strong></span>
    </div>
    <div class="card-body p-0">
      @if($grouped->isEmpty())
        <p class="text-center p-3 text-muted">No sales found for this period.</p>
      @else
        <table class="table table-striped table-hover mb-0">
          <thead class="table-light">
            <tr>
              <th>Product</th>
              <th>Price per Unit (UGX)</th>
              <th>Quantity Sold</th>
              <th>Total Sales (UGX)</th>
            </tr>
          </thead>
          <tbody>
        @foreach($grouped as $productName => $data)
<tr>
    <td>{{ $data['product_name'] }}</td>
    <td>{{ number_format($data['unit_price'], 0) }}</td>
    <td>{{ $data['total_quantity'] }}</td>
    <td>{{ number_format($data['total_amount'], 0) }}</td>
</tr>
@endforeach

          </tbody>
        </table>
      @endif
    </div>
  </div>

  <div class="card shadow-sm border-0 mt-4">
    <div class="card-header bg-success text-white">
      <h5 class="mb-0"><i class="bi bi-star-fill"></i> Most Sold Products</h5>
    </div>
    <div class="card-body p-3">
      @if($mostSoldProducts->isEmpty())
        <p class="text-center text-muted mb-0">No sales data available.</p>
      @else
        <ul class="list-group list-group-flush">
          @foreach($mostSoldProducts as $productName => $data)
          <li class="list-group-item d-flex justify-content-between align-items-center">
            {{ $productName }}
            <span class="badge bg-success rounded-pill">{{ $data['total_quantity'] }}</span>
          </li>
          @endforeach
        </ul>
      @endif
    </div>
  </div>
</div>

<script>
  function toggleCustomDates() {
    const period = document.getElementById('period').value;
    const showCustom = period === 'custom';
    document.getElementById('fromDateDiv').style.display = showCustom ? 'block' : 'none';
    document.getElementById('toDateDiv').style.display = showCustom ? 'block' : 'none';
  }
  document.addEventListener('DOMContentLoaded', toggleCustomDates);
</script>
@endsection
