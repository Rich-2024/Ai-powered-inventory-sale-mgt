<?php

namespace App\Http\Controllers;

use App\Models\Inventory;
use App\Models\Product;
use App\Models\Sale;
use App\Models\User;
use Carbon\Carbon;
use App\Models\Purchase;
use Illuminate\Support\Facades\Auth;

use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function tot()
    {
        return view('chat.tot');
    }
    // public function dashboard()
    // {

    //     $totalSalesToday = Sale::whereDate('created_at', today())->sum('total_amount');
    //     $totalSalesByEmployee = Sale::where('user_id', auth()->id())->sum('total_amount');
    //     $lowStockProducts = Product::where('quantity', '<', 5)->get(); // Low stock products

    //     return view('admin.Dashboard', compact('totalSalesToday', 'totalSalesByEmployee', 'lowStockProducts'));
    // }
   public function dashboard()
{
    $user = auth()->user();

    // Sales Today (by employees only)
    $totalSalesToday = Sale::join('users', 'sales.employee_id', '=', 'users.id')
        ->where('users.role', 'employee')
        ->whereDate('sales.created_at', today())
        ->sum('sales.total_amount');

    // Monthly Sales (by employees only)
    $totalMonthlySales = Sale::join('users', 'sales.employee_id', '=', 'users.id')
        ->where('users.role', 'employee')
        ->whereYear('sales.created_at', now()->year)
        ->whereMonth('sales.created_at', now()->month)
        ->sum('sales.total_amount');

    // Initialize variables
    $totalSalesByEmployee = 0;
    $totalEmployees = 0;

    if ($user->isAdmin()) {
        // Count employees under this admin
        $totalEmployees = $user->employees()->count();
    } else {
        // Total sales by this employee
        $totalSalesByEmployee = $user->sales()->sum('total_amount');
    }

    // Low stock products (for both admin and employee views)
    $lowStockProducts = Inventory::where('quantity', '<', 5)->get();

    return view('admin.Dashboard', compact(
        'totalSalesToday',
        'totalMonthlySales',
        'totalSalesByEmployee',
        'totalEmployees',
        'lowStockProducts'
    ));
}



    // View and manage products
    public function products()
    {
        $products = Inventory::all(); // Retrieve all products
        return view('admin.products.index', compact('products'));
    }

    // Show the form to add/edit a product
    public function showProductForm($id = null)
    {
        $product = $id ? Inventory::find($id) : null;
        return view('admin.products.form', compact('product'));
    }

    // Store a new or update an existing product
    public function storeProduct(Request $request, $id = null)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'quantity' => 'required|integer|min:0',
            'image' => 'nullable|image|max:1024',
        ]);

        $product = $id ? Inventory::find($id) : new Product();
        $product->name = $request->input('name');
        $product->price = $request->input('price');
        $product->quantity = $request->input('quantity');

        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('product_images', 'public');
            $product->image_path = $imagePath;
        }

        $product->save();

        return redirect()->route('admin.products.index')->with('success', 'Product saved successfully');
    }

    // Delete a product
    public function deleteProduct($id)
    {
        $product = Inventory::findOrFail($id);
        $product->delete();
        return redirect()->route('admin.products.index')->with('success', 'Product deleted successfully');
    }

    // View sales reports
    public function salesReport()
    {
        $sales = Sale::with('user')->latest()->get()->auth(); // Get all sales, with the employee who made them
        return view('Admin.admin.sales.report', compact('sales'));
    }

    // Manage employees
    public function employees()
    {
        $employees = User::where('role', 'employee')->get();
        return view('admin.employees.index', compact('employees'));
    }

    // Toggle employee status (active/inactive)
    public function toggleStatus($id)
    {
        $user = User::findOrFail($id);
        $user->status = ($user->status == 'active') ? 'inactive' : 'active';
        $user->save();

        return redirect()->route('admin.employees')->with('success', 'Employee status updated');
    }

    // Dismiss an employee
    public function dismissEmployee($id)
    {
        $user = User::findOrFail($id);
        $user->status = 'inactive';
        $user->save();

        return redirect()->route('admin.employees')->with('success', 'Employee dismissed');
    }

    // Reinstate an employee
    public function reinstateEmployee($id)
    {
        $user = User::findOrFail($id);
        $user->status = 'active';
        $user->save();

        return redirect()->route('admin.employees')->with('success', 'Employee reinstated');
    }

    // Show the form to create a new employee
    public function showEmployeeForm($id = null)
    {
        $employee = $id ? User::find($id) : null;
        return view('admin.employees.form', compact('employee'));
    }

    // Store or update an employee's details
    public function storeEmployee(Request $request, $id = null)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'username' => 'required|string|max:255|unique:users,username,' . ($id ? $id : ''),
            'email' => 'nullable|email',
            'password' => 'nullable|string|min:6',
            'role' => 'required|in:admin,employee',
        ]);

        $employee = $id ? User::find($id) : new User();
        $employee->name = $request->input('name');
        $employee->username = $request->input('username');
        $employee->email = $request->input('email');
        $employee->role = 'employee';

        if ($request->filled('password')) {
            $employee->password = bcrypt($request->input('password'));
        }

        $employee->save();

        return redirect()->route('admin.employees')->with('success', 'Employee saved successfully');
    }
     public function create()
    {
        return view('admin.employees');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users',
            'password' => 'required|string|min:6|confirmed',
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'employee',
            'status' => true,
        ]);

        return redirect()->route('admin.employees.index')->with('success', 'Employee added successfully.');
    }

    public function edit($id)
    {
        $employee = User::where('role', 'employee')->findOrFail($id);
        return view('admin.employees.edit', compact('employee'));
    }

    public function update(Request $request, $id)
    {
        $employee = User::where('role', 'employee')->findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,'.$employee->id,
        ]);

        $employee->update([
            'name' => $request->name,
            'email' => $request->email,
        ]);

        return redirect()->route('admin.employees.index')->with('success', 'Employee updated successfully.');
    }

    public function destroy($id)
    {
        $employee = User::where('role', 'employee')->findOrFail($id);
        $employee->delete();

        return redirect()->route('admin.employees.index')->with('success', 'Employee deleted.');
    }

    public function toggleStatu($id)
    {
        $employee = User::where('role', 'employee')->findOrFail($id);
        $employee->status = !$employee->status;
        $employee->save();

        return redirect()->route('admin.employees.index')->with('success', 'Employee status updated.');
    }
