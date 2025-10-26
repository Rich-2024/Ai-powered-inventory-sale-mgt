@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-blue-50 to-indigo-100 py-8 px-4 sm:px-6 lg:px-0">
    <div class="max-w-md mx-auto">
        <!-- Header Section -->
        <div class="text-center mb-8">
            <div class="bg-white rounded-2xl shadow-lg p-6 mb-6">
                <div class="flex items-center justify-center mb-4">
                    <div class="p-3 bg-gradient-to-r from-blue-500 to-blue-600 rounded-xl">
                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                </div>
                <h1 class="text-2xl sm:text-3xl font-bold text-gray-900 mb-2">Add Capital or Loan</h1>
                <p class="text-gray-600">Record new financial injections into your business</p>
            </div>
        </div>

        <!-- Success Message -->
        @if(session('success'))
            <div class="mb-6 p-4 bg-green-50 border border-green-200 rounded-2xl shadow-sm flex items-start">
                <svg class="w-5 h-5 text-green-600 mt-0.5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                </svg>
                <div class="ml-3">
                    <p class="text-green-800 font-medium">{{ session('success') }}</p>
                </div>
            </div>
        @endif

        <!-- Form Card -->
        <div class="bg-white rounded-2xl shadow-xl border border-gray-200 overflow-hidden">
            <div class="bg-gradient-to-r from-blue-600 to-blue-700 px-6 py-4">
                <h2 class="text-lg font-semibold text-white flex items-center gap-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                    </svg>
                    New Financial Entry
                </h2>
            </div>

            <form action="{{ route('journal.storeCapitalLoan') }}" method="POST" class="p-6 space-y-6" id="capitalLoanForm">
                @csrf

                <!-- Amount Field -->
                <div class="space-y-2">
                    <label for="amount" class="block text-sm font-semibold text-gray-700 flex items-center gap-2">
                        <svg class="w-4 h-4 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        Amount *
                    </label>
                    <div class="relative">
                        <span class="absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-500 font-semibold">$</span>
                        <input type="text"
                               name="amount"
                               id="amount"
                               required
                               class="w-full border-2 border-gray-200 rounded-xl pl-8 pr-4 py-3 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors @error('amount') border-red-500 @enderror"
                               value="{{ old('amount') }}"
                               placeholder="0.00">
                    </div>
                    @error('amount')
                        <p class="text-red-600 text-sm mt-1 flex items-center gap-1">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            {{ $message }}
                        </p>
                    @enderror
                </div>

                <!-- Type Selection -->
                <div class="space-y-2">
                    <label for="type" class="block text-sm font-semibold text-gray-700 flex items-center gap-2">
                        <svg class="w-4 h-4 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                        </svg>
                        Entry Type *
                    </label>
                    <div class="grid grid-cols-2 gap-3">
                        <div class="relative">
                            <input type="radio" name="type" id="equity" value="equity" class="hidden peer" {{ old('type') == 'equity' ? 'checked' : '' }} required>
                            <label for="equity" class="flex flex-col items-center justify-center p-4 border-2 border-gray-200 rounded-xl cursor-pointer peer-checked:border-green-500 peer-checked:bg-green-50 transition-all hover:border-gray-300">
                                <div class="p-2 bg-green-100 rounded-lg mb-2">
                                    <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                    </svg>
                                </div>
                                <span class="font-semibold text-gray-900">Equity</span>
                                <span class="text-xs text-gray-500 mt-1">Capital</span>
                            </label>
                        </div>
                        <div class="relative">
                            <input type="radio" name="type" id="liability" value="liability" class="hidden peer" {{ old('type') == 'liability' ? 'checked' : '' }} required>
                            <label for="liability" class="flex flex-col items-center justify-center p-4 border-2 border-gray-200 rounded-xl cursor-pointer peer-checked:border-blue-500 peer-checked:bg-blue-50 transition-all hover:border-gray-300">
                                <div class="p-2 bg-blue-100 rounded-lg mb-2">
                                    <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                                    </svg>
                                </div>
                                <span class="font-semibold text-gray-900">Liability</span>
                                <span class="text-xs text-gray-500 mt-1">Loan</span>
                            </label>
                        </div>
                    </div>
                    @error('type')
                        <p class="text-red-600 text-sm mt-1 flex items-center gap-1">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            {{ $message }}
                        </p>
                    @enderror
                </div>

                <!-- Hidden account_id input -->
                <input type="hidden" name="account_id" id="account_id" value="{{ old('account_id') }}">

                <!-- Date Field -->
                <div class="space-y-2">
                    <label for="entry_date" class="block text-sm font-semibold text-gray-700 flex items-center gap-2">
                        <svg class="w-4 h-4 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                        </svg>
                        Entry Date *
                    </label>
                    <input type="date"
                           name="entry_date"
                           id="entry_date"
                           class="w-full border-2 border-gray-200 rounded-xl px-4 py-3 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors @error('entry_date') border-red-500 @enderror"
                           value="{{ old('entry_date', date('Y-m-d')) }}">
                    @error('entry_date')
                        <p class="text-red-600 text-sm mt-1 flex items-center gap-1">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            {{ $message }}
                        </p>
                    @enderror
                </div>

                <!-- Description Field -->
                <div class="space-y-2">
                    <label for="description" class="block text-sm font-semibold text-gray-700 flex items-center gap-2">
                        <svg class="w-4 h-4 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 8h10M7 12h4m1 8l-4-4H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-3l-4 4z"/>
                        </svg>
                        Description
                    </label>
                    <textarea name="description"
                              id="description"
                              rows="3"
                              class="w-full border-2 border-gray-200 rounded-xl px-4 py-3 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors resize-none"
                              placeholder="Optional description or notes about this entry...">{{ old('description') }}</textarea>
                </div>

                <!-- Submit Button -->
                <button type="submit"
                        class="w-full bg-gradient-to-r from-blue-600 to-blue-700 text-white font-semibold py-4 px-6 rounded-xl hover:from-blue-700 hover:to-blue-800 focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition-all duration-200 shadow-lg hover:shadow-xl transform hover:scale-[1.02] flex items-center justify-center gap-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                    </svg>
                    Submit Financial Entry
                </button>
            </form>
        </div>

        <!-- Quick Info -->
        <div class="mt-6 text-center">
            <p class="text-sm text-gray-600">
                💡 This entry will be recorded in your journal and affect your balance sheet accordingly.
            </p>
        </div>
    </div>
