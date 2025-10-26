@extends('layouts.app')

@section('head')
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
<style>
  @media print {
    body * {
      visibility: hidden;
    }
    #receipt, #receipt * {
      visibility: visible;
    }
    #receipt {
      position: absolute;
      top: 0;
      left: 0;
      width: 100%;
      padding: 20px;
      font-size: 16px;
    }
  }
</style>
@endsection

@section('content')
<div class="container mt-5">
  <div class="card shadow-lg border-0">
    <div class="card-header bg-success text-white d-flex justify-content-between align-items-center">
      <h4 class="mb-0"><i class="bi bi-plus-circle"></i> Record New Sale</h4>
      <a href="{{ route('employee.dashboard') }}" class="btn btn-light btn-sm">
        <i class="bi bi-arrow-left-circle"></i> Back to Dashboard
      </a>
    </div>

    <div class="card-body">
      {{-- Success Alert --}}
      @if(session('success'))
        <div class="alert alert-success d-flex justify-content-between align-items-center">
          <div><i class="bi bi-check-circle"></i> Sale recorded successfully!</div>
          <button class="btn btn-outline-success btn-sm" onclick="window.print()">
            <i class="bi bi-printer"></i> Print Receipt
          </button>
        </div>

        {{-- Receipt Preview --}}
        <div id="receipt" class="p-3 bg-light border rounded">
          <h5 class="mb-3"><i class="bi bi-receipt"></i> Receipt Preview</h5>

          <p class="fw-semibold">Dear our Esteemed Customer,</p>
          <p>Thanks for purchasing our product <strong>{{ session('receipt.product') }}</strong>.</p>
          <p>Below is your transaction summary:</p>

          <ul class="list-group mb-3">
            <li class="list-group-item d-flex justify-content-between">
              <span><i class="bi bi-box-seam"></i> Product:</span>
              <span>{{ session('receipt.product') }}</span>
            </li>
            <li class="list-group-item d-flex justify-content-between">
              <span><i class="bi bi-cash-stack"></i> Price per unit:</span>
              <span>UGX {{ number_format(session('receipt.price')) }}</span>
            </li>
            <li class="list-group-item d-flex justify-content-between">
              <span><i class="bi bi-123"></i> Quantity:</span>
              <span>{{ session('receipt.quantity') }}</span>
            </li>
            <li class="list-group-item d-flex justify-content-between">
              <span><i class="bi bi-wallet2"></i> Total Paid:</span>
              <span>UGX {{ number_format(session('receipt.amount')) }}</span>
            </li>
            <li class="list-group-item d-flex justify-content-between">
              <span><i class="bi bi-calendar-check"></i> Date:</span>
              <span>{{ session('receipt.date') }}</span>
            </li>
            <li class="list-group-item d-flex justify-content-between">
              <span><i class="bi bi-person-check"></i> Processed by:</span>
              <span>{{ auth()->user()->name }}</span>
            </li>
          </ul>

          <p class="text-muted mt-2">We appreciate your business. Keep the receipt for reference.</p>
        </div>
      @endif

      {{-- Error Alert --}}
      @if(session('error'))
        <div class="alert alert-danger">
          <i class="bi bi-exclamation-circle"></i> {{ session('error') }}
        </div>
      @endif

      {{-- Sale Form --}}
      <form id="saleForm" action="{{ route('employee.sales.store') }}" method="POST" class="row g-3 mt-3">
        @csrf

        <div class="col-md-6">
          <label for="product_id" class="form-label fw-semibold"><i class="bi bi-box"></i> Product</label>
          <select id="product_id" name="product_id" class="form-select" required onchange="updateProductDetails()">
            <option value="">-- Select Product --</option>
            @foreach ($products as $product)
              <option value="{{ $product->id }}"
                      data-price="{{ $product->price }}"
                      data-stock="{{ $product->quantity }}"
                      data-name="{{ $product->name }}">
                {{ $product->name }}
              </option>
            @endforeach
          </select>
        </div>

        <div class="col-md-6">
          <label for="stock_display" class="form-label fw-semibold"><i class="bi bi-pie-chart"></i> In-Stock Qty</label>
          <input type="text" id="stock_display" class="form-control bg-light" readonly placeholder="Choose product">
        </div>

        <div class="col-md-6">
          <label for="price_display" class="form-label fw-semibold"><i class="bi bi-cash-stack"></i> Reserved Price (UGX)</label>
          <input type="text" id="price_display" class="form-control bg-light" readonly placeholder="Choose product">
        </div>

        <div class="col-md-3">
          <label for="quantity" class="form-label fw-semibold"><i class="bi bi-123"></i> Quantity Sold</label>
          <input type="number" id="quantity" name="quantity" class="form-control"
                 min="1" required oninput="updateMinimumPrice(); validateForm();">
        </div>

        <div class="col-md-3">
          <label for="amount_display" class="form-label fw-semibold"><i class="bi bi-currency-exchange"></i> Amount Paid (UGX)</label>
          <input type="text" id="amount_display" class="form-control" required
                 oninput="formatAmountInput(this)">
          <input type="hidden" id="amount_sold" name="amount_sold">
        </div>

        <div class="col-md-6">
          <label for="suggested_total" class="form-label fw-semibold"><i class="bi bi-calculator"></i> Minimum Expected (UGX)</label>
          <input type="text" id="suggested_total" class="form-control bg-light text-success" readonly>
        </div>

        <div class="col-12 d-flex justify-content-end">
          <button id="submitBtn" type="button" class="btn btn-success px-4" disabled onclick="confirmSubmit()">
            <i class="bi bi-send-check"></i> Submit Sale
          </button>
        </div>
      </form>
    </div>
  </div>
