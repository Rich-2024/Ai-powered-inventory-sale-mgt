@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-blue-50 via-white to-blue-50 py-0">
    <!-- Header Section -->
   <!-- CSRF Token meta (put this in your <head>) -->
<meta name="csrf-token" content="{{ csrf_token() }}">

<div class="w-full bg-white shadow-md border-b border-blue-100 mb-8">
  <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
    <div class="flex flex-col lg:flex-row justify-between items-start lg:items-center gap-2">
      <!-- Left side: Title + subtitle -->
      <div class="w-full lg:w-auto">
        {{-- <h1 class="text-3xl sm:text-4xl font-bold text-gray-900 mb-2 flex items-center gap-3">
          <!-- UPLOAD ICON swapped in here -->
          <svg class="w-8 h-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/>
          </svg>
          Upload Inventory
        </h1> --}}
        <p class="text-base sm:text-lg text-gray-600 max-w-md">Add multiple products to your inventory in one go</p>
      </div>

      <!-- Right side: badges, download, and upload form -->
      <div class="flex flex-col sm:flex-row items-center gap-4 w-full lg:w-auto">
        <div class="flex items-center gap-2 bg-blue-50 px-4 py-3 rounded-xl border border-blue-200 whitespace-nowrap">


        <a href="{{ route('inventory.download.template') }}"
           class="inline-flex items-center justify-center gap-2 bg-green-600 hover:bg-green-700 text-white px-4 py-3 rounded-xl transition-all duration-200 shadow-md hover:shadow-lg transform hover:scale-[1.02] font-medium whitespace-nowrap">
          <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/>
          </svg>
          Download Template
        </a>

        <!-- Upload Form -->
    <!-- Make sure CSRF token is included -->
<form action="{{ route('inventory.bulk.upload') }}"
      method="POST"
      enctype="multipart/form-data"
      class="flex items-center gap-2 w-full sm:w-auto max-w-xs sm:max-w-none">

    @csrf

    <input
        type="file"
        name="inventory_file"
        accept=".csv"
        required
        class="border border-gray-300 rounded px-3 py-2 w-full sm:w-auto text-sm sm:text-base"
        aria-label="Select inventory file to upload"
    />

    <button
        type="submit"
        class="flex items-center gap-2 bg-blue-600 hover:bg-blue-700
               disabled:bg-blue-400 disabled:cursor-not-allowed text-white
               px-4 py-2 rounded transition font-semibold">
        Upload
    </button>
</form>

<!-- Optional status message -->
@if(session('message'))
    <p class="mt-3 text-sm text-gray-600">{{ session('message') }}</p>
@endif


<!-- For status message -->
<p id="uploadStatus" class="mt-3 text-sm text-gray-600"></p>

      </div>
    </div>

    <!-- Success/Error message -->
    <div class="mt-4">
      <p id="message" class="hidden text-center font-semibold text-sm"></p>
    </div>
  </div>
