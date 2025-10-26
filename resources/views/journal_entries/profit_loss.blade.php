@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-gray-50 to-blue-50 py-8">
    <!-- Header Section -->
    <div class="w-full bg-white shadow-lg border-b border-gray-200">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
            <div class="flex flex-col lg:flex-row justify-between items-start lg:items-center gap-4">
                <div>
                   <h1 class="text-3xl sm:text-4xl font-bold text-gray-900 mb-2">
  <i class="fas fa-money-bill-wave mr-2"></i> Profit & Loss Statement
</h1>
                    <p class="text-lg text-gray-600">
                        Period: {{ \Carbon\Carbon::parse($startDate)->format('F j, Y') }} - {{ \Carbon\Carbon::parse($endDate)->format('F j, Y') }}
                    </p>
                </div>
                <div class="flex flex-wrap gap-3">
                    <button onclick="window.print()" class="bg-blue-600 text-white px-6 py-3 rounded-lg hover:bg-blue-700 transition-colors flex items-center gap-2 font-semibold">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"/>
                        </svg>
                        Print Report
                    </button>
                    <a href="{{ url()->current() }}?export=pdf" class="bg-green-600 text-white px-6 py-3 rounded-lg hover:bg-green-700 transition-colors flex items-center gap-2 font-semibold">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                        </svg>
                        Export PDF
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Content -->
    <div class="w-full px-4 sm:px-6 lg:px-8 py-8">
        <!-- Financial Summary Cards -->
        <div class="grid grid-cols-1 lg:grid-cols-4 gap-6 mb-8">
            <div class="bg-gradient-to-r from-green-500 to-green-600 text-white rounded-2xl p-6 shadow-lg">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-green-100 text-sm font-medium">Total Revenue</p>
                        <p class="text-2xl lg:text-3xl font-bold mt-1">Ugx:{{ number_format($revenue, 2) }}</p>
                    </div>
                    <div class="p-3 bg-green-400/20 rounded-xl">
                        <svg class="w-6 h-6 lg:w-8 lg:h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                </div>
            </div>

            <div class="bg-gradient-to-r from-red-500 to-red-600 text-white rounded-2xl p-6 shadow-lg">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-red-100 text-sm font-medium">Total Costs</p>
                        <p class="text-2xl lg:text-3xl font-bold mt-1">Ugx:{{ number_format($cogs + $expenses, 2) }}</p>
                    </div>
                    <div class="p-3 bg-red-400/20 rounded-xl">
                        <svg class="w-6 h-6 lg:w-8 lg:h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                        </svg>
                    </div>
                </div>
            </div>

            <div class="bg-gradient-to-r from-blue-500 to-blue-600 text-white rounded-2xl p-6 shadow-lg">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-blue-100 text-sm font-medium">Gross Profit</p>
                        <p class="text-2xl lg:text-3xl font-bold mt-1">Ugx:{{ number_format($revenue - $cogs, 2) }}</p>
                    </div>
                    <div class="p-3 bg-blue-400/20 rounded-xl">
                        <svg class="w-6 h-6 lg:w-8 lg:h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"/>
                        </svg>
                    </div>
                </div>
            </div>

            <div class="bg-gradient-to-r from-purple-500 to-purple-600 text-white rounded-2xl p-6 shadow-lg">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-purple-100 text-sm font-medium">Net Profit</p>
                        <p class="text-2xl lg:text-3xl font-bold mt-1 {{ $netProfit >= 0 ? 'text-white' : 'text-yellow-300' }}">
                            Ugx:{{ number_format($netProfit, 2) }}
                        </p>
                    </div>
                    <div class="p-3 bg-purple-400/20 rounded-xl">
                        <svg class="w-6 h-6 lg:w-8 lg:h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                        </svg>
                    </div>
                </div>
            </div>
        </div>

        <!-- Main Financial Statement -->
        <div class="grid grid-cols-1 xl:grid-cols-3 gap-8 mb-8">
            <!-- Profit & Loss Statement -->
            <div class="xl:col-span-2 bg-white rounded-2xl shadow-lg overflow-hidden">
                <div class="bg-gradient-to-r from-gray-800 to-gray-900 px-8 py-6">
                    <h2 class="text-2xl font-semibold text-white flex items-center gap-3">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                        </svg>
                        Profit & Loss Statement
                    </h2>
                </div>

                <div class="p-8">
                    <div class="space-y-6">
                        <!-- Revenue Section -->
                        <div class="flex justify-between items-center py-4 border-b border-gray-200">
                            <div class="flex items-center gap-4">
                                <div class="p-3 bg-green-100 rounded-xl">
                                    <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                    </svg>
                                </div>
                                <div>
                                    <h3 class="text-lg font-semibold text-gray-900">Total Revenue</h3>
                                    <p class="text-sm text-gray-500">Gross sales income</p>
                                </div>
                            </div>
                            <span class="text-2xl font-bold text-green-600">Ugx:{{ number_format($revenue, 2) }}</span>
                        </div>

                        <!-- COGS Section -->
                        <div class="flex justify-between items-center py-4 border-b border-gray-200">
                            <div class="flex items-center gap-4">
                                <div class="p-3 bg-red-100 rounded-xl">
                                    <svg class="w-6 h-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 14l-7 7m0 0l-7-7m7 7V3"/>
                                    </svg>
                                </div>
                                <div>
                                    <h3 class="text-lg font-semibold text-gray-900">Cost of Goods Sold</h3>
                                    <p class="text-sm text-gray-500">Direct costs of production</p>
                                </div>
                            </div>
                            <span class="text-2xl font-bold text-red-600">-Ugx:{{ number_format($cogs, 2) }}</span>
                        </div>

                        <!-- Gross Profit -->
                        <div class="flex justify-between items-center py-4 border-b border-gray-300 bg-blue-50 -mx-8 px-8">
                            <div class="flex items-center gap-4">
                                <div class="p-3 bg-blue-100 rounded-xl">
                                    <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"/>
                                    </svg>
                                </div>
                                <div>
                                    <h3 class="text-lg font-semibold text-gray-900">Gross Profit</h3>
                                    <p class="text-sm text-gray-500">Revenue - COGS</p>
                                </div>
                            </div>
                            <span class="text-2xl font-bold text-blue-600">Ugx{{ number_format($revenue - $cogs, 2) }}</span>
                        </div>

                        <!-- Expenses Section -->
                        <div class="flex justify-between items-center py-4 border-b border-gray-200">
                            <div class="flex items-center gap-4">
                                <div class="p-3 bg-orange-100 rounded-xl">
                                    <svg class="w-6 h-6 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                                    </svg>
                                </div>
                                <div>
                                    <h3 class="text-lg font-semibold text-gray-900">Operating Expenses</h3>
                                    <p class="text-sm text-gray-500">Overhead and operational costs</p>
                                </div>
                            </div>
                            <span class="text-2xl font-bold text-red-600">-Ugx:{{ number_format($expenses, 2) }}</span>
                        </div>

                        <!-- Net Profit Section -->
                        <div class="flex justify-between items-center py-6 bg-gradient-to-r from-gray-50 to-gray-100 -mx-8 px-8 rounded-lg mt-6">
                            <div class="flex items-center gap-4">
                                <div class="p-3 {{ $netProfit >= 0 ? 'bg-green-100' : 'bg-red-100' }} rounded-xl">
                                    <svg class="w-7 h-7 {{ $netProfit >= 0 ? 'text-green-600' : 'text-red-600' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                                    </svg>
                                </div>
                                <div>
                                    <h3 class="text-xl font-bold text-gray-900">Net Profit / Loss</h3>
                                    <p class="text-sm text-gray-500">Final financial result</p>
                                </div>
                            </div>
                            <span class="text-3xl font-bold {{ $netProfit >= 0 ? 'text-green-700' : 'text-red-700' }}">
                                Ugx:{{ number_format($netProfit, 2) }}
                            </span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Performance Metrics -->
            <div class="bg-white rounded-2xl shadow-lg overflow-hidden">
                <div class="bg-gradient-to-r from-purple-600 to-purple-700 px-8 py-6">
                    <h2 class="text-2xl font-semibold text-white flex items-center gap-3">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"/>
                        </svg>
                        Performance Metrics
                    </h2>
                </div>

                <div class="p-8 space-y-8">
                    <!-- Profit Margin -->
                    <div class="text-center">
                        <div class="mb-4">
                            <h3 class="text-lg font-semibold text-gray-900 mb-2">Profit Margin</h3>
                            <p class="text-sm text-gray-500">Net profit as percentage of revenue</p>
                        </div>
                        <div class="relative inline-block">
                            <div class="w-32 h-32 rounded-full border-8 {{ $revenue > 0 ? ($netProfit >= 0 ? 'border-green-200' : 'border-red-200') : 'border-gray-200' }} flex items-center justify-center">
                                <div class="text-center">
                                    <div class="text-2xl font-bold {{ $revenue > 0 ? ($netProfit >= 0 ? 'text-green-600' : 'text-red-600') : 'text-gray-600' }}">
                                        {{ $revenue > 0 ? number_format(($netProfit / $revenue) * 100, 1) : 0 }}%
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Expense Ratio -->
                    <div class="text-center">
                        <div class="mb-4">
                            <h3 class="text-lg font-semibold text-gray-900 mb-2">Expense Ratio</h3>
                            <p class="text-sm text-gray-500">Expenses as percentage of revenue</p>
                        </div>
                        <div class="relative inline-block">
                            <div class="w-32 h-32 rounded-full border-8 border-orange-200 flex items-center justify-center">
                                <div class="text-center">
                                    <div class="text-2xl font-bold text-orange-600">
                                        {{ $revenue > 0 ? number_format(($expenses / $revenue) * 100, 1) : 0 }}%
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Gross Margin -->
                    <div class="text-center">
                        <div class="mb-4">
                            <h3 class="text-lg font-semibold text-gray-900 mb-2">Gross Margin</h3>
                            <p class="text-sm text-gray-500">Gross profit as percentage of revenue</p>
                        </div>
                        <div class="relative inline-block">
                            <div class="w-32 h-32 rounded-full border-8 border-blue-200 flex items-center justify-center">
                                <div class="text-center">
                                    <div class="text-2xl font-bold text-blue-600">
                                        {{ $revenue > 0 ? number_format((($revenue - $cogs) / $revenue) * 100, 1) : 0 }}%
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Additional Insights -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Revenue Composition -->
            <div class="bg-white rounded-2xl shadow-lg p-8">
                <h3 class="text-xl font-semibold text-gray-900 mb-6 flex items-center gap-3">
                    <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    Revenue Insights
                </h3>
                <div class="space-y-4">
                    <div class="flex justify-between items-center">
                        <span class="text-gray-600">Gross Revenue</span>
                        <span class="font-semibold text-green-600">Ugx:{{ number_format($revenue, 2) }}</span>
                    </div>
                    <div class="flex justify-between items-center">
                        <span class="text-gray-600">After COGS</span>
                        <span class="font-semibold text-blue-600">Ugx{{ number_format($revenue - $cogs, 2) }}</span>
                    </div>
                    <div class="flex justify-between items-center">
                        <span class="text-gray-600">After Expenses</span>
                        <span class="font-semibold {{ $netProfit >= 0 ? 'text-green-600' : 'text-red-600' }}">Ugx:{{ number_format($netProfit, 2) }}</span>
                    </div>
                </div>
            </div>

            <!-- Cost Breakdown -->
            <div class="bg-white rounded-2xl shadow-lg p-8">
                <h3 class="text-xl font-semibold text-gray-900 mb-6 flex items-center gap-3">
                    <svg class="w-6 h-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                    </svg>
                    Cost Breakdown
                </h3>
                <div class="space-y-4">
                    <div class="flex justify-between items-center">
                        <span class="text-gray-600">Cost of Goods</span>
                        <span class="font-semibold text-red-600">Ugx:{{ number_format($cogs, 2) }}</span>
                    </div>
                    <div class="flex justify-between items-center">
                        <span class="text-gray-600">Operating Expenses</span>
                        <span class="font-semibold text-orange-600">Ugx:{{ number_format($expenses, 2) }}</span>
                    </div>
                    <div class="flex justify-between items-center border-t pt-4">
                        <span class="text-gray-600 font-semibold">Total Costs</span>
                        <span class="font-bold text-red-700">Ugx:{{ number_format($cogs + $expenses, 2) }}</span>
                    </div>
                </div>
            </div>

            <!-- Performance Summary -->
            <div class="bg-white rounded-2xl shadow-lg p-8">
                <h3 class="text-xl font-semibold text-gray-900 mb-6 flex items-center gap-3">
                    <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"/>
                    </svg>
                    Performance Summary
                </h3>
                <div class="space-y-4">
                    <div class="flex justify-between items-center">
                        <span class="text-gray-600">Profitability</span>
                        <span class="font-semibold {{ $netProfit >= 0 ? 'text-green-600' : 'text-red-600' }}">
                            {{ $netProfit >= 0 ? 'Profitable' : 'Loss' }}
                        </span>
                    </div>
                   @php
    $revenueEfficiency = ($revenue > 0) ? (($revenue - $cogs) / $revenue) : 0;
