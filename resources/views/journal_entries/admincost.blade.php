@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-blue-50 to-white py-0">
    <!-- Header Section -->
    <div class="w-full bg-white shadow-sm border-b border-blue-100 mb-8">
        <div class="w-full px-4 sm:px-6 lg:px-8 py-6">
            <div class="flex flex-col lg:flex-row justify-between items-start lg:items-center gap-4">
                <div class="text-center lg:text-left">
    
                    <p class="text-lg text-gray-600 mt-0">Track business expenses and operational costs</p>
                </div>
                <div class="flex items-center gap-2 bg-blue-50 px-4 py-3 rounded-xl">
                    <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    <span class="text-sm text-blue-700 font-medium">Track all business expenses</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Content -->
    <div class="w-full px-4 sm:px-6 lg:px-8">
        <div class="max-w-4xl mx-auto">
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                <!-- Form Section -->
                <div class="lg:col-span-2">
                    <!-- Success Message -->
                    @if (session('success'))
                        <div id="success-alert" class="mb-6 p-6 bg-green-50 border border-green-200 rounded-2xl shadow-sm flex items-start">
                            <svg class="w-6 h-6 text-green-600 mt-0.5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                            </svg>
                            <div class="ml-4">
                                <h3 class="text-lg font-semibold text-green-800 mb-1">Expense Recorded Successfully!</h3>
                                <p class="text-green-700">{{ session('success') }}</p>
                            </div>
                        </div>
                    @endif

                    <!-- Error Messages -->
                    @if ($errors->any())
                        <div class="mb-6 p-6 bg-red-50 border border-red-200 rounded-2xl shadow-sm">
                            <div class="flex items-start">
                                <svg class="w-6 h-6 text-red-600 mt-0.5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                                </svg>
                                <div class="ml-4">
                                    <h3 class="text-lg font-semibold text-red-800 mb-2">Please correct the following errors:</h3>
                                    <ul class="text-red-700 list-disc list-inside space-y-1">
                                        @foreach ($errors->all() as $error)
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
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                                </svg>
                                New Expense Entry
                            </h2>
                        </div>

                        <form method="POST" action="{{ route('operational-costs.store') }}" class="p-8 space-y-8">
                            @csrf

                            <!-- Date Field -->
                            <div class="space-y-4">
                                <label for="entry_date" class="block text-lg font-semibold text-gray-900 flex items-center gap-3">
                                    <div class="p-2 bg-blue-100 rounded-lg">
                                        <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                        </svg>
                                    </div>
                                    Expense Date
                                </label>
                                <input
                                    type="date"
                                    id="entry_date"
                                    name="entry_date"
                                    value="{{ old('entry_date', date('Y-m-d')) }}"
                                    class="w-full border-2 border-blue-200 rounded-xl px-6 py-4 text-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors hover:border-blue-300"
                                    required
                                >
                            </div>

                            <!-- Amount Field -->
                            <div class="space-y-4">
                                <label for="amount" class="block text-lg font-semibold text-gray-900 flex items-center gap-3">
                                    <div class="p-2 bg-blue-100 rounded-lg">
                                        <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                        </svg>
                                    </div>
                                    Amount (UGX)
                                </label>
                                <div class="relative">
                                    <span class="absolute left-4 top-1/2 transform -translate-y-1/2 text-gray-500 font-semibold text-lg">UGX</span>
                                    <input
                                        type="number"
                                        id="amount"
                                        name="amount"
                                        step="0.01"
                                        min="0"
                                        value="{{ old('amount') }}"
                                        class="w-full border-2 border-blue-200 rounded-xl pl-16 pr-6 py-4 text-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors hover:border-blue-300"
                                        placeholder="0.00"
                                        required
                                    >
                                </div>
                                <p class="text-sm text-gray-600 flex items-center gap-2">
                                    <svg class="w-4 h-4 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                    </svg>
                                    Enter the total cost in Ugandan Shillings
                                </p>
                            </div>

                            <!-- Description Field -->
                            <div class="space-y-4">
                                <label for="description" class="block text-lg font-semibold text-gray-900 flex items-center gap-3">
                                    <div class="p-2 bg-blue-100 rounded-lg">
                                        <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 8h10M7 12h4m1 8l-4-4H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-3l-4 4z"/>
                                        </svg>
                                    </div>
                                    Expense Description
                                </label>
                                <input
                                    type="text"
                                    id="description"
                                    name="description"
                                    value="{{ old('description') }}"
                                    class="w-full border-2 border-blue-200 rounded-xl px-6 py-4 text-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors hover:border-blue-300"
                                    placeholder="e.g. Office supplies, Internet bill, Transportation, Utilities"
                                    required
                                >
                                <p class="text-sm text-gray-600 flex items-center gap-2">
                                    <svg class="w-4 h-4 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                    </svg>
                                    Provide a clear description for better expense tracking
                                </p>
                            </div>

                            <!-- Submit Button -->
                            <div class="pt-6">
                                <button
                                    type="submit"
                                    class="w-full bg-gradient-to-r from-blue-600 to-blue-700 text-white font-bold text-lg py-5 px-8 rounded-2xl hover:from-blue-700 hover:to-blue-800 focus:ring-4 focus:ring-blue-500 focus:ring-offset-2 transition-all duration-200 shadow-lg hover:shadow-xl transform hover:scale-[1.02] flex items-center justify-center gap-3"
                                >
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                    </svg>
                                    Record Operational Expense
                                </button>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- Guidelines & Info Section -->
                <div class="space-y-6">
                    <!-- Expense Categories -->
                    <div class="bg-white rounded-2xl shadow-lg border border-blue-100 p-6">
                        <h3 class="text-xl font-semibold text-gray-900 mb-4 flex items-center gap-3">
                            <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/>
                            </svg>
                            Common Expense Types
                        </h3>
                        <div class="space-y-3 text-sm">
                            <div class="flex items-center gap-3 p-3 bg-blue-50 rounded-lg">
                                <div class="w-2 h-2 bg-blue-500 rounded-full flex-shrink-0"></div>
                                <span class="text-blue-800">Office Supplies & Stationery</span>
                            </div>
                            <div class="flex items-center gap-3 p-3 bg-green-50 rounded-lg">
                                <div class="w-2 h-2 bg-green-500 rounded-full flex-shrink-0"></div>
                                <span class="text-green-800">Utilities (Electricity, Water)</span>
                            </div>
                            <div class="flex items-center gap-3 p-3 bg-purple-50 rounded-lg">
                                <div class="w-2 h-2 bg-purple-500 rounded-full flex-shrink-0"></div>
                                <span class="text-purple-800">Internet & Communication</span>
                            </div>
                            <div class="flex items-center gap-3 p-3 bg-orange-50 rounded-lg">
                                <div class="w-2 h-2 bg-orange-500 rounded-full flex-shrink-0"></div>
                                <span class="text-orange-800">Transportation & Fuel</span>
                            </div>
                            <div class="flex items-center gap-3 p-3 bg-red-50 rounded-lg">
                                <div class="w-2 h-2 bg-red-500 rounded-full flex-shrink-0"></div>
                                <span class="text-red-800">Maintenance & Repairs</span>
                            </div>
                        </div>
                    </div>

                    <!-- Best Practices -->
                    <div class="bg-white rounded-2xl shadow-lg border border-blue-100 p-6">
                        <h3 class="text-xl font-semibold text-gray-900 mb-4 flex items-center gap-3">
                            <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                            </svg>
                            Best Practices
                        </h3>
                        <ul class="space-y-3 text-sm text-gray-600">
                            <li class="flex items-start gap-2">
                                <div class="w-2 h-2 bg-blue-500 rounded-full mt-2 flex-shrink-0"></div>
                                <span>Record expenses immediately after payment</span>
                            </li>
                            <li class="flex items-start gap-2">
                                <div class="w-2 h-2 bg-blue-500 rounded-full mt-2 flex-shrink-0"></div>
                                <span>Keep receipts for all recorded expenses</span>
                            </li>
                            <li class="flex items-start gap-2">
                                <div class="w-2 h-2 bg-blue-500 rounded-full mt-2 flex-shrink-0"></div>
                                <span>Use specific descriptions for easy tracking</span>
                            </li>
                            <li class="flex items-start gap-2">
                                <div class="w-2 h-2 bg-blue-500 rounded-full mt-2 flex-shrink-0"></div>
                                <span>Categorize expenses for better reporting</span>
                            </li>
                        </ul>
                    </div>

                    <!-- Quick Stats -->
                    <div class="bg-white rounded-2xl shadow-lg border border-blue-100 p-6">
                        <h3 class="text-xl font-semibold text-gray-900 mb-4 flex items-center gap-3">
                            <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                            </svg>
                            Why Track Expenses?
                        </h3>
                        <div class="space-y-3 text-sm text-gray-600">
                            <div class="flex items-center gap-2 p-2">
                                <svg class="w-4 h-4 text-green-500 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                </svg>
                                <span>Accurate financial reporting</span>
                            </div>
                            <div class="flex items-center gap-2 p-2">
                                <svg class="w-4 h-4 text-green-500 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                </svg>
                                <span>Better budgeting and planning</span>
                            </div>
                            <div class="flex items-center gap-2 p-2">
                                <svg class="w-4 h-4 text-green-500 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                </svg>
                                <span>Tax deduction optimization</span>
                            </div>
                            <div class="flex items-center gap-2 p-2">
                                <svg class="w-4 h-4 text-green-500 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                </svg>
                                <span>Identify cost-saving opportunities</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Auto-hide success message after 5 seconds
    const successAlert = document.getElementById('success-alert');
    if (successAlert) {
        setTimeout(() => {
            successAlert.style.opacity = '0';
            setTimeout(() => successAlert.remove(), 500);
        }, 5000);
    }

    // Format amount input with commas
    const amountInput = document.getElementById('amount');
    
    amountInput.addEventListener('blur', function(e) {
        let value = this.value.replace(/,/g, '');
        if(!isNaN(value) && value !== '') {
            this.value = parseFloat(value).toLocaleString('en-US', {
                minimumFractionDigits: 2,
                maximumFractionDigits: 2
            });
        }
    });

    amountInput.addEventListener('focus', function(e) {
        this.value = this.value.replace(/,/g, '');
    });

    // Add animations
    const formElements = document.querySelectorAll('input, button');
    formElements.forEach((element, index) => {
        element.style.animation = `fadeInUp 0.5s ease-out ${index * 0.1}s both`;
    });

    // Form validation
    const form = document.querySelector('form');
    form.addEventListener('submit', function(e) {
        const amount = document.getElementById('amount').value;
        const description = document.getElementById('description').value;
        
        if (!amount || parseFloat(amount.replace(/,/g, '')) <= 0) {
            e.preventDefault();
            showNotification('Please enter a valid amount greater than 0', 'error');
            return;
        }
        
        if (!description.trim()) {
            e.preventDefault();
            showNotification('Please provide a description for the expense', 'error');
            return;
        }
    });

    function showNotification(message, type = 'info') {
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
        
        setTimeout(() => {
            notification.style.transform = 'translateX(100%)';
            setTimeout(() => notification.remove(), 300);
        }, 5000);
    }
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

/* Custom styling for date input */
input[type="date"] {
    position: relative;
}

input[type="date"]::-webkit-calendar-picker-indicator {
    background: transparent;
    bottom: 0;
    color: transparent;
    cursor: pointer;
    height: auto;
    left: 0;
    position: absolute;
    right: 0;
    top: 0;
    width: auto;
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
@media (max-width: 1024px) {
    .grid-cols-1.lg\\:grid-cols-3 {
        grid-template-columns: 1fr;
    }
}
</style>
@endsection