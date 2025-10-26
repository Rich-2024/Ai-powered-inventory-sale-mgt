@extends('layouts.app')

@section('content')
<div class="container">
    <h3 class="mb-4">Admin Sales & Expenses</h3>

    @foreach ($sales as $sale)
        <div class="card mb-3 shadow-sm">
            <div class="card-header bg-primary text-white">
                <strong>{{ $sale->product->name }}</strong>
                — UGX {{ number_format($sale->total_amount) }}
            </div>
            <div class="card-body">
                <p><strong>Quantity:</strong> {{ $sale->quantity }}</p>
                <p><strong>Sold By:</strong> {{ $sale->user->name }}</p>
                <p><strong>Date:</strong> {{ $sale->created_at->format('Y-m-d H:i') }}</p>

                @php
                    $matchedExpense = $expenses[$sale->id][0] ?? null;
                @endphp

                @if ($matchedExpense)
                    <div class="alert alert-info">
                        <strong>Expense:</strong> UGX {{ number_format($matchedExpense->amount) }} <br>
                        <em>{{ $matchedExpense->title }} — {{ $matchedExpense->description }}</em>
                        <p><strong>Net Profit:</strong> UGX {{ number_format($sale->total_amount - $matchedExpense->amount) }}</p>
                    </div>
                @else
                    <form action="{{ route('admin.sales.expense.link', $sale->id) }}" method="POST">
                        @csrf
                        <div class="row">
                            <div class="col-md-4">
                                <input type="number" name="amount" class="form-control" placeholder="Expense Amount" required>
                            </div>
                            <div class="col-md-4">
                                <input type="text" name="title" class="form-control" placeholder="Title (optional)">
                            </div>
                            <div class="col-md-4">
                                <button type="submit" class="btn btn-outline-primary btn-sm">
                                    <i class="bi bi-save"></i> Record Expense
                                </button>
                            </div>
                        </div>
                    </form>
                @endif
            </div>
        </div>
    @endforeach
</div>
@endsection