</div>

{{-- Confirmation Modal --}}
<div class="modal fade" id="confirmModal" tabindex="-1">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title"><i class="bi bi-question-circle"></i> Confirm Sale</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">Are you sure you want to record this sale?</div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
        <button type="button" class="btn btn-success" onclick="document.getElementById('saleForm').submit()">Yes, Submit</button>
      </div>
    </div>
  </div>
</div>

{{-- Scripts --}}
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script>
  const productSelect = document.getElementById('product_id');
  const stockDisplay = document.getElementById('stock_display');
  const priceDisplay = document.getElementById('price_display');
  const quantityInput = document.getElementById('quantity');
  const amountHiddenInput = document.getElementById('amount_sold');
  const amountDisplay = document.getElementById('amount_display');
  const suggestedTotal = document.getElementById('suggested_total');
  const submitBtn = document.getElementById('submitBtn');

  let selectedPrice = 0;

  function formatUGX(amount) {
    return new Intl.NumberFormat('en-UG', {
      style: 'currency',
      currency: 'UGX',
      minimumFractionDigits: 0
    }).format(amount);
  }

  function updateProductDetails() {
    const opt = productSelect.options[productSelect.selectedIndex];
    if (!opt.value) {
      stockDisplay.value = '';
      priceDisplay.value = '';
      selectedPrice = 0;
      updateMinimumPrice();
      validateForm();
      return;
    }

    selectedPrice = parseInt(opt.getAttribute('data-price')) || 0;
    const stock = parseInt(opt.getAttribute('data-stock')) || 0;

    stockDisplay.value = stock;
    priceDisplay.value = selectedPrice ? formatUGX(selectedPrice) : '';
    updateMinimumPrice();
    validateForm();
  }

  function updateMinimumPrice() {
    const qty = Math.max(0, parseInt(quantityInput.value) || 0);
    const total = selectedPrice * qty;
    suggestedTotal.value = qty ? formatUGX(total) : '';
  }

  function formatAmountInput(input) {
    const raw = input.value.replace(/[^\d]/g, '');
    const formatted = new Intl.NumberFormat().format(raw);
    input.value = formatted;
    amountHiddenInput.value = raw;
    validateForm();
  }

  function validateForm() {
    const qty = parseInt(quantityInput.value) || 0;
    const amt = parseInt(amountHiddenInput.value) || 0;
    const stock = parseInt(stockDisplay.value) || 0;
    const minTotal = selectedPrice * qty;

    const sufficientStock = qty > 0 && qty <= stock;
    const priceOk = amt >= minTotal;

    submitBtn.disabled = !(sufficientStock && priceOk);
  }

  function confirmSubmit() {
    new bootstrap.Modal(document.getElementById('confirmModal')).show();
  }
</script>
@endsection
