@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-blue-50 to-white py-0">
    <!-- Header Section -->
    <div class="w-full bg-white shadow-sm border-b border-blue-100 mb-8">
        <div class="w-full px-4 sm:px-6 lg:px-8 py-6">
            <div class="flex flex-col lg:flex-row justify-between items-start lg:items-center gap-0">

                <div class="flex items-center gap-2 bg-blue-50 px-4 py-2 rounded-lg">
                    <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    <span class="text-sm text-blue-700 font-medium">Real-time inventory management</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Content -->
    <div class="w-full px-4 sm:px-6 lg:px-8">
        <div class="max-w-7xl mx-auto">
            <div class="grid grid-cols-1 xl:grid-cols-3 gap-8">
                <!-- Form Section -->
                <div class="xl:col-span-2">
                    <!-- Error Messages -->
                    @if($errors->any())
                        <div class="mb-6 p-6 bg-red-50 border border-red-200 rounded-2xl shadow-sm">
                            <div class="flex items-start">
                                <svg class="w-6 h-6 text-red-600 mt-0.5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                                </svg>
                                <div class="ml-4">
                                    <h3 class="text-lg font-semibold text-red-800 mb-2">Please correct the following errors:</h3>
                                    <ul class="text-red-700 list-disc list-inside space-y-1">
                                        @foreach($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            </div>
                        </div>
                    @endif

                    <!-- Form Card -->
                    <div class="bg-white rounded-2xl shadow-lg border border-blue-100 overflow-hidden">
                        <div class="bg-gradient-to-r from-blue-600 to-blue-700 px-8 py-6">
                            <h2 class="text-2xl font-semibold text-white flex items-center gap-3">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                </svg>
                                Stock Adjustment Form
                            </h2>
                        </div>

                        <form method="POST" action="{{ route('inventory.adjust.process') }}" class="p-8 space-y-8" id="stockAdjustmentForm">
                            @csrf

                            <!-- Product Selection -->
                            <div class="space-y-4">
                                <label for="product_id" class="block text-lg font-semibold text-gray-900 flex items-center gap-3">
                                    <div class="p-2 bg-blue-100 rounded-lg">
                                        <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                                        </svg>
                                    </div>
                                    Select Product
                                </label>
                                <select name="product_id" id="product_id" required
                                        class="w-full border-2 border-blue-200 rounded-xl px-6 py-4 text-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors appearance-none bg-white hover:border-blue-300">
                                    <option value="">-- Choose a Product --</option>
                                    @foreach($products as $product)
                                        <option value="{{ $product->id }}" data-current-quantity="{{ $product->quantity }}">
                                            {{ $product->name }} ({{ $product->sku }}) - Current Stock: {{ $product->quantity }}
                                        </option>
                                    @endforeach
                                </select>
                                <div id="currentStockInfo" class="hidden p-4 bg-blue-50 border border-blue-200 rounded-xl">
                                    <div class="flex items-center gap-3 text-blue-800">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                        </svg>
                                        <div>
                                            <span class="font-semibold">Current Stock Level:</span>
                                            <span id="currentQuantity" class="ml-2 text-xl font-bold">0</span>
                                            <span class="ml-1 text-blue-600">units</span>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Adjustment Type -->
                            <div class="space-y-4">
                                <label class="block text-lg font-semibold text-gray-900 flex items-center gap-3">
                                    <div class="p-2 bg-blue-100 rounded-lg">
                                        <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16V4m0 0L3 8m4-4l4 4m6 0v12m0 0l4-4m-4 4l-4-4"/>
                                        </svg>
                                    </div>
                                    Adjustment Type
                                </label>
                                <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                                    <div class="relative">
                                        <input type="radio" name="type" id="increase" value="increase" class="hidden peer" required>
                                        <label for="increase" class="flex items-center p-6 border-2 border-blue-200 rounded-2xl cursor-pointer peer-checked:border-green-500 peer-checked:bg-green-50 transition-all hover:border-blue-300 hover:bg-blue-50">
                                            <div class="p-3 bg-green-100 rounded-xl mr-4">
                                                <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                                                </svg>
                                            </div>
                                            <div>
                                                <span class="block text-lg font-semibold text-gray-900">Increase Stock</span>
                                                <span class="text-sm text-gray-600">Add items to inventory</span>
                                            </div>
                                        </label>
                                    </div>
                                    <div class="relative">
                                        <input type="radio" name="type" id="decrease" value="decrease" class="hidden peer">
                                        <label for="decrease" class="flex items-center p-6 border-2 border-blue-200 rounded-2xl cursor-pointer peer-checked:border-red-500 peer-checked:bg-red-50 transition-all hover:border-blue-300 hover:bg-blue-50">
                                            <div class="p-3 bg-red-100 rounded-xl mr-4">
                                                <svg class="w-6 h-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 12H4"/>
                                                </svg>
                                            </div>
                                            <div>
                                                <span class="block text-lg font-semibold text-gray-900">Decrease Stock</span>
                                                <span class="text-sm text-gray-600">Remove items from inventory</span>
                                            </div>
                                        </label>
                                    </div>
                                </div>
                            </div>

                            <!-- Quantity Input -->
                            <div class="space-y-4">
                                <label for="quantity" class="block text-lg font-semibold text-gray-900 flex items-center gap-3">
                                    <div class="p-2 bg-blue-100 rounded-lg">
                                        <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                                        </svg>
                                    </div>
                                    Adjustment Quantity
                                </label>
                                <div class="relative">
                                    <input type="number"
                                           name="quantity"
                                           id="quantity"
                                           min="1"
                                           required
                                           class="w-full border-2 border-blue-200 rounded-xl px-6 py-4 text-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors hover:border-blue-300"
                                           placeholder="Enter quantity">
                                    <span class="absolute right-6 top-1/2 transform -translate-y-1/2 text-gray-500 font-semibold text-lg">units</span>
                                </div>
                                <div id="newStockInfo" class="hidden p-4 bg-gray-50 border border-gray-200 rounded-xl">
                                    <div class="flex items-center justify-between">
                                        <span class="text-gray-700 font-medium">New stock level will be:</span>
                                        <strong id="newQuantity" class="text-2xl font-bold text-gray-900">0</strong>
                                    </div>
                                </div>
                            </div>

                            <!-- Reason/Note -->
                            <div class="space-y-4">
                                <label for="note" class="block text-lg font-semibold text-gray-900 flex items-center gap-3">
                                    <div class="p-2 bg-blue-100 rounded-lg">
                                        <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 8h10M7 12h4m1 8l-4-4H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-3l-4 4z"/>
                                        </svg>
                                    </div>
                                    Reason for Adjustment
                                </label>
                                <div class="relative">
                                    <input type="text"
                                           name="note"
                                           id="note"
                                           class="w-full border-2 border-blue-200 rounded-xl px-6 py-4 text-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors hover:border-blue-300"
                                           placeholder="e.g., Damaged goods, Received shipment, Inventory count discrepancy, etc.">
                                </div>
                                <p class="text-sm text-gray-600 flex items-center gap-2">
                                    <svg class="w-4 h-4 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                    </svg>
                                    Provide a clear reason for audit trail and record keeping
                                </p>
                            </div>

                            <!-- Submit Button -->
                            <div class="pt-6">
                                <button type="submit"
                                        class="w-full bg-gradient-to-r from-blue-600 to-blue-700 text-white font-bold text-lg py-5 px-8 rounded-2xl hover:from-blue-700 hover:to-blue-800 focus:ring-4 focus:ring-blue-500 focus:ring-offset-2 transition-all duration-200 shadow-lg hover:shadow-xl transform hover:scale-[1.02] flex items-center justify-center gap-3">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                    </svg>
                                    Apply Stock Adjustment
                                </button>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- Guidelines & Info Section -->
                <div class="space-y-6">
                    <!-- Quick Stats -->
                    <div class="bg-white rounded-2xl shadow-lg border border-blue-100 p-6">
                        <h3 class="text-xl font-semibold text-gray-900 mb-4 flex items-center gap-3">
                            <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                            </svg>
                            Inventory Summary
                        </h3>
                        <div class="space-y-3">
                            <div class="flex justify-between items-center p-3 bg-blue-50 rounded-lg">
                                <span class="text-blue-700 font-medium">Total Products</span>
                                <span class="text-xl font-bold text-blue-900">{{ $products->count() }}</span>
                            </div>
                            <div class="flex justify-between items-center p-3 bg-green-50 rounded-lg">
                                <span class="text-green-700 font-medium">In Stock Items</span>
                                <span class="text-xl font-bold text-green-900">{{ $products->where('quantity', '>', 0)->count() }}</span>
                            </div>
                            <div class="flex justify-between items-center p-3 bg-red-50 rounded-lg">
                                <span class="text-red-700 font-medium">Out of Stock</span>
                                <span class="text-xl font-bold text-red-900">{{ $products->where('quantity', 0)->count() }}</span>
                            </div>
                        </div>
                    </div>

                    <!-- Guidelines -->
                    <div class="bg-white rounded-2xl shadow-lg border border-blue-100 p-6">
                        <h3 class="text-xl font-semibold text-gray-900 mb-4 flex items-center gap-3">
                            <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                            </svg>
                            Adjustment Guidelines
                        </h3>
                        <div class="space-y-4 text-sm">
                            <div class="flex items-start gap-3 p-3 bg-blue-50 rounded-lg">
                                <div class="p-1 bg-blue-100 rounded mt-0.5">
                                    <svg class="w-4 h-4 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                    </svg>
                                </div>
                                <div>
                                    <strong class="text-blue-900">Increase Stock For:</strong>
                                    <p class="text-blue-700 mt-1">New shipments, customer returns, found items, production batches</p>
                                </div>
                            </div>
                            <div class="flex items-start gap-3 p-3 bg-red-50 rounded-lg">
                                <div class="p-1 bg-red-100 rounded mt-0.5">
                                    <svg class="w-4 h-4 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                    </svg>
                                </div>
                                <div>
                                    <strong class="text-red-900">Decrease Stock For:</strong>
                                    <p class="text-red-700 mt-1">Damaged goods, theft, expiration, quality control rejects</p>
                                </div>
                            </div>
                            <div class="flex items-start gap-3 p-3 bg-purple-50 rounded-lg">
                                <div class="p-1 bg-purple-100 rounded mt-0.5">
                                    <svg class="w-4 h-4 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                                    </svg>
                                </div>
                                <div>
                                    <strong class="text-purple-900">Security Note:</strong>
                                    <p class="text-purple-700 mt-1">All adjustments are logged and require manager approval for audit purposes</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Recent Activity -->
                    <div class="bg-white rounded-2xl shadow-lg border border-blue-100 p-6">
                        <h3 class="text-xl font-semibold text-gray-900 mb-4 flex items-center gap-3">
                            <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            Best Practices
                        </h3>
                        <ul class="space-y-3 text-sm text-gray-600">
                            <li class="flex items-start gap-2">
                                <div class="w-2 h-2 bg-blue-500 rounded-full mt-2 flex-shrink-0"></div>
                                <span>Always verify physical stock before adjustment</span>
                            </li>
                            <li class="flex items-start gap-2">
                                <div class="w-2 h-2 bg-blue-500 rounded-full mt-2 flex-shrink-0"></div>
                                <span>Include detailed reasons for audit compliance</span>
                            </li>
                            <li class="flex items-start gap-2">
                                <div class="w-2 h-2 bg-blue-500 rounded-full mt-2 flex-shrink-0"></div>
                                <span>Double-check quantities before submission</span>
                            </li>
                            <li class="flex items-start gap-2">
                                <div class="w-2 h-2 bg-blue-500 rounded-full mt-2 flex-shrink-0"></div>
                                <span>Notify relevant teams of significant changes</span>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const productSelect = document.getElementById('product_id');
    const quantityInput = document.getElementById('quantity');
    const currentStockInfo = document.getElementById('currentStockInfo');
    const currentQuantitySpan = document.getElementById('currentQuantity');
    const newStockInfo = document.getElementById('newStockInfo');
    const newQuantitySpan = document.getElementById('newQuantity');
    const typeRadios = document.querySelectorAll('input[name="type"]');

    // Show current stock when product is selected
    productSelect.addEventListener('change', function() {
        const selectedOption = this.options[this.selectedIndex];
        const currentQuantity = selectedOption.getAttribute('data-current-quantity');

        if (currentQuantity !== null) {
            currentQuantitySpan.textContent = currentQuantity;
            currentStockInfo.classList.remove('hidden');
            calculateNewStock();
        } else {
            currentStockInfo.classList.add('hidden');
            newStockInfo.classList.add('hidden');
        }
    });

    // Calculate new stock when quantity or type changes
    quantityInput.addEventListener('input', calculateNewStock);
    typeRadios.forEach(radio => {
        radio.addEventListener('change', calculateNewStock);
    });

    function calculateNewStock() {
        const selectedOption = productSelect.options[productSelect.selectedIndex];
        const currentQuantity = parseInt(selectedOption.getAttribute('data-current-quantity')) || 0;
        const adjustmentQuantity = parseInt(quantityInput.value) || 0;
        const selectedType = document.querySelector('input[name="type"]:checked')?.value;

        if (currentQuantity > 0 && adjustmentQuantity > 0 && selectedType) {
            let newQuantity;
            if (selectedType === 'increase') {
                newQuantity = currentQuantity + adjustmentQuantity;
                newQuantitySpan.className = 'text-2xl font-bold text-green-600';
            } else {
                newQuantity = currentQuantity - adjustmentQuantity;
                newQuantitySpan.className = newQuantity < 0 ? 'text-2xl font-bold text-red-600' : 'text-2xl font-bold text-orange-600';
            }

            newQuantitySpan.textContent = newQuantity;
            newStockInfo.classList.remove('hidden');
        } else {
            newStockInfo.classList.add('hidden');
        }
    }

    // Form validation
    document.getElementById('stockAdjustmentForm').addEventListener('submit', function(e) {
        const productId = productSelect.value;
        const quantity = quantityInput.value;
        const type = document.querySelector('input[name="type"]:checked');
        const selectedOption = productSelect.options[productSelect.selectedIndex];
        const currentQuantity = parseInt(selectedOption.getAttribute('data-current-quantity')) || 0;
        const adjustmentQuantity = parseInt(quantity) || 0;

        if (!productId) {
            e.preventDefault();
            showNotification('Please select a product', 'error');
            return;
        }

        if (!type) {
            e.preventDefault();
            showNotification('Please select an adjustment type', 'error');
            return;
        }

        if (!quantity || adjustmentQuantity <= 0) {
            e.preventDefault();
            showNotification('Please enter a valid quantity', 'error');
            return;
        }

        if (type.value === 'decrease' && adjustmentQuantity > currentQuantity) {
            e.preventDefault();
            showNotification('Cannot decrease more than current stock level', 'error');
            return;
        }
    });

    function showNotification(message, type = 'info') {
        // Create notification element
        const notification = document.createElement('div');
        notification.className = `fixed top-4 right-4 p-4 rounded-xl shadow-lg transform transition-all duration-300 z-50 ${
            type === 'error' ? 'bg-red-500 text-white' : 'bg-blue-500 text-white'
        }`;
        notification.innerHTML = `
            <div class="flex items-center gap-2">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                <span class="font-semibold">${message}</span>
            </div>
        `;

        document.body.appendChild(notification);

        // Remove notification after 5 seconds
        setTimeout(() => {
            notification.style.transform = 'translateX(100%)';
            setTimeout(() => notification.remove(), 300);
        }, 5000);
    }

    // Add animations
    const formElements = document.querySelectorAll('input, select, textarea, button');
    formElements.forEach((element, index) => {
        element.style.animation = `fadeInUp 0.5s ease-out ${index * 0.1}s both`;
    });
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

/* Custom select styling */
select {
    background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 20 20'%3e%3cpath stroke='%233b82f6' stroke-linecap='round' stroke-linejoin='round' stroke-width='1.5' d='m6 8 4 4 4-4'/%3e%3c/svg%3e");
    background-position: right 1rem center;
    background-repeat: no-repeat;
    background-size: 1.5em 1.5em;
    padding-right: 3rem;
}

/* Improve radio button styling */
input[type="radio"]:checked + label {
    transform: scale(1.02);
    box-shadow: 0 4px 12px rgba(59, 130, 246, 0.15);
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

/* Responsive improvements */
@media (max-width: 1280px) {
    .grid-cols-1.xl\\:grid-cols-3 {
        grid-template-columns: 1fr;
    }
}

/* Hover effects */
.hover-lift:hover {
    transform: translateY(-2px);
    transition: transform 0.2s ease-in-out;
}
</style>
@endsection
