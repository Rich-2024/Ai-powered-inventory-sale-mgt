@extends('layouts.app')

@section('head')
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
@endsection

@section('content')
<div class="container mt-4">
  <div class="card shadow">
    <div class="card-header bg-warning text-dark d-flex justify-content-between align-items-center">
      <h4 class="mb-0"><i class="bi bi-journal-text"></i> All Credit Sales</h4>
      <a href="{{ route('admin.dashboard') }}" class="btn btn-light btn-sm">
        <i class="bi bi-arrow-left-circle"></i> Back to Dashboard
      </a>
    </div>

    <div class="card-body">
      @if(session('success'))
        <div class="alert alert-success"><i class="bi bi-check-circle"></i> {{ session('success') }}</div>
      @endif

      @if($creditSales->isEmpty())
        <div class="alert alert-info"><i class="bi bi-info-circle"></i> No credit sales found.</div>
      @else
        <div class="table-responsive">
          <table class="table table-bordered align-middle">
            <thead class="table-dark">
              <tr>
                <th>Client</th>
                <th>Product</th>
                <th>Qty</th>
                <th>Total (UGX)</th>
                <th>Status</th>
                <th>Actions</th>
              </tr>
            </thead>
            <tbody>
              @foreach($creditSales as $sale)
              <tr>
                <td>{{ $sale->client_name }}</td>
                <td>{{ $sale->product->name ?? 'N/A' }}</td>
                <td>{{ $sale->quantity }}</td>
                <td>UGX {{ number_format($sale->total_amount) }}</td>
                <td>
                  @if($sale->status === 'pending')
                    <span class="badge bg-warning text-dark">Pending</span>
                  @elseif($sale->status === 'paid')
                    <span class="badge bg-success">Paid</span>
                  @elseif($sale->status === 'returned')
                    <span class="badge bg-secondary">Returned</span>
                  @endif
                </td>
                <td>
                  @if($sale->status === 'pending')
                    <form method="POST" action="{{ route('credit.sales.paid', $sale->id) }}" class="d-inline">
                      @csrf
                      @method('PATCH')
                      <button class="btn btn-success btn-sm" onclick="return confirm('Mark as fully paid?')">
                        <i class="bi bi-check-circle"></i> Paid
                      </button>
                    </form>

                    <form method="POST" action="{{ route('credit.sales.returned', $sale->id) }}" class="d-inline">
                      @csrf
                      @method('PATCH')
                      <button class="btn btn-secondary btn-sm" onclick="return confirm('Mark as returned and restock?')">
                        <i class="bi bi-arrow-counterclockwise"></i> Returned
                      </button>
                    </form>
                  @else
                    <span class="text-muted">No actions</span>
                  @endif
                </td>
              </tr>
              @endforeach
            </tbody>
          </table>
        </div>
      @endif
    </div>
  </div>
</div>
@endsection