</div>
    <!-- Main Content -->
    <div class="w-full px-4 sm:px-6 lg:px-8">
        <div class="max-w-7xl mx-auto">
            <!-- Success Message -->
            @if(session('success'))
                <div class="mb-6 p-4 sm:p-6 bg-green-50 border-l-4 border-green-500 rounded-xl shadow-sm">
                    <div class="flex items-start gap-3">
                        <svg class="w-6 h-6 text-green-600 mt-0.5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                        </svg>
                        <div class="flex-1 min-w-0">
                            <h3 class="text-base sm:text-lg font-semibold text-green-800 mb-1">Inventory Upload Successful!</h3>
                            <p class="text-sm sm:text-base text-green-700 break-words">{{ session('success') }}</p>
                        </div>
                    </div>
                </div>
            @endif

            <!-- Error Messages -->
            @if($errors->any())
                <div class="mb-6 p-4 sm:p-6 bg-red-50 border-l-4 border-red-500 rounded-xl shadow-sm">
                    <div class="flex items-start gap-3">
                        <svg class="w-6 h-6 text-red-600 mt-0.5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                        </svg>
                        <div class="flex-1 min-w-0">
                            <h3 class="text-base sm:text-lg font-semibold text-red-800 mb-2">Please correct the following errors:</h3>
                            <ul class="text-sm sm:text-base text-red-700 list-disc list-inside space-y-1">
                                @foreach($errors->all() as $error)
                                    <li class="break-words">{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
            @endif

            <!-- Form Card -->
            <div class="bg-white rounded-2xl shadow-xl border border-blue-100 overflow-hidden">
                <div class="bg-gradient-to-r from-blue-600 to-blue-700 px-4 sm:px-8 py-5 sm:py-6">
                    <h2 class="text-xl sm:text-2xl font-semibold text-white flex items-center gap-2 sm:gap-3">
                        <svg class="w-5 h-5 sm:w-6 sm:h-6 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M9 19l3 3m0 0l3-3m-3 3V10"/>
                        </svg>
                        <span>Product Information</span>
                    </h2>
                </div>

                <form method="POST" action="{{ route('inventory.upload.process') }}" class="p-4 sm:p-6 lg:p-8">
                    @csrf

                    <div id="products-container" class="space-y-6">
                        <!-- Initial Product Item -->
                        <div class="product-item border-2 border-blue-100 rounded-2xl p-4 sm:p-6 bg-gradient-to-br from-blue-50 to-white shadow-sm hover:shadow-md transition-shadow duration-200" data-index="0">
                            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-12 gap-4 sm:gap-6">
                                <!-- SKU with Scanner -->
                                <div class="sm:col-span-2 lg:col-span-3">
                                    <label class="block text-sm font-semibold text-gray-900 mb-2 flex items-center gap-2">
                                        <svg class="w-4 h-4 text-blue-600 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V8a2 2 0 00-2-2h-5m-4 0V5a2 2 0 114 0v1m-4 0a2 2 0 104 0m-5 8a2 2 0 100-4 2 2 0 000 4zm0 0c1.306 0 2.417.835 2.83 2M9 14a3.001 3.001 0 00-2.83 2M15 11h3m-3 4h2"/>
                                        </svg>
                                        <span>SKU *</span>
                                    </label>
                                    <div class="flex gap-2">
                                        <input type="text" name="products[0][sku]" class="sku-input flex-1 min-w-0 border-2 border-blue-200 rounded-xl px-3 sm:px-4 py-2.5 sm:py-3 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all text-sm sm:text-base" required placeholder="e.g., PROD001">
                                        <button type="button" class="scan-btn bg-blue-600 hover:bg-blue-700 text-white px-3 sm:px-4 py-2.5 sm:py-3 rounded-xl transition-colors flex items-center gap-2 flex-shrink-0 shadow-md hover:shadow-lg" title="Scan Barcode">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01M5 8h2a1 1 0 001-1V5a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1zm12 0h2a1 1 0 001-1V5a1 1 0 00-1-1h-2a1 1 0 00-1 1v2a1 1 0 001 1zM5 20h2a1 1 0 001-1v-2a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1z"/>
                                            </svg>
                                            <span class="hidden sm:inline text-sm">Scan</span>
                                        </button>
                                    </div>
                                </div>

                                <!-- Product Name -->
                                <div class="sm:col-span-2 lg:col-span-4">
                                    <label class="block text-sm font-semibold text-gray-900 mb-2 flex items-center gap-2">
                                        <svg class="w-4 h-4 text-blue-600 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/>
                                        </svg>
                                        <span>Product Name *</span>
                                    </label>
                                    <input type="text" name="products[0][name]" required class="w-full border-2 border-blue-200 rounded-xl px-3 sm:px-4 py-2.5 sm:py-3 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all text-sm sm:text-base" placeholder="e.g., Apple iPhone 14">
                                </div>

                                <!-- Quantity -->
                                <div class="sm:col-span-1 lg:col-span-2">
                                    <label class="block text-sm font-semibold text-gray-900 mb-2 flex items-center gap-2">
                                        <svg class="w-4 h-4 text-blue-600 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                                        </svg>
                                        <span>Quantity *</span>
                                    </label>
                                    <input type="number" name="products[0][quantity]" class="quantity-input w-full border-2 border-blue-200 rounded-xl px-3 sm:px-4 py-2.5 sm:py-3 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all text-sm sm:text-base" min="1" required placeholder="0">
                                </div>

                                <!-- Unit Selection -->
                                <div class="sm:col-span-1 lg:col-span-2">
                                    <label class="block text-sm font-semibold text-gray-900 mb-2 flex items-center gap-2">
                                        <svg class="w-4 h-4 text-blue-600 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                                        </svg>
                                        <span>Unit</span>
                                    </label>
                                    <select name="products[0][unit]" class="unit-select w-full border-2 border-blue-200 rounded-xl px-3 sm:px-4 py-2.5 sm:py-3 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all text-sm sm:text-base">
                                        <option value="piece" selected>Piece</option>
                                        <option value="dozen">Dozen (12)</option>
                                        <option value="carton">Carton (24)</option>
                                    </select>
                                </div>

                                <!-- Remove Button -->
                                <div class="sm:col-span-2 lg:col-span-1 flex items-end justify-start lg:justify-end">
                                    <button type="button" class="remove-product w-full sm:w-auto bg-red-600 hover:bg-red-700 text-white px-4 py-2.5 sm:py-3 rounded-xl transition-all shadow-md hover:shadow-lg disabled:opacity-50 disabled:cursor-not-allowed flex items-center justify-center gap-2 text-sm font-medium" disabled aria-disabled="true">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                        </svg>
                                        <span>Delete</span>
                                    </button>
                                </div>

                                <!-- Bulk Purchase Price -->
                                <div class="sm:col-span-1 lg:col-span-3 bulk-group hidden">
                                    <label class="block text-sm font-semibold text-gray-900 mb-2">
                                        Bulk Purchase Price
                                        <span class="text-xs text-gray-500 bulk-label"></span>
                                    </label>
                                    <div class="relative">
                                        <span class="absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-500 text-sm sm:text-base">$</span>
                                        <input type="text" name="products[0][purchase_price_bulk]" class="bulk-purchase number-input w-full border-2 border-blue-200 rounded-xl pl-8 pr-3 sm:pr-4 py-2.5 sm:py-3 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all text-sm sm:text-base" placeholder="0.00">
                                    </div>
                                </div>

                                <!-- Bulk Selling Price -->
                                <div class="sm:col-span-1 lg:col-span-3 bulk-group hidden">
                                    <label class="block text-sm font-semibold text-gray-900 mb-2">
                                        Bulk Selling Price
                                        <span class="text-xs text-gray-500 bulk-label"></span>
                                    </label>
                                    <div class="relative">
                                        <span class="absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-500 text-sm sm:text-base">$</span>
                                        <input type="text" name="products[0][selling_price_bulk]" class="bulk-sell number-input w-full border-2 border-blue-200 rounded-xl pl-8 pr-3 sm:pr-4 py-2.5 sm:py-3 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all text-sm sm:text-base" placeholder="0.00">
                                    </div>
                                </div>

                                <!-- Per-piece Purchase -->
                                <div class="sm:col-span-1 lg:col-span-3">
                                    <label class="block text-sm font-semibold text-gray-900 mb-2">Purchase Price (per piece)</label>
                                    <div class="relative">
                                        <span class="absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-500 text-sm sm:text-base">$</span>
                                        <input type="text" name="products[0][purchase_price]" class="per-piece-purchase number-input w-full border-2 border-blue-200 rounded-xl pl-8 pr-3 sm:pr-4 py-2.5 sm:py-3 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all text-sm sm:text-base" placeholder="0.00">
                                    </div>
                                </div>

                                <!-- Per-piece Sell -->
                                <div class="sm:col-span-1 lg:col-span-3">
                                    <label class="block text-sm font-semibold text-gray-900 mb-2">Selling Price (per piece)</label>
                                    <div class="relative">
                                        <span class="absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-500 text-sm sm:text-base">$</span>
                                        <input type="text" name="products[0][price]" class="per-piece-sell number-input w-full border-2 border-blue-200 rounded-xl pl-8 pr-3 sm:pr-4 py-2.5 sm:py-3 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all text-sm sm:text-base" placeholder="0.00">
                                    </div>
                                </div>

                                <!-- Profit Margin Display -->
                                <div class="sm:col-span-2 lg:col-span-12 mt-2 sm:mt-4 profit-display hidden">
                                    <div class="bg-gradient-to-r from-green-50 to-blue-50 border-2 border-green-200 rounded-2xl p-4 sm:p-6">
                                        <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 sm:gap-6">
                                            <div class="text-center">
                                                <div class="text-xs sm:text-sm font-medium text-gray-700 mb-1">Profit per piece</div>
                                                <div class="profit-amount text-lg sm:text-xl font-bold text-blue-700">$0.00</div>
                                            </div>
                                            <div class="text-center">
                                                <div class="text-xs sm:text-sm font-medium text-gray-700 mb-1">Margin</div>
                                                <div class="profit-margin text-lg sm:text-xl font-bold text-green-700">0%</div>
                                            </div>
                                            <div class="text-center">
                                                <div class="text-xs sm:text-sm font-medium text-gray-700 mb-1">Total Profit</div>
                                                <div class="total-profit text-lg sm:text-xl font-bold text-purple-700">$0.00</div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Action Buttons -->
                    <div class="mt-6 sm:mt-8 flex flex-col sm:flex-row justify-between gap-3 sm:gap-4">
                        <button type="button" id="add-product" class="w-full sm:w-auto bg-blue-600 hover:bg-blue-700 text-white px-6 sm:px-8 py-3 sm:py-4 rounded-2xl transition-all duration-200 shadow-lg hover:shadow-xl transform hover:scale-[1.02] flex items-center justify-center gap-3 font-semibold text-sm sm:text-base">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                            </svg>
                            Add Another Product
                        </button>
                        <button type="submit" class="w-full sm:w-auto bg-green-600 hover:bg-green-700 text-white px-6 sm:px-8 py-3 sm:py-4 rounded-2xl transition-all duration-200 shadow-lg hover:shadow-xl transform hover:scale-[1.02] flex items-center justify-center gap-3 font-semibold text-sm sm:text-base">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M9 19l3 3m0 0l3-3m-3 3V10"/>
                            </svg>
                            Upload Inventory
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Scanner Modal -->
<div id="scanner-modal" class="fixed inset-0 bg-black bg-opacity-75 hidden items-center justify-center z-50 p-4">
    <div class="bg-white p-4 sm:p-8 rounded-2xl shadow-2xl relative max-w-2xl w-full mx-auto">
        <div class="text-center mb-4 sm:mb-6">
            <h3 class="text-xl sm:text-2xl font-semibold text-gray-900 flex items-center justify-center gap-2 sm:gap-3">
                <svg class="w-6 h-6 sm:w-8 sm:h-8 text-blue-600 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01M5 8h2a1 1 0 001-1V5a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1zm12 0h2a1 1 0 001-1V5a1 1 0 00-1-1h-2a1 1 0 00-1 1v2a1 1 0 001 1zM5 20h2a1 1 0 001-1v-2a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1z"/>
                </svg>
                <span>Barcode Scanner</span>
            </h3>
            <p class="text-sm sm:text-base text-gray-600 mt-2">Position the barcode within the camera view</p>
        </div>

        <!-- Camera Container -->
        <div class="relative bg-gray-900 rounded-xl overflow-hidden mx-auto" style="max-width: 500px;">
            <video id="barcode-video" class="w-full h-60 sm:h-80 object-cover" autoplay playsinline></video>

            <!-- Scanner Overlay -->
            <div class="absolute inset-0 flex items-center justify-center">
                <div class="border-2 border-white border-dashed rounded-lg w-48 h-24 sm:w-64 sm:h-32 flex items-center justify-center">
                    <div class="text-white text-xs sm:text-sm text-center">
                        <svg class="w-6 h-6 sm:w-8 sm:h-8 mx-auto mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01M5 8h2a1 1 0 001-1V5a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1zm12 0h2a1 1 0 001-1V5a1 1 0 00-1-1h-2a1 1 0 00-1 1v2a1 1 0 001 1zM5 20h2a1 1 0 001-1v-2a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1z"/>
                        </svg>
                        Align barcode here
                    </div>
                </div>
            </div>
        </div>

        <!-- Scanner Controls -->
        <div class="mt-4 sm:mt-6 text-center">
            <p id="scanner-feedback" class="text-xs sm:text-sm min-h-6 mb-4"></p>
            <div class="flex flex-col sm:flex-row gap-3 justify-center">
                <button id="close-scanner" class="bg-red-600 hover:bg-red-700 text-white px-4 sm:px-6 py-2.5 sm:py-3 rounded-xl transition-colors flex items-center justify-center gap-2 font-semibold text-sm shadow-md hover:shadow-lg">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                    Close Scanner
                </button>
                <button id="retry-scan" class="bg-blue-600 hover:bg-blue-700 text-white px-4 sm:px-6 py-2.5 sm:py-3 rounded-xl transition-colors flex items-center justify-center gap-2 font-semibold text-sm hidden shadow-md hover:shadow-lg">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
                    </svg>
                    Scan Again
                </button>
            </div>
        </div>
    </div>
</div>

<script src="https://unpkg.com/@zxing/library@latest"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    let productCount = 1;
    const codeReader = new ZXing.BrowserMultiFormatReader();
    let currentScanner = null;

    // Add new product
    document.getElementById('add-product').addEventListener('click', function() {
        const container = document.getElementById('products-container');
        const template = document.querySelector('.product-item').cloneNode(true);

        template.setAttribute('data-index', productCount);
        template.querySelectorAll('input, select').forEach(input => {
            const name = input.getAttribute('name').replace('[0]', `[${productCount}]`);
            input.setAttribute('name', name);

            if (input.classList.contains('sku-input')) {
                input.value = '';
            }
            if (input.classList.contains('quantity-input')) {
                input.value = '';
            }
            if (input.classList.contains('unit-select')) {
                input.value = 'piece';
            }
            if (input.classList.contains('per-piece-purchase') || input.classList.contains('per-piece-sell')) {
                input.value = '';
                input.readOnly = false;
                input.classList.remove('bg-blue-50');
            }
            if (input.classList.contains('bulk-purchase') || input.classList.contains('bulk-sell')) {
                input.value = '';
            }
        });

        // Reset bulk groups and profit display
        template.querySelectorAll('.bulk-group').forEach(group => group.classList.add('hidden'));
        template.querySelector('.profit-display').classList.add('hidden');

        // Enable remove button for new items
        const removeBtn = template.querySelector('.remove-product');
        removeBtn.disabled = false;
        removeBtn.setAttribute('aria-disabled', 'false');

        container.appendChild(template);
        productCount++;

        // Re-attach event listeners to new elements
        attachEventListeners(template);
    });

    // Remove product
    document.addEventListener('click', function(e) {
        if (e.target.closest('.remove-product') && !e.target.closest('.remove-product').disabled) {
            const productItem = e.target.closest('.product-item');
            if (document.querySelectorAll('.product-item').length > 1) {
                productItem.remove();
            }
        }
    });

    // Unit selection change - Original logic intact
    document.addEventListener('change', function(e) {
        if (e.target.classList.contains('unit-select')) {
            const productItem = e.target.closest('.product-item');
            const unit = e.target.value;
            const bulkGroups = productItem.querySelectorAll('.bulk-group');
            const bulkLabels = productItem.querySelectorAll('.bulk-label');
            const perPiecePurchase = productItem.querySelector('.per-piece-purchase');
            const perPieceSell = productItem.querySelector('.per-piece-sell');

            // Show/hide bulk groups based on unit selection
            bulkGroups.forEach(group => group.classList.toggle('hidden', unit === 'piece'));

            let labelText = '';
            if (unit === 'dozen') labelText = '(per dozen)';
            else if (unit === 'carton') labelText = '(per carton)';

            bulkLabels.forEach(label => label.textContent = labelText);

            // For piece units, allow direct input. For bulk units, make calculated fields read-only
            if (unit === 'piece') {
                perPiecePurchase.readOnly = false;
                perPieceSell.readOnly = false;
                perPiecePurchase.classList.remove('bg-blue-50');
                perPieceSell.classList.remove('bg-blue-50');
            } else {
                perPiecePurchase.readOnly = true;
                perPieceSell.readOnly = true;
                perPiecePurchase.classList.add('bg-blue-50');
                perPieceSell.classList.add('bg-blue-50');
            }

            // Recalculate prices when unit changes
            calculatePrices(productItem);
        }
    });

    // Number input formatting
    document.addEventListener('input', function(e) {
        if (e.target.classList.contains('number-input')) {
            formatNumberInput(e.target);
        }

        // Calculate prices when relevant inputs change
        if (e.target.classList.contains('bulk-purchase') ||
            e.target.classList.contains('bulk-sell') ||
            e.target.classList.contains('per-piece-purchase') ||
            e.target.classList.contains('per-piece-sell') ||
            e.target.classList.contains('quantity-input')) {
            const productItem = e.target.closest('.product-item');
            calculatePrices(productItem);
        }
    });

    // Barcode scanner
    document.addEventListener('click', function(e) {
        if (e.target.closest('.scan-btn')) {
            openScanner(e.target.closest('.scan-btn'));
        }
    });

    document.getElementById('close-scanner').addEventListener('click', closeScanner);
    document.getElementById('retry-scan').addEventListener('click', function() {
        document.getElementById('scanner-feedback').textContent = '';
        document.getElementById('retry-scan').classList.add('hidden');
        startScanning();
    });

    function attachEventListeners(element) {
        element.querySelector('.unit-select').addEventListener('change', function(e) {
            const productItem = e.target.closest('.product-item');
            const unit = e.target.value;
            const bulkGroups = productItem.querySelectorAll('.bulk-group');
            const bulkLabels = productItem.querySelectorAll('.bulk-label');
            const perPiecePurchase = productItem.querySelector('.per-piece-purchase');
            const perPieceSell = productItem.querySelector('.per-piece-sell');

            bulkGroups.forEach(group => group.classList.toggle('hidden', unit === 'piece'));

            let labelText = '';
            if (unit === 'dozen') labelText = '(per dozen)';
            else if (unit === 'carton') labelText = '(per carton)';

            bulkLabels.forEach(label => label.textContent = labelText);

            if (unit === 'piece') {
                perPiecePurchase.readOnly = false;
                perPieceSell.readOnly = false;
                perPiecePurchase.classList.remove('bg-blue-50');
                perPieceSell.classList.remove('bg-blue-50');
            } else {
                perPiecePurchase.readOnly = true;
                perPieceSell.readOnly = true;
                perPiecePurchase.classList.add('bg-blue-50');
                perPieceSell.classList.add('bg-blue-50');
            }

            calculatePrices(productItem);
        });

        element.querySelectorAll('.number-input').forEach(input => {
            input.addEventListener('input', function(e) {
                formatNumberInput(e.target);
                calculatePrices(element);
            });
        });

        element.querySelector('.scan-btn').addEventListener('click', function(e) {
            openScanner(e.target.closest('.scan-btn'));
        });
    }

    function formatNumberInput(input) {
        let value = input.value.replace(/,/g, '');
        if (!isNaN(value) && value !== '') {
            input.value = parseFloat(value).toLocaleString('en-US', {
                minimumFractionDigits: 2,
                maximumFractionDigits: 2
            });
        }
    }

    function calculatePrices(productItem) {
        const unit = productItem.querySelector('.unit-select').value;
        const quantity = parseInt(productItem.querySelector('.quantity-input').value) || 0;
        const bulkPurchase = parseFloat(productItem.querySelector('.bulk-purchase').value.replace(/,/g, '')) || 0;
        const bulkSell = parseFloat(productItem.querySelector('.bulk-sell').value.replace(/,/g, '')) || 0;
        const perPiecePurchaseInput = productItem.querySelector('.per-piece-purchase');
        const perPieceSellInput = productItem.querySelector('.per-piece-sell');
        const profitDisplay = productItem.querySelector('.profit-display');

        let perPiecePurchase, perPieceSell;

        if (unit === 'piece') {
            // For piece units, use direct input values
            perPiecePurchase = parseFloat(perPiecePurchaseInput.value.replace(/,/g, '')) || 0;
            perPieceSell = parseFloat(perPieceSellInput.value.replace(/,/g, '')) || 0;
        } else {
            // For bulk units, calculate from bulk prices
            let piecesPerUnit = 1;
            if (unit === 'dozen') piecesPerUnit = 12;
            else if (unit === 'carton') piecesPerUnit = 24;

            perPiecePurchase = bulkPurchase / piecesPerUnit;
            perPieceSell = bulkSell / piecesPerUnit;

            // Update the calculated fields
            perPiecePurchaseInput.value = perPiecePurchase.toLocaleString('en-US', {
                minimumFractionDigits: 2,
                maximumFractionDigits: 2
            });
            perPieceSellInput.value = perPieceSell.toLocaleString('en-US', {
                minimumFractionDigits: 2,
                maximumFractionDigits: 2
            });
        }

        // Calculate and display profit
        if (perPiecePurchase > 0 && perPieceSell > 0) {
            const profitPerPiece = perPieceSell - perPiecePurchase;
            const margin = (profitPerPiece / perPiecePurchase) * 100;
            const totalProfit = profitPerPiece * quantity;

            productItem.querySelector('.profit-amount').textContent = `$${profitPerPiece.toFixed(2)}`;
            productItem.querySelector('.profit-margin').textContent = `${margin.toFixed(1)}%`;
            productItem.querySelector('.total-profit').textContent = `$${totalProfit.toFixed(2)}`;

            profitDisplay.classList.remove('hidden');
        } else {
            profitDisplay.classList.add('hidden');
        }
    }

    function openScanner(button) {
        currentScanner = button;
        const modal = document.getElementById('scanner-modal');
        const feedback = document.getElementById('scanner-feedback');

        modal.classList.remove('hidden');
        modal.classList.add('flex');
        feedback.textContent = 'Initializing camera...';
        feedback.className = 'text-xs sm:text-sm text-blue-600 min-h-6 mb-4';

        startScanning();
    }

    function startScanning() {
        const video = document.getElementById('barcode-video');
        const feedback = document.getElementById('scanner-feedback');

        codeReader.decodeFromVideoDevice(null, video, (result, err) => {
            if (result) {
                const skuInput = currentScanner.closest('.product-item').querySelector('.sku-input');
                skuInput.value = result.text;

                feedback.textContent = '✅ Barcode scanned successfully!';
                feedback.className = 'text-xs sm:text-sm text-green-600 min-h-6 mb-4';

                document.getElementById('retry-scan').classList.remove('hidden');

                // Auto-close after 2 seconds
                setTimeout(() => {
                    closeScanner();
                }, 2000);
            }
            if (err && !(err instanceof ZXing.NotFoundException)) {
                feedback.textContent = 'Scanner error: ' + err.message;
                feedback.className = 'text-xs sm:text-sm text-red-600 min-h-6 mb-4';
            }
        }).catch(err => {
            feedback.textContent = 'Camera access denied. Please allow camera permissions.';
            feedback.className = 'text-xs sm:text-sm text-red-600 min-h-6 mb-4';
        });
    }

    function closeScanner() {
        const modal = document.getElementById('scanner-modal');
        modal.classList.add('hidden');
        modal.classList.remove('flex');
        codeReader.reset();
        document.getElementById('retry-scan').classList.add('hidden');
    }

    // Initialize event listeners for the first product
    attachEventListeners(document.querySelector('.product-item'));
});
</script>

<style>
@keyframes fadeInUp {
    from {
        opacity: 0;
        transform: translateY(20px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

.product-item {
    animation: fadeInUp 0.5s ease-out;
}

/* Custom number input styling */
input[type="number"] {
    -moz-appearance: textfield;
}

input[type="number"]::-webkit-outer-spin-button,
input[type="number"]::-webkit-inner-spin-button {
    -webkit-appearance: none;
    margin: 0;
}

/* Scanner modal animations */
#scanner-modal {
    animation: fadeInUp 0.3s ease-out;
}

/* Custom scrollbar */
::-webkit-scrollbar {
    width: 8px;
    height: 8px;
}

::-webkit-scrollbar-track {
    background: #f1f5f9;
    border-radius: 4px;
}

::-webkit-scrollbar-thumb {
    background: #cbd5e1;
    border-radius: 4px;
}

::-webkit-scrollbar-thumb:hover {
    background: #94a3b8;
}

/* Responsive text adjustments */
@media (max-width: 640px) {
    .product-item {
        padding: 1rem;
    }
}

/* Touch-friendly buttons */
@media (hover: none) and (pointer: coarse) {
    button {
        min-height: 44px;
    }
}
</style>
@endsection
