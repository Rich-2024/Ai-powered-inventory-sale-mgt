{{-- @extends('layouts.app')

@section('content')
<div class="container mx-auto p-6 bg-white rounded shadow">
    <h2 class="text-2xl font-bold mb-4">Balance Sheet</h2>
    <p class="mb-6">As of: {{ $date }}</p>

    <table class="w-full text-left border-collapse border border-gray-300">
        <tbody>
            <tr class="border-b border-gray-300">
                <td class="py-2 px-4 font-semibold">Assets</td>
                <td class="py-2 px-4 text-blue-700">${{ number_format($assets, 2) }}</td>
            </tr>
            <tr class="border-b border-gray-300">
                <td class="py-2 px-4 font-semibold">Liabilities</td>
                <td class="py-2 px-4 text-yellow-700">${{ number_format($liabilities, 2) }}</td>
            </tr>
            <tr class="border-b border-gray-300">
                <td class="py-2 px-4 font-semibold">Equity</td>
                <td class="py-2 px-4 text-purple-700">${{ number_format($equity, 2) }}</td>
            </tr>
            <tr class="font-bold border-t border-gray-500">
                <td class="py-2 px-4">Assets = Liabilities + Equity</td>
                <td class="py-2 px-4 {{ $isBalanced ? 'text-green-600' : 'text-red-600' }}">
                    {{ $isBalanced ? 'Balanced ✅' : 'Not Balanced ❌' }}
                </td>
            </tr>
        </tbody>
    </table>
</div>
@endsection --}}
@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-blue-50 to-white py-0">
    <!-- Header Section -->
    <div class="w-full bg-white shadow-sm border-b border-blue-100 mb-8">
        <div class="w-full px-4 sm:px-6 lg:px-8 py-0">
            <div class="flex flex-col lg:flex-row justify-between items-start lg:items-center gap-4">
                <div class="text-center lg:text-left">
                    <h1 class="text-3xl sm:text-4xl font-bold text-gray-900 mb-2 flex items-center gap-2">
    <svg class="w-6 h-6 text-gray-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7h18M3 12h18M3 17h18" />
    </svg>
    Balance Sheet
