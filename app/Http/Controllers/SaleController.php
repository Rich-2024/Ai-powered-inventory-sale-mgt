<?php

namespace App\Http\Controllers;
use App\Models\Product;
use App\Models\Sale;
use App\Models\CreditSale;
use App\Models\JournalEntry;
use App\Models\JournalLine;
use App\Models\InventoryHistory;
use App\Models\User;
use App\Models\Account;
use App\Models\jou;
use App\Models\Expense;
use Exception;
use App\Models\Inventory;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Log;

class SaleController extends Controller
{
public function create()
{
    $user = auth()->user();

    if ($user->role === 'admin') {
        // Admin sees only their own products
        $products = Inventory::where('quantity', '>', 0)
            ->where('admin_id', $user->id)
            ->get();

        return view('Admin.sale', compact('products'));

    } elseif ($user->role === 'employee') {
        // Employee sees products of their admin
        $products = Product::where('quantity', '>', 0)
            ->where('admin_id', $user->admin_id) // <- VERY IMPORTANT
            ->get();

        return view('employee.sales.create', compact('products'));

    } else {
        abort(403); // unauthorized
    }
}


    // public function create()
    // {
    //     // Show only products with available quantity
    //     $products = Product::where('quantity', '>', 0)->get();
    //     return view('employee.sales.create', compact('products'));
    // }

//
// public function store(Request $request) {
//     $data = $request->validate([
//         'product_id' => 'required|exists:products,id',
//         'quantity' => 'required|integer|min:1',
//         'amount_sold' => 'required|numeric|min:1',
//     ]);

//     $product = Product::findOrFail($data['product_id']);
//     $minTotal = $product->price * $data['quantity'];

//     if ($data['amount_sold'] < $minTotal) {
//         return back()->with('error','Amount must be at least UGX ' . number_format($minTotal));
//     }

//     if ($product->quantity < $data['quantity']) {
//         return back()->with('error','Not enough stock');
//     }

//     // Store previous quantity before decrement
//     $previousQuantity = $product->quantity;

//     // Create sale record
//     Sale::create([
//         'employee_id' => auth()->id(),
//         'user_id' => auth()->id(),
//         'product_id' => $data['product_id'],
//         'quantity' => $data['quantity'],
//         'total_amount' => $data['amount_sold'],
//     ]);

//     // Decrement product quantity
//     $product->decrement('quantity', $data['quantity']);

//     // Refresh product to get updated quantity
//     $product->refresh();

//     // Create inventory history record
//     InventoryHistory::create([
//         'product_id' => $product->id,
//         'user_id' => auth()->id(),
//         'type' => 'decrease', // sale reduces quantity
//         'quantity' => $data['quantity'],
//         'previous_quantity' => $previousQuantity,
//         'new_quantity' => $product->quantity,
//         'note' => 'Quantity decreased due to sale',
//     ]);

//     return redirect()->route('employee.sales.create')->with([
//         'success' => true,
//         'receipt' => [
//             'product' => $product->name,
//             'price' => $product->price,
//             'quantity' => $data['quantity'],
//             'amount' => $data['amount_sold'],
//             'date' => now()->format('Y-m-d H:i'),
//         ]
//     ]);
// }
// public function store(Request $request)
// {
//     $data = $request->validate([
//         'product_id' => 'required|exists:products,id',
//         'quantity' => 'required|integer|min:1',
//         'amount_sold' => 'required|numeric|min:1',
//     ]);

//     $product = Product::findOrFail($data['product_id']);
//     $minTotal = $product->price * $data['quantity'];

//     if ($data['amount_sold'] < $minTotal) {
//         return back()->with('error', 'Amount must be at least UGX ' . number_format($minTotal));
//     }

//     if ($product->quantity < $data['quantity']) {
//         return back()->with('error', 'Not enough stock');
//     }

//     $user = auth()->user();

//     // Determine the admin_id based on user role
//     // $adminId = $user->role === 'admin' ? $user->id : $user->admin_id;
// $adminId = $user->isAdmin() ? $user->id : $user->admin_id;
// $employeeId = $user->isAdmin() ? null : $user->id;
//     // Store previous quantity before decrement
//     $previousQuantity = $product->quantity;

//     // Create sale record
//     Sale::create([
//         'employee_id' => $user->id,      // could be admin or employee
//         'user_id' => $user->id,          // user who made the sale
//         'admin_id' => $adminId,          // ensure this is set correctly
//         'product_id' => $data['product_id'],
//         'quantity' => $data['quantity'],
//         'total_amount' => $data['amount_sold'],
//     ]);

//     // Decrement product quantity
//     $product->decrement('quantity', $data['quantity']);
//     $product->refresh();

//     // Log inventory history
//     InventoryHistory::create([
//         'product_id' => $product->id,
//         'user_id' => $user->id,
//         'type' => 'decrease',
//         'quantity' => $data['quantity'],
//         'previous_quantity' => $previousQuantity,
//         'new_quantity' => $product->quantity,
//         'note' => 'Quantity decreased due to sale',
//     ]);

//     // Choose redirect route based on role
//     $route = $user->role === 'admin' ? 'admin.sales.create' : 'employee.sales.create';

//     return redirect()->route($route)->with([
//         'success' => true,
//         'receipt' => [
//             'product' => $product->name,
//             'price' => $product->price,
//             'quantity' => $data['quantity'],
//             'amount' => $data['amount_sold'],
//             'date' => now()->format('Y-m-d H:i'),
//         ]
//     ]);
// }
// public function store(Request $request)
// {
//     $data = $request->validate([
//         'product_id' => 'required|exists:products,id',
//         'quantity' => 'required|integer|min:1',
//         'unit' => 'required|in:piece,dozen,carton',
//         'amount_sold' => 'required|numeric|min:1',
//     ]);

//     $product = Product::findOrFail($data['product_id']);

//     // Convert sold quantity to pieces
//     $unit = $data['unit'];
//     $quantity = $data['quantity'];
//     $totalPieces = $product->convertToPieces($quantity, $unit);

//     // Calculate price per piece
//     $pricePerPiece = match ($unit) {
//         'piece' => $product->selling_price_per_piece,
//         'dozen' => ($product->selling_price_per_dozen ?? ($product->selling_price_per_piece * 12)) / 12,
//         'carton' => ($product->selling_price_per_carton ?? ($product->selling_price_per_piece * $product->unit_conversion)) / $product->unit_conversion,
//         default => 0,
//     };

//     $minTotal = $pricePerPiece * $totalPieces;

//     if ($data['amount_sold'] < $minTotal) {
//         return back()->withInput()->with('error', 'Amount must be at least UGX ' . number_format($minTotal));
//     }

//     if ($totalPieces > $product->total_pieces) {
//         return back()->with('error', 'Not enough stock available');
//     }

//     $user = auth()->user();
//     $adminId = $user->isAdmin() ? $user->id : $user->admin_id;
//     $previousTotalPieces = $product->total_pieces;

//     // Deduct pieces
//     $product->total_pieces -= $totalPieces;
//     $product->recalculateUnitsFromPieces(); // Recalculate cartons/dozens & loose

//     // Record the sale
//     Sale::create([
//         'employee_id' => $user->isAdmin() ? null : $user->id,
//         'user_id' => $user->id,
//         'admin_id' => $adminId,
//         'product_id' => $product->id,
//         'quantity' => $quantity,
//         'unit' => $unit,
//         'total_amount' => $data['amount_sold'],
//     ]);

//     // Inventory log
//     InventoryHistory::create([
//         'product_id' => $product->id,
//         'user_id' => $user->id,
//         'type' => 'decrease',
//         'quantity' => $totalPieces,
//         'previous_quantity' => $previousTotalPieces,
//         'new_quantity' => $product->total_pieces,
//         'note' => "Sold {$quantity} {$unit}(s)",
//     ]);

//     // Redirect with receipt
//     $route = $user->isAdmin() ? 'admin.sales.create' : 'employee.sales.create';

//     return redirect()->route($route)->with([
//         'success' => true,
//         'receipt' => [
//             'product' => $product->name,
//             'unit' => ucfirst($unit),
//             'price' => round($pricePerPiece * ($unit === 'piece' ? 1 : ($unit === 'dozen' ? 12 : $product->unit_conversion))),
//             'quantity' => $quantity,
//             'amount' => $data['amount_sold'],
//             'date' => now()->format('Y-m-d H:i'),
//         ]
//     ]);
// }

// public function store(Request $request)
// {
//     //  dd($request->all());
//     $data = $request->validate([
//         'product_id'          => 'required|exists:products,id',
//         'quantity'            => 'required|integer|min:1',
//         'unit'                => 'required|in:piece,dozen,carton',
//         'amount_sold'         => 'required|numeric|min:1',
//         'discount'            => 'nullable|numeric|min:0|max:100',
//         'total_pieces_value'  => 'required|integer|min:1',
//     ]);

//     $product = Inventory::findOrFail($data['product_id']);
//     $unit         = $data['unit'];
//     $quantity     = $data['quantity'];
//     $totalPieces  = $data['total_pieces_value'];
//     $discount     = ($unit !== 'piece') ? floatval($data['discount'] ?? 0) : 0;

//     // Get the price per piece (same across units)
//     $pricePerPiece = $product->price;

//     // Calculate expected total and apply discount if any
//     $expectedTotal = $pricePerPiece * $totalPieces;
//     $finalTotal = $discount > 0
//         ? $expectedTotal - ($expectedTotal * $discount / 100)
//         : $expectedTotal;

//     if ($totalPieces > $product->total_pieces) {
//         return back()->with('error', 'Not enough stock available. Only ' . $product->total_pieces . ' pieces in stock.');
//     }

//     if ($data['amount_sold'] < $finalTotal) {
//         return back()->withInput()->with('error', 'Amount must be at least UGX ' . number_format($finalTotal));
//     }

//     // Adjust stock
//     $user = auth()->user();
//     $adminId = $user->isAdmin() ? $user->id : $user->admin_id;
//     $previousStock = $product->total_pieces;

//     $product->total_pieces -= $totalPieces;
//     $product->recalculateUnitsFromPieces(); // Optional: maintain unit breakdown
//     $product->save();

//     // Record the sale
//     Sale::create([
//         'employee_id'      => $user->isAdmin() ? null : $user->id,
//         'user_id'          => $user->id,
//         'admin_id'         => $adminId,
//         'product_id'       => $product->id,
//         'quantity'         => $quantity,
//         'unit'             => $unit,
//         'pieces_sold'      => $totalPieces,
//         'price_per_piece'  => $pricePerPiece,
//         'discount'         => $discount,
//         'total_amount'     => $data['amount_sold'],
//     ]);

//     // Log the inventory deduction
//     InventoryHistory::create([
//         'product_id'        => $product->id,
//         'user_id'           => $user->id,
//         'type'              => 'decrease',
//         'quantity'          => $totalPieces,
//         'previous_quantity' => $previousStock,
//         'new_quantity'      => $product->total_pieces,
//         'note'              => "Sold {$quantity} {$unit}(s) ({$totalPieces} pieces)",
//     ]);

//     $route = $user->isAdmin() ? 'admin.sales.create' : 'employee.sales.create';

//     return redirect()->route($route)->with([
//         'success' => true,
//         'receipt' => [
//             'product'   => $product->name,
//             'unit'      => ucfirst($unit),
//             'price'     => $pricePerPiece,
//             'quantity'  => $quantity,
//             'amount'    => $data['amount_sold'],
//             'date'      => now()->format('Y-m-d H:i'),
//         ]
//     ]);
// }

public function history(Request $request)
{
    $user = Auth::user();

    $period = $request->get('period', 'today');
    $search = $request->get('search', '');

    // Base query depends on user role
    $query = Sale::with('product')->orderByDesc('created_at');

    if ($user->isAdmin()) {
        // Admin sees all sales under their admin ID
        $query->where('admin_id', $user->id);
    } else {
        // Employee sees only their own sales under their admin
        $query->where('admin_id', $user->admin_id)
              ->where('employee_id', $user->id);
    }

    // Filter by period
    if ($period === 'today') {
        $query->whereDate('created_at', now()->toDateString());
    } elseif ($period === 'week') {
        $query->whereBetween('created_at', [now()->startOfWeek(), now()->endOfWeek()]);
    } elseif ($period === 'month') {
        $query->whereYear('created_at', now()->year)
              ->whereMonth('created_at', now()->month);
    }

    // Filter by product search
    if ($search) {
        $query->whereHas('product', function ($q) use ($search) {
            $q->where('name', 'like', "%$search%")
              ->orWhere('id', $search);
        });
    }

    $sales = $query->paginate(15);

    // Total sales for filtered query
    $totalSales = (clone $query)->sum('total_amount');

    // Most sold products with same filtering
    $mostSold = Sale::select('product_id')
        ->with('product')
        ->selectRaw('SUM(quantity) as total_quantity')
        ->groupBy('product_id')
        ->orderByDesc('total_quantity');

    if ($user->isAdmin()) {
        $mostSold->where('admin_id', $user->id);
    } else {
        $mostSold->where('admin_id', $user->admin_id)
                 ->where('employee_id', $user->id);
    }

    // Apply period filter to most sold products as well
    if ($period === 'today') {
        $mostSold->whereDate('created_at', now()->toDateString());
    } elseif ($period === 'week') {
        $mostSold->whereBetween('created_at', [now()->startOfWeek(), now()->endOfWeek()]);
    } elseif ($period === 'month') {
        $mostSold->whereYear('created_at', now()->year)
                 ->whereMonth('created_at', now()->month);
    }

    $mostSold = $mostSold->get()->map(function ($sale) {
        $sale->name = $sale->product->name ?? 'Unknown';
        return $sale;
    });

    return view('employee.sales.history', compact('sales', 'totalSales', 'mostSold'));
}

public function report(Request $request)
{
    $period = $request->input('period', 'daily');

    // Base query for sales belonging to the logged-in employee
    $query = Sale::where('employee_id', auth()->id());

    // Filter sales based on the selected period
    if ($period === 'daily') {
        $date = $request->input('daily_date', now()->toDateString());
        $query->whereDate('created_at', $date);
    } elseif ($period === 'weekly') {
        $date = $request->input('weekly_date', now()->toDateString());
        // Get start and end of the week for given date (Monday - Sunday)
        $startOfWeek = \Carbon\Carbon::parse($date)->startOfWeek();
        $endOfWeek = \Carbon\Carbon::parse($date)->endOfWeek();
        $query->whereBetween('created_at', [$startOfWeek, $endOfWeek]);
    } elseif ($period === 'monthly') {
        $month = $request->input('monthly_month', now()->format('Y-m'));
        $query->whereYear('created_at', substr($month, 0, 4))
              ->whereMonth('created_at', substr($month, 5, 2));
    } elseif ($period === 'custom') {
        $from = $request->input('from');
        $to = $request->input('to');
        if ($from && $to) {
            $query->whereBetween('created_at', [$from, $to]);
        }
    }

    // Get sales with product relation
    $sales = $query->with('product')->get();

    // Check for no sales in custom range
    $noSalesMessage = null;
    if ($sales->isEmpty() && $period === 'custom') {
        $noSalesMessage = "No sales found for the selected date range: {$request->input('from')} to {$request->input('to')}.";
    }

    // Group sales by product_id to calculate total quantity and total amount per product
    $grouped = $sales->groupBy('product_id')->map(function ($items) {
        $product = $items->first()->product;
        return [
            'product_name' => $product ? $product->name : 'Unknown',
            'unit_price' => $product ? $product->price : 0,
            'total_quantity' => $items->sum('quantity'),
            'total_amount' => $items->sum('total_amount'),
        ];
    });

    // Total sales amount for the period
    $totalSalesAmount = $sales->sum('total_amount');

    // Most sold products (top 5) by quantity sold
    $mostSoldProducts = $grouped->sortByDesc('total_quantity')->take(5);

    // Pass all variables to the view
    return view('employee.sales.report', [
        'sales' => $sales,
        'grouped' => $grouped,
        'totalSalesAmount' => $totalSalesAmount,
        'mostSoldProducts' => $mostSoldProducts,
        'period' => $period,
        'from' => $request->input('from', ''),
        'to' => $request->input('to', ''),
        'daily_date' => $request->input('daily_date', now()->toDateString()),
        'weekly_date' => $request->input('weekly_date', now()->toDateString()),
        'monthly_month' => $request->input('monthly_month', now()->format('Y-m')),
        'noSalesMessage' => $noSalesMessage,
    ]);
}


//admin
// public function salesReport(Request $request)
// {
//     $admin = Auth::user();

//     // Get filter params
//     $period = $request->input('period', 'daily');
//     $from = $request->input('from');
//     $to = $request->input('to');

//     // Determine date range
//     switch ($period) {
//         case 'weekly':
//             $start = Carbon::now()->startOfWeek();
//             $end = Carbon::now()->endOfWeek();
//             break;

//         case 'monthly':
//             $start = Carbon::now()->startOfMonth();
//             $end = Carbon::now()->endOfMonth();
//             break;

//         case 'custom':
//             try {
//                 $start = $from ? Carbon::parse($from)->startOfDay() : Carbon::today();
//                 $end = $to ? Carbon::parse($to)->endOfDay() : Carbon::today()->endOfDay();

//                 if ($end->lt($start)) {
//                     [$start, $end] = [$end, $start]; // swap if needed
//                 }
//             } catch (\Exception $e) {
//                 $start = Carbon::today();
//                 $end = Carbon::today()->endOfDay();
//                 $period = 'daily';
//             }
//             break;

//         case 'daily':
//         default:
//             $start = Carbon::today();
//             $end = Carbon::today()->endOfDay();
//             $period = 'daily';
//             break;
//     }

//     // Get employee IDs under the current admin
//     $employeeIds = User::where('role', 'employee')
//         ->where('admin_id', $admin->id)
//         ->pluck('id');

//     // Fetch sales within the date range for those employees
//     $sales = Sale::with(['employee', 'product'])
//         ->whereIn('employee_id', $employeeIds)
//         ->whereBetween('created_at', [$start, $end])
//         ->get();

//     // Group sales by employee and then by product
//     $groupedByEmployee = $sales->groupBy(fn($sale) => $sale->employee->name ?? 'Unknown Employee')
//         ->map(function ($employeeSales) {
//             $products = $employeeSales->groupBy(fn($sale) => $sale->product->name ?? 'Unknown Product')
//                 ->map(function ($productSales) {
//                     $price = $productSales->first()->product->price ?? 0;
//                     $quantity_sold = $productSales->sum('quantity');
//                     $total_sales = $productSales->sum('total_amount'); // use DB field
//                     return [
//                         'price' => $price,
//                         'quantity_sold' => $quantity_sold,
//                         'total_sales' => $total_sales,
//                     ];
//                 });

//             $total_sales = $products->sum('total_sales');

//             return [
//                 'products' => $products,
//                 'total_sales' => $total_sales,
//             ];
//         });

//     // Get top 5 most sold products across all employees
//     $mostSoldProducts = $sales->groupBy(fn($sale) => $sale->product->name ?? 'Unknown Product')
//         ->map(function ($group) {
//             $quantity_sold = $group->sum('quantity');
//             $price = $group->first()->product->price ?? 0;
//             return [
//                 'quantity_sold' => $quantity_sold,
//                 'price' => $price,
//             ];
//         })
//         ->sortByDesc('quantity_sold')
//         ->take(5);

//     // Total sales across all employees
//     $totalSalesAmount = $sales->sum('total_amount');
//  $adminExpenses = Expense::with('employee')
//         ->latest()
//         ->paginate(10);
//     return view('Admin.admin.sales.report', compact(
//         'period', 'from', 'to', 'groupedByEmployee',
//         'mostSoldProducts', 'start', 'end', 'adminExpenses' => $adminExpenses,'totalSalesAmount'
//     ));
// }
// public function salesReport(Request $request)
// {
//     $admin = Auth::user();

//     // Get filter params
//     $period = $request->input('period', 'daily');
//     $from = $request->input('from');
//     $to = $request->input('to');

//     // Determine date range
//     switch ($period) {
//         case 'weekly':
//             $start = Carbon::now()->startOfWeek();
//             $end = Carbon::now()->endOfWeek();
//             break;

//         case 'monthly':
//             $start = Carbon::now()->startOfMonth();
//             $end = Carbon::now()->endOfMonth();
//             break;

//         case 'custom':
//             try {
//                 $start = $from ? Carbon::parse($from)->startOfDay() : Carbon::today();
//                 $end = $to ? Carbon::parse($to)->endOfDay() : Carbon::today()->endOfDay();

//                 if ($end->lt($start)) {
//                     [$start, $end] = [$end, $start]; // swap if needed
//                 }
//             } catch (\Exception $e) {
//                 $start = Carbon::today();
//                 $end = Carbon::today()->endOfDay();
//                 $period = 'daily';
//             }
//             break;

//         case 'daily':
//         default:
//             $start = Carbon::today();
//             $end = Carbon::today()->endOfDay();
//             $period = 'daily';
//             break;
//     }

//     // Get employee IDs under the current admin
//     $employeeIds = User::where('role', 'employee')
//         ->where('admin_id', $admin->id)
//         ->pluck('id');

//     // Fetch sales within the date range for those employees
//     $sales = Sale::with(['employee', 'product'])
//         ->whereIn('employee_id', $employeeIds)
//         ->whereBetween('created_at', [$start, $end])
//         ->get();

//     // Group sales by employee and then by product
//     $groupedByEmployee = $sales->groupBy(fn($sale) => $sale->employee->name ?? 'Unknown Employee')
//         ->map(function ($employeeSales) {
//             $products = $employeeSales->groupBy(fn($sale) => $sale->product->name ?? 'Unknown Product')
//                 ->map(function ($productSales) {
//                     $price = $productSales->first()->product->price ?? 0;
//                     $quantity_sold = $productSales->sum('quantity');
//                     $total_sales = $productSales->sum('total_amount'); // use DB field
//                     return [
//                         'price' => $price,
//                         'quantity_sold' => $quantity_sold,
//                         'total_sales' => $total_sales,
//                     ];
//                 });

//             $total_sales = $products->sum('total_sales');

//             return [
//                 'products' => $products,
//                 'total_sales' => $total_sales,
//             ];
//         });

//     // Get top 5 most sold products across all employees
//     $mostSoldProducts = $sales->groupBy(fn($sale) => $sale->product->name ?? 'Unknown Product')
//         ->map(function ($group) {
//             $quantity_sold = $group->sum('quantity');
//             $price = $group->first()->product->price ?? 0;
//             return [
//                 'quantity_sold' => $quantity_sold,
//                 'price' => $price,
//             ];
//         })
//         ->sortByDesc('quantity_sold')
//         ->take(5);

//     // Total sales across all employees
//     $totalSalesAmount = $sales->sum('total_amount');

//     // Fetch admin expenses paginated
//     $adminExpenses = Expense::with('employee')
//         ->latest()
//         ->paginate(10);

//     // Return view with all variables
//     return view('Admin.admin.sales.report', compact(
//         'period', 'from', 'to', 'groupedByEmployee',
//         'mostSoldProducts', 'start', 'end', 'adminExpenses', 'totalSalesAmount'
//     ));
// }
//sale report to admin by employee
public function salesReport(Request $request)
{
    $admin = Auth::user();

    // Only admins can access this report
    if (! $admin->isAdmin()) {
        abort(403, 'Unauthorized access');
    }

    // Get filter params
    $period = $request->input('period', 'daily');
    $from = $request->input('from');
    $to = $request->input('to');

    // Determine date range
    switch ($period) {
        case 'weekly':
            $start = Carbon::now()->startOfWeek();
            $end = Carbon::now()->endOfWeek();
            break;

        case 'monthly':
            $start = Carbon::now()->startOfMonth();
            $end = Carbon::now()->endOfMonth();
            break;

        case 'custom':
            try {
                $start = $from ? Carbon::parse($from)->startOfDay() : Carbon::today();
                $end = $to ? Carbon::parse($to)->endOfDay() : Carbon::today()->endOfDay();

                if ($end->lt($start)) {
                    // Swap if end before start
                    [$start, $end] = [$end, $start];
                }
            } catch (\Exception $e) {
                // Fallback to today if parse fails
                $start = Carbon::today();
                $end = Carbon::today()->endOfDay();
                $period = 'daily';
            }
            break;

        case 'daily':
        default:
            $start = Carbon::today();
            $end = Carbon::today()->endOfDay();
            $period = 'daily';
            break;
    }

    // Get all employees under this admin
    $employeeIds = User::where('role', 'employee')
        ->where('admin_id', $admin->id)
        ->pluck('id');

    // Fetch sales for those employees in the date range
    $sales = Sale::with(['employee', 'product'])
        ->whereIn('employee_id', $employeeIds)
        ->whereBetween('created_at', [$start, $end])
        ->get();

    // Group by employee name
    $groupedByEmployee = $sales
        ->groupBy(fn($sale) => $sale->employee->name ?? 'Unknown Employee')
        ->map(function ($employeeSales) {
            // For this employee, group by product
            $products = $employeeSales
                ->groupBy(fn($sale) => $sale->product->name ?? 'Unknown Product')
                ->map(function ($productSales) {
                    $quantity_sold = $productSales->sum('quantity');
                    $total_sales = $productSales->sum('total_amount');
                    // Optionally, price from first record (if needed)
                    $price = $productSales->first()->product->price ?? 0;

                    return [
                        'price' => $price,
                        'quantity_sold' => $quantity_sold,
                        'total_sales' => $total_sales,
                    ];
                });

            $total_sales = $products->sum('total_sales');

            return [
                'products' => $products,
                'total_sales' => $total_sales,
            ];
        });

    // Get top sold products across all employees
    $mostSoldProducts = $sales
        ->groupBy(fn($sale) => $sale->product->name ?? 'Unknown Product')
        ->map(function ($group) {
            return [
                'quantity_sold' => $group->sum('quantity'),
                'price' => $group->first()->product->price ?? 0,
            ];
        })
        ->sortByDesc('quantity_sold')
        ->take(5);

    // Total sales across all employees
    $totalSalesAmount = $sales->sum('total_amount');

    // Fetch admin expenses if needed (pagination)
    $adminExpenses = Expense::with('employee')
        ->where('admin_id', $admin->id)
        ->latest()
        ->paginate(10);

    return view('admin.admin.sales.report', compact(
        'period', 'from', 'to',
        'groupedByEmployee', 'mostSoldProducts',
        'start', 'end', 'adminExpenses', 'totalSalesAmount'
    ));
}
//credit
public function storeCreditSale(Request $request)
{
    // dd($request->all());
    $data = $request->validate([
        'customer_name' => 'required|string|max:255',
        'product_id' => 'required|exists:inventories,id',
        'unit' => 'required|in:piece,dozen,carton',
        'quantity' => 'required|integer|min:1',
        'total_pieces_value' => 'required|integer|min:1',
        'price_value' => 'required|numeric|min:0',
        'amount_sold' => 'nullable|numeric|min:0',
        'balanceleft' => 'nullable|numeric|min:0',
        'discount' => 'nullable|numeric|min:0|max:100',
    ]);

    // Type casting
    $data['quantity'] = (int) $data['quantity'];
    $data['total_pieces_value'] = (int) $data['total_pieces_value'];
    $data['amount_sold'] = (float) $data['amount_sold'];
    $data['balanceleft'] = (float) $data['balanceleft'];
    $data['discount'] = isset($data['discount']) ? (float) $data['discount'] : 0.0;

    DB::beginTransaction();

    try {
        $product = Inventory::findOrFail($data['product_id']);
        if ($data['total_pieces_value'] > $product->quantity) {
            return back()->withInput()->with('error', 'Not enough stock. Only ' . $product->quantity . ' pieces available.');
        }

        $user = auth()->user();
        $adminId = $user->isAdmin() ? $user->id : $user->admin_id;

        // Update inventory
        $previousStock = $product->quantity;
        $product->quantity -= $data['total_pieces_value'];
        $product->save();

        // Create inventory history
        InventoryHistory::create([
            'product_id' => $product->id,
            'user_id' => $user->id,
            'type' => 'decrease',
            'quantity' => $data['total_pieces_value'],
            'previous_quantity' => $previousStock,
            'new_quantity' => $product->quantity,
            'note' => "Credit sale to {$data['customer_name']} of {$data['quantity']} {$data['unit']}(s) ({$data['total_pieces_value']} pieces)",
        ]);

        // Calculate expected total (amount paid + balance owed)
        $expectedTotal = $data['amount_sold'] + $data['balanceleft'];

        // Create credit sale record
        $creditSale = CreditSale::create([
            'customer_name' => $data['customer_name'],
            'product_id' => $product->id,
            'unit' => $data['unit'],
            'quantity' => $data['quantity'],
            'total_pieces' => $data['total_pieces_value'],
            'price' => $data['price_value'],
            'expected_total' => $expectedTotal,
            'amount_paid' => $data['amount_sold'],
            'balance_left' => $data['balanceleft'],
            'discount' => $data['discount'], // stored as received from UI
            'sale_date' => now()->toDateString(),
            'user_id' => $user->id,
            'status' => $data['balanceleft'] > 0 ? 'pending' : 'paid',
        ]);

        // Accounting entries setup
        $accountCodes = [
            'Cash' => '1000',
            'Accounts Receivable' => '1100', // Make sure you have this account added in your system
            'Inventory' => '1200',
            'Sales Revenue' => '4000',
            'COGS' => '5000',
        ];

        $accountIds = [];
        foreach ($accountCodes as $name => $code) {
            $accountId = Account::where('code', $code)->where('admin_id', $adminId)->value('id');
            if (!$accountId) {
                throw new \Exception("Account $name with code $code not found for admin $adminId");
            }
            $accountIds[$name] = $accountId;
        }

        // Purchase price & COGS calculation
        $purchasePrice = $product->purchase_price ?? 0;
        $cogsAmount = $purchasePrice * $data['total_pieces_value'];

        // Create journal entry
        $journalEntry = JournalEntry::create([
            'reference' => 'Credit Sale #' . $creditSale->id,
            'description' => "Credit sale of {$product->name} to {$data['customer_name']}",
            'entry_date' => now()->toDateString(),
            'admin_id' => $adminId,
        ]);

        // Debit Cash for amount paid (if > 0)
        if ($data['amount_sold'] > 0) {
            JournalLine::create([
                'journal_entry_id' => $journalEntry->id,
                'account_id' => $accountIds['Cash'],
                'debit' => $data['amount_sold'],
                'credit' => 0,
            ]);
        }

        // Debit Accounts Receivable for balance left (if > 0)
        if ($data['balanceleft'] > 0) {
            JournalLine::create([
                'journal_entry_id' => $journalEntry->id,
                'account_id' => $accountIds['Accounts Receivable'],
                'debit' => $data['balanceleft'],
                'credit' => 0,
            ]);
        }

        // Credit Sales Revenue for total sale amount
        JournalLine::create([
            'journal_entry_id' => $journalEntry->id,
            'account_id' => $accountIds['Sales Revenue'],
            'debit' => 0,
            'credit' => $expectedTotal,
        ]);

        // Debit COGS
        JournalLine::create([
            'journal_entry_id' => $journalEntry->id,
            'account_id' => $accountIds['COGS'],
            'debit' => $cogsAmount,
            'credit' => 0,
        ]);

        // Credit Inventory
        JournalLine::create([
            'journal_entry_id' => $journalEntry->id,
            'account_id' => $accountIds['Inventory'],
            'debit' => 0,
            'credit' => $cogsAmount,
        ]);

        DB::commit();

        return redirect()->back()->with('success', 'Credit sale recorded successfully.');

    } catch (\Exception $e) {
        DB::rollBack();
        \Log::error('Credit sale failed: ' . $e->getMessage());
        return back()->withInput()->with('error', 'Failed to record credit sale.');
    }
}


public function index()
{
    $user = auth()->user();

    if ($user->role === 'admin') {
        // Admin sees only their own products
        $products = Inventory::where('quantity', '>', 0)
            ->where('admin_id', $user->id)
            ->orderBy('name')
            ->get();

        return view('admin.credit', compact('products'));
    }

    // For employees — show their admin's products
    $products = Inventory::where('quantity', '>', 0)
        ->where('admin_id', $user->admin_id)
        ->orderBy('name')
        ->get();

    return view('admin.credit', compact('products'));
}

public function markAsPaid($id)
{
    $sale = CreditSale::findOrFail($id);
   $sale->update([
    'status' => 'paid',
    'amount_paid' => $sale->expected_total,
    'balance_left' => 0,
]);


    return back()->with('success', 'Sale marked as fully paid.');
}

public function markAsReturned($id)
{
    $sale = CreditSale::findOrFail($id);
    $product = Inventory::findOrFail($sale->product_id);

    // Restore stock
    $previous = $product->quantity;
    $product->increment('quantity', $sale->quantity);

    InventoryHistory::create([
        'product_id' => $product->id,
        'user_id' => auth()->id(),
        'type' => 'increase',
        'quantity' => $sale->quantity,
        'previous_quantity' => $previous,
        'new_quantity' => $product->quantity,
        'note' => 'Returned by ' . $sale->customer_name,
    ]);

    // Update sale status
    $sale->update([
        'status' => 'returned',
        'amount_paid' => 0,
        'balance_left' => 0,
    ]);

    // Create journal reversal (optional but ideal)
    JournalEntry::create([
        'reference' => 'Return #' . $sale->id,
        'description' => 'Sale return from ' . $sale->customer_name,
        'entry_date' => now(),
        'entries' => [
            [
                'account' => 'Sales Revenue',
                'debit' => $sale->price,
                'credit' => 0,
            ],
            [
                'account' => 'Accounts Receivable',
                'debit' => 0,
                'credit' => $sale->price,
            ],
            [
                'account' => 'Inventory',
                'debit' => $sale->purchase_price ?? 1000,
                'credit' => 0,
            ],
            [
                'account' => 'COGS',
                'debit' => 0,
                'credit' => $sale->cost_price ?? 1000,
            ],
        ]
    ]);

    return back()->with('success', 'Sale marked as returned, stock restored, and journal updated.');
}

//show all credit sale
public function credit()
{
    $user = auth()->user();

    // Show only sales for current admin
    $creditSales = CreditSale::with('product')
        ->where('user_id', $user->isAdmin() ? $user->id : $user->admin_id)
        ->latest()
        ->get();

    return view('credit', compact('creditSales'));
}

public function salesReports(Request $request)
{
    $user = Auth::user();

    // Restrict to admin users only
    abort_unless($user->isAdmin(), 403, 'Unauthorized access');

    // Validate optional date filter
    $request->validate([
        'date' => 'nullable|date',
    ]);

    $date = $request->input('date');

    // Query: sales made by admin personally (no employee involved)
    $query = Sale::where('admin_id', $user->id)
                 ->whereNull('employee_id');

    // Optional date filter
    if ($date) {
        $query->whereDate('created_at', $date);
    }

    // Get sales for display
    $sales = $query->with(['product', 'user'])
                   ->orderBy('created_at', 'desc')
                   ->paginate(15);

    // Totals
    $totalAmount = (clone $query)->sum('total_amount');
    $totalQuantity = (clone $query)->sum('quantity');

    // Daily and Monthly summaries
    $today = now()->startOfDay();
    $startOfMonth = now()->startOfMonth();

    $adminSalesToday = Sale::where('admin_id', $user->id)
                           ->whereNull('employee_id')
                           ->where('created_at', '>=', $today)
                           ->sum('total_amount');

    $adminMonthlySales = Sale::where('admin_id', $user->id)
                              ->whereNull('employee_id')
                              ->where('created_at', '>=', $startOfMonth)
                              ->sum('total_amount');

    // Filters for UI (to retain date in input)
    $filters = ['date' => $date];

    return view('adminR', compact(
        'sales',
        'totalAmount',
        'totalQuantity',
        'filters',
        'adminSalesToday',
        'adminMonthlySales'
    ));
}
// public function storesales(Request $request)
// {
// // dd($request->all());
//     // 1. Validation
//     try {
//     $data = $request->validate([
//         'product_id' => 'required|exists:inventories,id',
//         'quantity'            => 'required|integer|min:1',
//         'unit'                => 'required|in:piece,dozen,carton',
//         'amount_sold'         => 'required|numeric|min:0',
//         'discount'            => 'nullable|numeric|min:0|max:100',
//         'total_pieces_value'  => 'required|integer|min:1',
//         'price_value'         => 'required|numeric|min:0',
//         'amount_display'      => 'nullable|string',
//     ]);
// } catch (\Illuminate\Validation\ValidationException $e) {
//     Log::error('Validation failed', $e->errors());
//     return back()->withErrors($e->errors())->withInput();
// }


//     // 2. Type casting
//     $data['product_id']         = (int) $data['product_id'];
//     $data['quantity']           = (int) $data['quantity'];
//     $data['total_pieces_value'] = (int) $data['total_pieces_value'];
//     $data['amount_sold']        = (float) $data['amount_sold'];
//     $data['price_value']        = (float) $data['price_value'];
//     $data['discount']           = isset($data['discount']) ? (float) $data['discount'] : 0.0;
//     Log::info('After casting', $data);

//     // 3. Sanitize display amount
//     $amountDisplay = $request->input('amount_display');
//     $amountDisplay = $amountDisplay ? (float) str_replace(',', '', $amountDisplay) : 0.0;
//     Log::info('Parsed amount display', ['amount_display_raw' => $request->input('amount_display'), 'amountDisplay' => $amountDisplay]);

//     // 4. Compare display vs actual
//     if (abs($data['amount_sold'] - $amountDisplay) > 0.01) {
//         Log::warning('Amount mismatch', [
//             'amount_sold' => $data['amount_sold'],
//             'amountDisplay' => $amountDisplay,
//         ]);
//         return back()->withInput()->with('error', 'Displayed amount does not match actual sold amount.');
//     }
//     Log::info('Amount display matches');

//     DB::beginTransaction();

//     try {
//         // 5. Fetch product
//         Log::info('Fetching Inventory', ['product_id' => $data['product_id']]);
//         $product = Inventory::findOrFail($data['product_id']);
//         Log::info('Found inventory', ['quantity' => $product->quantity, 'product' => $product->toArray()]);

//         // 6. Check stock
//         if ($data['total_pieces_value'] > $product->quantity) {
//             Log::warning('Not enough stock', [
//                 'requested' => $data['total_pieces_value'],
//                 'available' => $product->quantity,
//             ]);
//             return back()->withInput()->with('error', 'Not enough stock. Only ' . $product->quantity . ' pieces available.');
//         }
//         Log::info('Stock sufficient');

//         // 7. Prepare user/admin
//         $user = auth()->user();
//         Log::info('Auth user', ['user_id' => $user?->id, 'user' => $user?->toArray()]);
//         $adminId = $user->isAdmin() ? $user->id : $user->admin_id;
//         $previousStock = $product->quantity;

//         // 8. Update inventory
//         $product->quantity -= $data['total_pieces_value'];
//         $product->save();
//         Log::info('Inventory updated', ['new_quantity' => $product->quantity]);

//         // 9. Create sale
//         $sale = Sale::create([
//             'employee_id'      => $user->isAdmin() ? null : $user->id,
//             'user_id'          => $user->id,
//             'admin_id'         => $adminId,
//             'product_id'       => $product->id,
//             'quantity'         => $data['quantity'],
//             'unit'             => $data['unit'],
//             'pieces_sold'      => $data['total_pieces_value'],
//             'price_per_piece'  => $data['price_value'],
//             'discount'         => $data['discount'],
//             'total_amount'     => $data['amount_sold'],
//         ]);
//         Log::info('Sale record created', $sale->toArray());

//         // 10. Create inventory history
//         $history = InventoryHistory::create([
//             'product_id'        => $product->id,
//             'user_id'           => $user->id,
//             'type'              => 'decrease',
//             'quantity'          => $data['total_pieces_value'],
//             'previous_quantity' => $previousStock,
//             'new_quantity'      => $product->quantity,
//            'note' => "Sold {$data['quantity']} {$data['unit']}(s) by {$user->name} ({$data['total_pieces_value']} pieces)",
//         ]);
//         Log::info('InventoryHistory record created', $history->toArray());

//         DB::commit();
//         Log::info('Transaction committed successfully');

//         return redirect()->back()->with('success', 'Sale completed successfully!');
//     } catch (\Exception $e) {
//         DB::rollBack();
//         Log::error('Sale transaction failed', [
//             'error'    => $e->getMessage(),
//             'data'     => $data,
//             'user_id'  => auth()->id(),
//         ]);
//         return back()->with('error', 'Failed to complete sale. Please try again.');
//     }
// }
public function storesales(Request $request)
{
    // 1. Validation
    try {
        $data = $request->validate([
            'product_id' => 'required|exists:inventories,id',
            'quantity' => 'required|integer|min:1',
            'unit' => 'required|in:piece,dozen,carton',
            'amount_sold' => 'required|numeric|min:0',
            'discount' => 'nullable|numeric|min:0|max:100',
            'total_pieces_value' => 'required|integer|min:1',
            'price_value' => 'required|numeric|min:0',
            'amount_display' => 'nullable|string',
        ]);
    } catch (\Illuminate\Validation\ValidationException $e) {
        Log::error('Validation failed', $e->errors());
        return back()->withErrors($e->errors())->withInput();
    }

    // 2. Type casting
    $data['product_id'] = (int) $data['product_id'];
    $data['quantity'] = (int) $data['quantity'];
    $data['total_pieces_value'] = (int) $data['total_pieces_value'];
    $data['amount_sold'] = (float) $data['amount_sold'];
    $data['price_value'] = (float) $data['price_value'];
    $data['discount'] = isset($data['discount']) ? (float) $data['discount'] : 0.0;

    Log::info('After casting', $data);

    // 3. Sanitize display amount
    $amountDisplay = $request->input('amount_display');
    $amountDisplay = $amountDisplay ? (float) str_replace(',', '', $amountDisplay) : 0.0;

    Log::info('Parsed amount display', [
        'amount_display_raw' => $request->input('amount_display'),
        'amountDisplay' => $amountDisplay
    ]);

    // 4. Compare display vs actual
    if (abs($data['amount_sold'] - $amountDisplay) > 0.01) {
        Log::warning('Amount mismatch', [
            'amount_sold' => $data['amount_sold'],
            'amountDisplay' => $amountDisplay,
        ]);
        return back()->withInput()->with('error', 'Displayed amount does not match actual sold amount.');
    }
    Log::info('Amount display matches');

    DB::beginTransaction();

    try {
        // 5. Fetch product inventory
        Log::info('Fetching Inventory', ['product_id' => $data['product_id']]);
        $product = Inventory::findOrFail($data['product_id']);
        Log::info('Found inventory', ['quantity' => $product->quantity, 'product' => $product->toArray()]);

        // 6. Check stock availability
        if ($data['total_pieces_value'] > $product->quantity) {
            Log::warning('Not enough stock', [
                'requested' => $data['total_pieces_value'],
                'available' => $product->quantity,
            ]);
            return back()->withInput()->with('error', 'Not enough stock. Only ' . $product->quantity . ' pieces available.');
        }
        Log::info('Stock sufficient');

        // 7. Get user/admin info
        $user = auth()->user();
        Log::info('Auth user', ['user_id' => $user?->id, 'user' => $user?->toArray()]);
        $adminId = $user->isAdmin() ? $user->id : $user->admin_id;
        $previousStock = $product->quantity;

        // 8. Update inventory
        $product->quantity -= $data['total_pieces_value'];
        $product->save();
        Log::info('Inventory updated', ['new_quantity' => $product->quantity]);

        // 9. Create sale record
        $sale = Sale::create([
            'employee_id' => $user->isAdmin() ? null : $user->id,
            'user_id' => $user->id,
            'admin_id' => $adminId,
            'product_id' => $product->id,
            'quantity' => $data['quantity'],
            'unit' => $data['unit'],
            'pieces_sold' => $data['total_pieces_value'],
            'price_per_piece' => $data['price_value'],
            'discount' => $data['discount'],
            'total_amount' => $data['amount_sold'],
        ]);
        Log::info('Sale record created', $sale->toArray());

        // 10. Create inventory history log
        $history = InventoryHistory::create([
            'product_id' => $product->id,
            'user_id' => $user->id,
            'type' => 'decrease',
            'quantity' => $data['total_pieces_value'],
            'previous_quantity' => $previousStock,
            'new_quantity' => $product->quantity,
            'note' => "Sold {$data['quantity']} {$data['unit']}(s) by {$user->name} ({$data['total_pieces_value']} pieces)",
        ]);
        Log::info('InventoryHistory record created', $history->toArray());

        // ----------- ACCOUNTING ENTRIES ------------

        $salesAmount = $sale->total_amount;
$purchasePrice = $product->purchase_price ?? 0;
$cogsAmount = $purchasePrice * $data['total_pieces_value'];
// dd($cogsAmount);
        $accountCodes = [
            'Cash' => '1000',
            'Inventory' => '1200',
            'Sales Revenue' => '4000',
            'COGS' => '5000',
        ];

        $accountIds = [];
        foreach ($accountCodes as $name => $code) {
            $accountId = Account::where('code', $code)->where('admin_id', $adminId)->value('id');
            if (!$accountId) {
                throw new \Exception("Account $name with code $code not found for admin $adminId");
            }
            $accountIds[$name] = $accountId;
        }

        $journalEntry = JournalEntry::create([
            'reference' => 'Sale #' . $sale->id,
            'description' => "Sale of {$product->name} (ID: {$product->id})",
            'entry_date' => now()->toDateString(),
            'admin_id' => $adminId,
        ]);

        // Debit Cash
        JournalLine::create([
            'journal_entry_id' => $journalEntry->id,
            'account_id' => $accountIds['Cash'],
            'debit' => $salesAmount,
            'credit' => 0,
        ]);

        // Credit Sales Revenue
        JournalLine::create([
            'journal_entry_id' => $journalEntry->id,
            'account_id' => $accountIds['Sales Revenue'],
            'debit' => 0,
            'credit' => $salesAmount,
        ]);

        // Debit COGS
        JournalLine::create([
            'journal_entry_id' => $journalEntry->id,
            'account_id' => $accountIds['COGS'],
            'debit' => $cogsAmount,
            'credit' => 0,
        ]);

        // Credit Inventory
        JournalLine::create([
            'journal_entry_id' => $journalEntry->id,
            'account_id' => $accountIds['Inventory'],
            'debit' => 0,
            'credit' => $cogsAmount,
        ]);

        DB::commit();

        return redirect()->back()->with('success', 'Sale recorded successfully.');

    } catch (\Exception $e) {
        DB::rollBack();
        Log::error('Sale transaction failed', ['error' => $e->getMessage()]);
        return back()->withInput()->with('error', 'An error occurred while processing the sale.');
    }
}

}




