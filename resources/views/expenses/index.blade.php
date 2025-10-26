{{-- @extends('layouts.app')

@section('content')
<div class="container mt-5">
  <div class="card shadow-lg border-0">
    <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
      <h4 class="mb-0"><i class="bi bi-list-check"></i> Recorded Expenses</h4>
      <a href="{{ url('/expenses/create') }}" class="btn btn-light btn-sm">
        <i class="bi bi-plus-circle"></i> Add Expense
      </a>
    </div>

    <div class="card-body">
      @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
          <i class="bi bi-check-circle-fill me-2"></i> {{ session('success') }}
          <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
      @endif

      @if($expenses->isEmpty())
        <div class="alert alert-warning text-center">
          <i class="bi bi-exclamation-triangle"></i> No expenses recorded yet.
        </div>
      @else
        <div class="table-responsive">
          <table class="table table-striped table-hover align-middle">
            <thead class="table-primary">
              <tr>
                <th>#</th>
                <th>Title</th>
                <th>Amount (UGX)</th>
                <th>Category</th>
                <th>Date</th>
                <th>Description</th>
                <th>Actions</th>
              </tr>
            </thead>
            <tbody>
              @foreach ($expenses as $expense)
              <tr>
                <td>{{ $loop->iteration + ($expenses->currentPage() - 1) * $expenses->perPage() }}</td>
                <td>{{ $expense->title }}</td>
                <td>{{ number_format($expense->amount) }}</td>
                <td>{{ $expense->category }}</td>
                <td>{{ \Carbon\Carbon::parse($expense->date)->format('d-M-Y') }}</td>
                <td>{{ $expense->description ?? '-' }}</td>
                <td>
                  <form action="{{ route('employee.expenses.destroy', $expense->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this expense?');">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger btn-sm">
                      <i class="bi bi-trash"></i> Delete
                    </button>
                  </form>
                </td>
              </tr>
              @endforeach
            </tbody>
          </table>
        </div>

        <div class="d-flex justify-content-center">
          {{ $expenses->links() }}
        </div>
      @endif
    </div>
  </div>
</div>
@endsection --}}
@extends('layouts.app')

@section('content')
<div class="container mt-0">
  <div class="card shadow-lg border-0">
    <div class="card-header bg-primary text-white d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center">
      <h4 class="mb-2 mb-md-0"><i class="bi bi-list-check"></i> Recorded Expenses</h4>
      <div class="d-flex flex-wrap gap-2">
        <a href="/expenses/create" class="btn btn-light btn-sm">
          <i class="bi bi-plus-circle"></i> Add Expense
        </a>
        <a href="{{ route('employee.dashboard') }}" class="btn btn-light btn-sm">
          <i class="bi bi-arrow-left-circle"></i> Back to Dashboard
        </a>
      </div>
    </div>

    <div class="card-body">
      @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
          <i class="bi bi-check-circle-fill me-2"></i> {{ session('success') }}
          <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
      @endif

      @if($expenses->isEmpty())
        <div class="alert alert-warning text-center">
          <i class="bi bi-exclamation-triangle"></i> No expenses recorded yet.
        </div>
      @else
        <div class="table-responsive">
          <table class="table table-striped table-hover align-middle">
            <thead class="table-primary">
              <tr>
                <th>#</th>
                <th>Title</th>
                <th>Amount (UGX)</th>
                <th>Category</th>
                <th>Date</th>
                <th>Description</th>
                <th class="text-center">Actions</th>
              </tr>
            </thead>
            <tbody>
              @foreach ($expenses as $expense)
              <tr>
                <td>{{ $loop->iteration + ($expenses->currentPage() - 1) * $expenses->perPage() }}</td>
                <td>{{ $expense->title }}</td>
                <td>{{ number_format($expense->amount) }}</td>
                <td>{{ $expense->category }}</td>
                <td>{{ \Carbon\Carbon::parse($expense->date)->format('d-M-Y') }}</td>
                <td>{{ $expense->description ?? '-' }}</td>
                <td class="text-center">
                  <div class="d-flex justify-content-center gap-2">
                    <a href="{{ route('employee.expenses.edit', $expense->id) }}" class="btn btn-warning btn-sm">
                      <i class="bi bi-pencil-square"></i> Edit
                    </a>
                    <form action="{{ route('employee.expenses.destroy', $expense->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this expense?');">
                      @csrf
                      @method('DELETE')
                      <button type="submit" class="btn btn-danger btn-sm">
                        <i class="bi bi-trash"></i> Delete
                      </button>
                    </form>
                  </div>
                </td>
              </tr>
              @endforeach
            </tbody>
          </table>
        </div>

        <div class="d-flex justify-content-center">
          {{ $expenses->links() }}
        </div>
      @endif
    </div>
  </div>
</div>
@endsection