</h1>

                    <p class="text-lg text-gray-600">Financial position snapshot of your business</p>
                </div>
                <div class="flex flex-col sm:flex-row gap-4 items-center">
                    <div class="bg-blue-50 px-4 py-3 rounded-xl border border-blue-200">
                        <div class="text-sm text-blue-600 font-medium">Report Date</div>
                        <div class="text-lg font-semibold text-blue-900">{{ \Carbon\Carbon::parse($date)->format('F j, Y') }}</div>
                    </div>
                    <div class="flex gap-3">
                        <button onclick="window.print()" class="bg-blue-600 text-white px-6 py-3 rounded-xl hover:bg-blue-700 transition-colors flex items-center gap-2 font-semibold">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"/>
                            </svg>
                            Print
                        </button>
                        <a href="{{ url()->current() }}?export=pdf" class="bg-green-600 text-white px-6 py-3 rounded-xl hover:bg-green-700 transition-colors flex items-center gap-2 font-semibold">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                            </svg>
                            Export PDF
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Content -->
    <div class="w-full px-4 sm:px-6 lg:px-8">
        <div class="max-w-7xl mx-auto">
            <!-- Financial Summary Cards -->
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-8">
                <!-- Assets Card -->
                <div class="bg-gradient-to-br from-blue-500 to-blue-600 text-white rounded-2xl p-6 shadow-lg">
                    <div class="flex items-center justify-between">
                        <div>
                            <div class="flex items-center gap-2 mb-2">
                                <div class="p-2 bg-blue-400/20 rounded-lg">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                    </svg>
                                </div>
                                <span class="text-blue-100 font-medium">Total Assets</span>
                            </div>
                            <p class="text-3xl lg:text-4xl font-bold">Ugx:{{ number_format($assets, 2) }}</p>
                        </div>
                        <div class="text-right">
                            <div class="text-blue-200 text-sm">What you own</div>
                        </div>
                    </div>
                </div>

                <!-- Liabilities Card -->
                <div class="bg-gradient-to-br from-yellow-500 to-yellow-600 text-white rounded-2xl p-6 shadow-lg">
                    <div class="flex items-center justify-between">
                        <div>
                            <div class="flex items-center gap-2 mb-2">
                                <div class="p-2 bg-yellow-400/20 rounded-lg">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                                    </svg>
                                </div>
                                <span class="text-yellow-100 font-medium">Total Liabilities</span>
                            </div>
                            <p class="text-3xl lg:text-4xl font-bold">Ugx{{ number_format($liabilities, 2) }}</p>
                        </div>
                        <div class="text-right">
                            <div class="text-yellow-200 text-sm">What you owe</div>
                        </div>
                    </div>
                </div>

                <!-- Equity Card -->
                <div class="bg-gradient-to-br from-purple-500 to-purple-600 text-white rounded-2xl p-6 shadow-lg">
                    <div class="flex items-center justify-between">
                        <div>
                            <div class="flex items-center gap-2 mb-2">
                                <div class="p-2 bg-purple-400/20 rounded-lg">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                                    </svg>
                                </div>
                                <span class="text-purple-100 font-medium">Total Equity</span>
                            </div>
                            <p class="text-3xl lg:text-4xl font-bold">Ugx:{{ number_format($equity, 2) }}</p>
                        </div>
                        <div class="text-right">
                            <div class="text-purple-200 text-sm">Owner's stake</div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Balance Sheet Details -->
            <div class="grid grid-cols-1 xl:grid-cols-2 gap-8 mb-8">
                <!-- Balance Sheet Table -->
                <div class="bg-white rounded-2xl shadow-lg border border-blue-100 overflow-hidden">
                    <div class="bg-gradient-to-r from-blue-600 to-blue-700 px-8 py-6">
                        <h2 class="text-2xl font-semibold text-white flex items-center gap-3">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                            </svg>
                            Balance Sheet Statement
                        </h2>
                    </div>

                    <div class="p-8">
                        <div class="space-y-6">
                            <!-- Assets -->
                            <div class="flex justify-between items-center py-4 border-b border-blue-200">
                                <div class="flex items-center gap-4">
                                    <div class="p-3 bg-blue-100 rounded-xl">
                                        <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                        </svg>
                                    </div>
                                    <div>
                                        <h3 class="text-xl font-semibold text-gray-900">Assets</h3>
                                        <p class="text-sm text-gray-500">Resources owned by the business</p>
                                    </div>
                                </div>
                                <span class="text-2xl font-bold text-blue-700">Ugx:{{ number_format($assets, 2) }}</span>
                            </div>

                            <!-- Liabilities -->
                            <div class="flex justify-between items-center py-4 border-b border-blue-200">
                                <div class="flex items-center gap-4">
                                    <div class="p-3 bg-yellow-100 rounded-xl">
                                        <svg class="w-6 h-6 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                                        </svg>
                                    </div>
                                    <div>
                                        <h3 class="text-xl font-semibold text-gray-900">Liabilities</h3>
                                        <p class="text-sm text-gray-500">Obligations and debts</p>
                                    </div>
                                </div>
                                <span class="text-2xl font-bold text-yellow-700">Ugx:{{ number_format($liabilities, 2) }}</span>
                            </div>

                            <!-- Equity -->
                            <div class="flex justify-between items-center py-4 border-b border-blue-200">
                                <div class="flex items-center gap-4">
                                    <div class="p-3 bg-purple-100 rounded-xl">
                                        <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                                        </svg>
                                    </div>
                                    <div>
                                        <h3 class="text-xl font-semibold text-gray-900">Equity</h3>
                                        <p class="text-sm text-gray-500">Owner's investment and retained earnings</p>
                                    </div>
                                </div>
                                <span class="text-2xl font-bold text-purple-700">Ugx:{{ number_format($equity, 2) }}</span>
                            </div>

                            <!-- Balance Check -->
                            <div class="flex justify-between items-center py-6 bg-gradient-to-r from-gray-50 to-blue-50 -mx-8 px-8 rounded-xl mt-6 border border-blue-200">
                                <div class="flex items-center gap-4">
                                    <div class="p-3 {{ $isBalanced ? 'bg-green-100' : 'bg-red-100' }} rounded-xl">
                                        <svg class="w-7 h-7 {{ $isBalanced ? 'text-green-600' : 'text-red-600' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            @if($isBalanced)
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                            @else
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                            @endif
                                        </svg>
                                    </div>
                                    <div>
                                        <h3 class="text-2xl font-bold text-gray-900">Accounting Equation</h3>
                                        <p class="text-lg text-gray-600">Assets = Liabilities + Equity</p>
                                    </div>
                                </div>
                                <div class="text-right">
                                    <div class="text-2xl font-bold {{ $isBalanced ? 'text-green-600' : 'text-red-600' }} mb-2">
                                        {{ $isBalanced ? 'Balanced' : 'Not Balanced' }}
                                    </div>
                                    <div class="text-sm {{ $isBalanced ? 'text-green-700' : 'text-red-700' }} font-medium">
                                        {{ $isBalanced ? '✅ Accounts are balanced' : '❌ Requires attention' }}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Financial Ratios & Insights -->
                <div class="space-y-6">
                    <!-- Balance Status -->
                    <div class="bg-white rounded-2xl shadow-lg border border-blue-100 p-8">
                        <h3 class="text-xl font-semibold text-gray-900 mb-6 flex items-center gap-3">
                            <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                            </svg>
                            Financial Health
                        </h3>

                        <div class="space-y-6">
                            <!-- Debt to Equity Ratio -->
                            <div class="text-center">
                                <div class="mb-4">
                                    <h4 class="text-lg font-semibold text-gray-900 mb-2">Debt to Equity Ratio</h4>
                                    <p class="text-sm text-gray-500">Measures financial leverage</p>
                                </div>
                                <div class="relative inline-block">
                                    <div class="w-32 h-32 rounded-full border-8 {{ $equity > 0 ? ($liabilities/$equity <= 2 ? 'border-green-200' : 'border-yellow-200') : 'border-red-200' }} flex items-center justify-center">
                                        <div class="text-center">
                                            <div class="text-2xl font-bold {{ $equity > 0 ? ($liabilities/$equity <= 2 ? 'text-green-600' : 'text-yellow-600') : 'text-red-600' }}">
                                                {{ $equity > 0 ? number_format($liabilities/$equity, 2) : 'N/A' }}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <p class="text-sm text-gray-600 mt-3">
                                    @if($equity > 0)
                                        @if($liabilities/$equity <= 1)
                                            <span class="text-green-600 font-semibold">✓ Low risk</span>
                                        @elseif($liabilities/$equity <= 2)
                                            <span class="text-yellow-600 font-semibold">⚠ Moderate risk</span>
                                        @else
                                            <span class="text-red-600 font-semibold">✗ High risk</span>
                                        @endif
                                    @else
                                        <span class="text-red-600 font-semibold">No equity</span>
                                    @endif
                                </p>
                            </div>

                            <!-- Net Worth -->
                            <div class="text-center p-6 bg-gradient-to-r from-blue-50 to-purple-50 rounded-xl border border-blue-200">
                                <h4 class="text-lg font-semibold text-gray-900 mb-2">Business Net Worth</h4>
                                <p class="text-3xl font-bold text-purple-700">Ugx:{{ number_format($assets - $liabilities, 2) }}</p>
                                <p class="text-sm text-gray-600 mt-2">Assets minus Liabilities</p>
                            </div>
                        </div>
                    </div>

                    <!-- Quick Actions -->
                    <div class="bg-white rounded-2xl shadow-lg border border-blue-100 p-6">
                        <h3 class="text-lg font-semibold text-gray-900 mb-4 flex items-center gap-2">
                            <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                            </svg>
                            Quick Actions
                        </h3>
                        <div class="space-y-3">
                            <a href="/admin/journal-entries" class="w-full bg-blue-600 text-white px-4 py-3 rounded-lg hover:bg-blue-700 transition-colors flex items-center justify-center gap-2 font-semibold">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                                </svg>
                                View Journal Entries
                            </a>
                            <a href="{{ route('sales.report') }}" class="w-full bg-green-600 text-white px-4 py-3 rounded-lg hover:bg-green-700 transition-colors flex items-center justify-center gap-2 font-semibold">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                                </svg>
                                View Sales Report
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

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

/* Print styles */
@media print {
    .bg-gradient-to-br {
        background: white !important;
    }
    .shadow-lg {
        box-shadow: none !important;
    }
    button, a {
        display: none !important;
    }
    .gap-6, .gap-8 {
        gap: 1rem !important;
    }
}

/* Animation for cards */
.animate-fade-in {
    animation: fadeInUp 0.6s ease-in-out;
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Add fade-in animation to cards
    const cards = document.querySelectorAll('.bg-white');
    cards.forEach((card, index) => {
        card.style.animation = `fadeInUp 0.6s ease-in-out ${index * 0.1}s both`;
    });

    // Add animation to summary cards
    const summaryCards = document.querySelectorAll('.bg-gradient-to-br');
    summaryCards.forEach((card, index) => {
        card.style.animation = `fadeInUp 0.6s ease-in-out ${index * 0.2}s both`;
    });
});
</script>
@endsection