public function showPurchaseForm()
{
    return view('admin.stocks.purchase');
}

public function storePurchase(Request $request)
{
    $request->validate([
        'product_name.*' => 'required|string|max:255',
        'quantity.*' => 'required|integer|min:1',
        'price_per_unit.*' => 'required|numeric|min:0',
        'purchase_date.*' => 'required|date',
        'notes' => 'nullable|string',
    ]);

    foreach ($request->product_name as $index => $name) {
        Purchase::create([
            'user_id' => auth()->id(),
            'product_name' => $name,
            'quantity' => $request->quantity[$index],
            'price_per_unit' => $request->price_per_unit[$index],
            'purchase_date' => $request->purchase_date[$index],
            'notes' => $request->notes,
        ]);
    }

    return redirect()->back()->with('success', 'Stock purchases recorded successfully.');
}

public function myPurchases()
{
    $user = auth()->user();

    $rawPurchases = Purchase::where('user_id', $user->id)
        ->orderByDesc('purchase_date')
        ->get();

    $grouped = $rawPurchases->groupBy(function ($p) {
        // ✅ FIX: Convert string to Carbon before formatting
        return Carbon::parse($p->purchase_date)->format('Y-m-d');
    })->map(function ($group) {
        return $group->map(function ($p) {
            return [
                'product_name' => $p->product_name,
                'quantity' => (int) $p->quantity,
                'price_per_unit' => (float) $p->price_per_unit,
                'notes' => $p->notes,
                'purchase_date' => $p->purchase_date, // leave as string or format if needed
            ];
        });
    });

    $overallTotal = $grouped->flatten(1)->sum(function ($p) {
        return $p['quantity'] * $p['price_per_unit'];
    });

    return response()->json([
        'purchases' => $grouped,
        'overallTotal' => number_format($overallTotal, 2),
    ]);
}

public function index()
{
    $userId = Auth::id();

    $purchases = \App\Models\Purchase::where('user_id', $userId)
        ->orderBy('purchase_date', 'desc')
        ->get();

    // Group by formatted date
    $groupedPurchases = $purchases->groupBy(function ($item) {
        return \Carbon\Carbon::parse($item->purchase_date)->format('F j, Y');
    });

    $overallTotal = $purchases->sum(function ($p) {
        return $p->quantity * $p->price_per_unit;
    });

    return view('Admin.stocks.index', compact('purchases', 'groupedPurchases', 'overallTotal'));
}



}
