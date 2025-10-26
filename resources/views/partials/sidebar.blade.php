@if(Auth::user()->role === 'admin')
    <a href="{{ route('admin.dashboard') }}"><i class="bi bi-speedometer2 me-2"></i> Dashboard</a>
    <a href="{{ route('admin.products.index') }}"><i class="bi bi-box-seam me-2"></i> Products</a>
    <a href="{{ route('admin.sales') }}"><i class="bi bi-bar-chart me-2"></i> Sales Report</a>
    <a href="{{ route('admin.employees') }}"><i class="bi bi-people me-2"></i> Employees</a>
@else
    <a href="{{ route('employee.dashboard') }}"><i class="bi bi-speedometer2 me-2"></i> Dashboard</a>
    <a href="{{ route('employee.sales.create') }}"><i class="bi bi-plus-circle me-2"></i> Record Sale</a>
    <a href="{{ route('employee.sales.history') }}"><i class="bi bi-clock-history me-2"></i> Today's Sales</a>
    <a href="{{ route('employee.prices') }}"><i class="bi bi-search me-2"></i> Price Check</a>
    <a href="{{ route('employee.messages.create') }}"><i class="bi bi-chat-dots me-2"></i> Message Admin</a>
@endif
