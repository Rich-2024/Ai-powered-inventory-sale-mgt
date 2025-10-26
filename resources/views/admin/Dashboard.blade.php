@extends('layouts.app')

@section('content')
<div class="dashboard">
    <h1 class="page-title">Admin Dashboard</h1>
    <p class="page-subtitle">Manage products, monitor sales, and oversee your team efficiently.</p>

    <!-- Sales Summary -->
   <section class="card">
    <h2 class="section-title">Sales Summary</h2>
    <div class="stats-grid d-flex gap-4">
        <div class="stat-box p-3 border rounded flex-fill">
            <i class="fas fa-calendar-day stat-icon"></i>
            <div>
                <h3>Today's Sales</h3>
                <p class="stat-value">UGX {{ number_format($totalSalesToday, 2) }}</p>
            </div>
        </div>
        <div class="stat-box p-3 border rounded flex-fill">
            <i class="fas fa-user-check stat-icon"></i>
            <div>
        <h3>My Employees</h3>
        <p class="stat-value">{{ $totalEmployees }}</p>
            </div>
        </div>
        <div class="stat-box p-3 border rounded flex-fill">
            <i class="fas fa-chart-line stat-icon"></i>
            <div>
                <h3>Monthly Sales (All Employees)</h3>
                <p class="stat-value">UGX {{ number_format($totalMonthlySales, 2) }}</p>
            </div>
        </div>
    </div>
</section>


    <!-- Low Stock Products -->
    <section class="card">
        <h2 class="section-title">Low Stock Products</h2>
        @if($lowStockProducts->count())
            <ul class="product-list">
                @foreach($lowStockProducts as $product)
                    <li class="product-item">
                        <i class="fas fa-exclamation-triangle text-warning"></i>
                        <span>{{ $product->name }}</span>
                        <span class="badge">{{ $product->quantity }} in stock</span>
                    </li>
                @endforeach
            </ul>
        @else
            <p class="empty-text"> sufficiently stock All products </p>
        @endif
    </section>
</div>

<style>
    .dashboard {
        display: flex;
        flex-direction: column;
        gap: 2rem;
    }
    .page-title {
        font-size: 2rem;
        font-weight: 700;
        margin-bottom: .25rem;
    }
    .page-subtitle {
        color: #6b7280;
        font-size: 1rem;
        margin-bottom: 1.5rem;
    }
    .card {
        background-color: var(--bg-dark);
        color: var(--text-dark);
        padding: 1.5rem;
        border-radius: 12px;
        box-shadow: 0 4px 10px rgba(0,0,0,0.05);
    }
    [data-theme="light"] .card {
        background-color: #ffffff;
        color: #1f2937;
    }
    .section-title {
        font-size: 1.25rem;
        font-weight: 600;
        margin-bottom: 1rem;
    }
    .stats-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
        gap: 1rem;
    }
    .stat-box {
        background: rgba(0,0,0,0.05);
        border-radius: 8px;
        padding: 1rem;
        display: flex;
        align-items: center;
        gap: 1rem;
    }
    [data-theme="dark"] .stat-box {
        background: rgba(255,255,255,0.05);
    }
    .stat-icon {
        font-size: 1.5rem;
        color: var(--primary);
    }
    .stat-value {
        font-size: 1.2rem;
        font-weight: bold;
    }

    .product-list {
        list-style: none;
        padding: 0;
        margin: 0;
    }
    .product-item {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: .5rem 0;
        border-bottom: 1px solid rgba(0,0,0,0.05);
    }
    .badge {
        background: #f97316;
        color: #fff;
        padding: 0.25rem 0.6rem;
        border-radius: 20px;
        font-size: 0.8rem;
        font-weight: 600;
    }
    [data-theme="dark"] .badge {
        background: #fb923c;
        color: #111827;
    }
    .empty-text {
        font-style: italic;
        color: #6b7280;
    }
</style>
@endsection