</div>

<script>
// Format input with commas as thousands separator
const amountInput = document.getElementById('amount');

amountInput.addEventListener('input', function(e) {
    let value = this.value.replace(/,/g, '');
    if(!isNaN(value) && value !== '') {
        this.value = parseFloat(value).toLocaleString('en-US', {
            minimumFractionDigits: 2,
            maximumFractionDigits: 2
        });
    } else if(value === '') {
        this.value = '';
    }
});

// Auto select account based on type
const accountInput = document.getElementById('account_id');

// Mapping of type to account id (pass from server side)
const accountMap = {
    'equity': '{{ $equityAccountId ?? '' }}',
    'liability': '{{ $liabilityAccountId ?? '' }}'
};

function setAccountId() {
    const selectedType = document.querySelector('input[name="type"]:checked')?.value;
    if (selectedType && accountMap[selectedType]) {
        accountInput.value = accountMap[selectedType];
    } else {
        accountInput.value = '';
    }
}

// Add event listeners to radio buttons
document.querySelectorAll('input[name="type"]').forEach(radio => {
    radio.addEventListener('change', setAccountId);
});

// Initialize on load
window.addEventListener('DOMContentLoaded', () => {
    setAccountId();

    // Add animation to form elements
    const formElements = document.querySelectorAll('input, textarea, button');
    formElements.forEach((element, index) => {
        element.style.animation = `fadeInUp 0.5s ease-out ${index * 0.1}s both`;
    });
});

// Form validation and enhancement
document.getElementById('capitalLoanForm').addEventListener('submit', function(e) {
    const amount = document.getElementById('amount').value;
    const type = document.querySelector('input[name="type"]:checked');

    if (!type) {
        e.preventDefault();
        showNotification('Please select an entry type (Equity or Liability)', 'error');
        return;
    }

    if (!amount || parseFloat(amount.replace(/,/g, '')) <= 0) {
        e.preventDefault();
        showNotification('Please enter a valid amount greater than 0', 'error');
        return;
    }
});

function showNotification(message, type = 'info') {
    // Create notification element
    const notification = document.createElement('div');
    notification.className = `fixed top-4 right-4 p-4 rounded-xl shadow-lg transform transition-all duration-300 ${
        type === 'error' ? 'bg-red-500 text-white' : 'bg-blue-500 text-white'
    }`;
    notification.innerHTML = `
        <div class="flex items-center gap-2">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
            <span>${message}</span>
        </div>
    `;

    document.body.appendChild(notification);

    // Remove notification after 5 seconds
    setTimeout(() => {
        notification.style.transform = 'translateX(100%)';
        setTimeout(() => notification.remove(), 300);
    }, 5000);
}
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

/* Improve radio button styling */
input[type="radio"]:checked + label {
    transform: scale(1.02);
}

/* Custom scrollbar for textarea */
textarea::-webkit-scrollbar {
    width: 6px;
}

textarea::-webkit-scrollbar-track {
    background: #f1f1f1;
    border-radius: 3px;
}

textarea::-webkit-scrollbar-thumb {
    background: #c1c1c1;
    border-radius: 3px;
}

textarea::-webkit-scrollbar-thumb:hover {
    background: #a8a8a8;
}
</style>
@endsection
