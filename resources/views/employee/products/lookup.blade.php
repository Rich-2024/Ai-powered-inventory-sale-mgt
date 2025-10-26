@extends('layouts.app')

@section('head')
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
  <style>
    #results {
      max-height: 200px;
      overflow-y: auto;
      cursor: pointer;
    }
    #results li:hover {
      background-color: #f8f9fa;
    }
  </style>
@endsection

@section('content')
<div class="container mt-5">
  <div class="card shadow-lg border-0">
    <div class="card-header bg-info text-white d-flex justify-content-between align-items-center">
      <h4 class="mb-0"><i class="bi bi-search"></i> Product Price Lookup</h4>
      <a href="{{ route('employee.dashboard') }}" class="btn btn-light btn-sm">
        <i class="bi bi-arrow-left-circle"></i> Back to Dashboard
      </a>
    </div>

    <div class="card-body">
      {{-- Search Input --}}
      <div class="mb-3">
        <label class="form-label fw-semibold"><i class="bi bi-search"></i> Search Product</label>
        <input type="text" id="searchInput" class="form-control" placeholder="Type product name...">
        <ul id="results" class="list-group mt-2 d-none"></ul>
      </div>

      {{-- Product Info Display --}}
      <div id="productInfo" class="d-none mt-4 border rounded p-3 bg-light">
        <h5 class="mb-3"><i class="bi bi-box"></i> Product Details</h5>
        <p><strong>Name:</strong> <span id="productName"></span></p>
        <p><strong>Price:</strong> UGX <span id="productPrice"></span></p>
        <p><strong>Available Stock:</strong> <span id="productStock"></span> units</p>
      </div>
    </div>
  </div>
</div>

{{-- JS Script --}}
<script>
  const products = @json($products);
  const searchInput = document.getElementById('searchInput');
  const resultsList = document.getElementById('results');
  const productInfo = document.getElementById('productInfo');
  const nameEl = document.getElementById('productName');
  const priceEl = document.getElementById('productPrice');
  const stockEl = document.getElementById('productStock');

  searchInput.addEventListener('input', function () {
    const query = this.value.toLowerCase();
    resultsList.innerHTML = '';

    if (!query) {
      resultsList.classList.add('d-none');
      return;
    }

    const matched = products.filter(p => p.name.toLowerCase().includes(query));

    if (matched.length) {
      resultsList.classList.remove('d-none');
      matched.forEach(product => {
        const item = document.createElement('li');
        item.classList.add('list-group-item');
        item.textContent = product.name;
        item.onclick = () => showProduct(product);
        resultsList.appendChild(item);
      });
    } else {
      resultsList.classList.remove('d-none');
      const noMatch = document.createElement('li');
      noMatch.classList.add('list-group-item', 'text-muted');
      noMatch.textContent = 'No matching product found.';
      resultsList.appendChild(noMatch);
    }
  });

  function showProduct(product) {
    nameEl.textContent = product.name;
    priceEl.textContent = new Intl.NumberFormat().format(product.price);
    stockEl.textContent = product.quantity;

    productInfo.classList.remove('d-none');
    resultsList.classList.add('d-none');
    searchInput.value = product.name;
  }
</script>
@endsection
