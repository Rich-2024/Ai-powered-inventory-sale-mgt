@extends('layouts.app')

@section('head')
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" />
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet" />
@endsection

@section('content')
<div class="container mt-0">
  <div class="card shadow-lg border-0">

    {{-- Header with page title and action buttons --}}
    <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
      <h4 class="mb-0"><i class="bi bi-wallet2"></i> Record Business Expense</h4>
      <div>
          <a href="{{ route('employee.expenses.index') }}" class="btn btn-light btn-sm">
          <i class="bi bi-card-list"></i> View My Expenses
        </a>
        <a href="/employee/sales/history " class="btn btn-light btn-sm me-2">
          <i class="bi bi-arrow-left-circle"></i> Back to Report Section
        </a>
        <a href="{{ route('employee.dashboard') }}" class="btn btn-light btn-sm">
          <i class="bi bi-house-door"></i> Back to Dashboard
        </a>
      </div>
    </div>

    {{-- Card body with form --}}
    <div class="card-body">

      {{-- Success message --}}
      @if(session('success'))
      <div class="alert alert-success alert-dismissible fade show" role="alert">
        <i class="bi bi-check-circle-fill me-2"></i>
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
      </div>
      @endif

      <form action="{{ route('employee.expenses.store') }}" method="POST" class="row g-3" novalidate>
        @csrf

        <div class="col-md-6">
          <label for="title" class="form-label fw-semibold text-primary">Title</label>
          <input type="text" name="title" id="title" class="form-control @error('title') is-invalid @enderror" value="{{ old('title') }}" required>
          @error('title')
          <div class="invalid-feedback">{{ $message }}</div>
          @enderror
        </div>

        <div class="col-md-6">
          <label for="amount" class="form-label fw-semibold text-primary">Amount (UGX)</label>
          <input type="number" step="0.01" min="0" name="amount" id="amount" class="form-control @error('amount') is-invalid @enderror" value="{{ old('amount') }}" required>
          @error('amount')
          <div class="invalid-feedback">{{ $message }}</div>
          @enderror
        </div>

        <div class="col-md-6">
          <label for="category" class="form-label fw-semibold text-primary">Category</label>
          <select name="category" id="category" class="form-select @error('category') is-invalid @enderror" required>
            <option value="" disabled selected>-- Select Category --</option>
            <option value="Transport" {{ old('category') == 'Transport' ? 'selected' : '' }}>Transport</option>
            <option value="Supplies" {{ old('category') == 'Supplies' ? 'selected' : '' }}>Supplies</option>
            <option value="Maintenance" {{ old('category') == 'Maintenance' ? 'selected' : '' }}>Maintenance</option>
            <option value="Miscellaneous" {{ old('category') == 'Miscellaneous' ? 'selected' : '' }}>well fare</option>
          </select>
          @error('category')
          <div class="invalid-feedback">{{ $message }}</div>
          @enderror
        </div>

        <div class="col-md-6">
          <label for="date" class="form-label fw-semibold text-primary">Date</label>
          <input type="date" name="date" id="date" class="form-control @error('date') is-invalid @enderror" value="{{ old('date', now()->toDateString()) }}" required>
          @error('date')
          <div class="invalid-feedback">{{ $message }}</div>
          @enderror
        </div>

        <div class="col-12">
          <label for="description" class="form-label fw-semibold text-primary">Description (optional)</label>
          <textarea name="description" id="description" rows="3" class="form-control @error('description') is-invalid @enderror" placeholder="Add any additional notes...">{{ old('description') }}</textarea>
          @error('description')
          <div class="invalid-feedback">{{ $message }}</div>
          @enderror
        </div>

        <div class="col-12 text-end">
          <button type="submit" class="btn btn-primary">
            <i class="bi bi-save me-1"></i> Save Expense
          </button>
        </div>
      </form>
    </div>

  </div>
</div>
@endsection