@endphp

<div class="flex justify-between items-center">
    <span class="text-gray-600">Revenue Efficiency</span>
    <span class="font-semibold {{ $revenueEfficiency > 0.3 ? 'text-green-600' : 'text-orange-600' }}">
        {{ number_format($revenueEfficiency * 100, 1) }}%
    </span>
</div>

                    @php
    $expenseControl = ($revenue > 0) ? ($expenses / $revenue) : 0;
@endphp

<div class="flex justify-between items-center">
    <span class="text-gray-600">Expense Control</span>
    <span class="font-semibold {{ $expenseControl < 0.5 ? 'text-green-600' : 'text-red-600' }}">
        {{ number_format($expenseControl * 100, 1) }}%
    </span>
</div>

                </div>
            </div>
        </div>
    </div>
</div>

<style>
    @media print {
        .bg-gradient-to-br {
            background: white !important;
        }
        .shadow-lg {
            box-shadow: none !important;
        }
        button {
            display: none !important;
        }
        .gap-6, .gap-8 {
            gap: 1rem !important;
        }
    }

    .animate-fade-in {
        animation: fadeIn 0.6s ease-in-out;
    }

    @keyframes fadeIn {
        from {
            opacity: 0;
            transform: translateY(20px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }
</style>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Add fade-in animation to cards
        const cards = document.querySelectorAll('.bg-white');
        cards.forEach((card, index) => {
            card.style.animation = `fadeIn 0.6s ease-in-out ${index * 0.1}s both`;
        });
    });
</script>
@endsection
