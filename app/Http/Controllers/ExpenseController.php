<?php

namespace App\Http\Controllers;
use App\Models\Expense;
use App\Models\Sale;
use App\Models\JournalEntry;
use App\Models\JournalLine;
use App\Models\Account;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class ExpenseController extends Controller
{
     use AuthorizesRequests;
    /**
     * Show the form for recording a new expense.
     */
    public function create()
    {
        return view('employee.expense');
    }

    /**
     * Store the submitted expense.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'amount' => 'required|numeric|min:0',
            'category' => 'required|string|max:100',
            'date' => 'required|date',
            'description' => 'nullable|string|max:1000',
        ]);

        Expense::create([
            ...$validated,
            'employee_id' => auth()->id(),
        ]);

        return redirect()->
            back()->with('success', '✅ Expense recorded successfully.');
    }
    public function index()
{
    $expenses = Expense::where('employee_id', auth()->id())
                        ->latest()
                        ->paginate(10);

    return view('expenses.index', compact('expenses'));
}

    public function destroy(Expense $expense)
{
    // Make sure only owner can delete
    if ($expense->employee_id !== auth()->id()) {
        abort(403, 'Unauthorized action.');
    }

    $expense->delete();

    return redirect()->route('employee.expenses.index')
                     ->with('success', '✅ Expense deleted successfully.');
}
public function edit(Expense $expense)
{
    return view('expenses.edit', compact('expense'));
}

public function update(Request $request, Expense $expense)
{
    $validated = $request->validate([
        'title' => 'required|string|max:255',
        'amount' => 'required|numeric|min:0',
        'category' => 'required|string|max:100',
        'date' => 'required|date',
        'description' => 'nullable|string|max:1000',
    ]);

    $expense->update($validated);

    return redirect()
        ->route('employee.expenses.index')
        ->with('success', '✅ Expense updated successfully.');
}
public function adminSalesWithExpenses()
{
    $admin = auth()->user();

    $sales = Sale::where(function($q) use ($admin) {
            $q->where('admin_id', $admin->id)
              ->orWhereHas('user', function ($q) use ($admin) {
                  $q->where('admin_id', $admin->id);
              });
        })
        ->with('product')
        ->latest()
        ->get();

    // Load expenses separately
    $expenses = Expense::where('admin_id', $admin->id)
        ->where('category', 'Sale Related')
        ->get()
        ->groupBy(function ($e) {
            // extract sale_id from description: "Expense related to sale ID: 12"
            preg_match('/sale ID: (\d+)/', $e->description, $matches);
            return $matches[1] ?? null;
        });

    return view('admin.expense', compact('sales', 'expenses'));
}
//operational cost
public function returnOperationalcost(){
    return view('journal_entries.admincost');
}
public function storeoperationalcost(Request $request)
{
    $request->validate([
        'description' => 'required|string|max:255',
        'entry_date' => 'required|date',
        'amount' => 'required|numeric|min:0.01',
    ]);

    $adminId = auth()->id();

    $reference = 'EXP-' . now()->format('YmdHis');

    $journalEntry = JournalEntry::create([
        'reference'   => $reference,
        'description' => $request->description,
        'entry_date'  => $request->entry_date, 
        'admin_id'    => $adminId,
    ]);

    $expenseAccount = Account::where('code', '6000')->where('admin_id', $adminId)->firstOrFail();
    $cashAccount    = Account::where('code', '1000')->where('admin_id', $adminId)->firstOrFail();

    JournalLine::create([
        'journal_entry_id' => $journalEntry->id,
        'account_id'       => $expenseAccount->id,
        'debit'            => $request->amount,
        'credit'           => 0,
        'created_at'       => now(),
        'updated_at'       => now(),
    ]);

    JournalLine::create([
        'journal_entry_id' => $journalEntry->id,
        'account_id'       => $cashAccount->id,
        'debit'            => 0,
        'credit'           => $request->amount,
        'created_at'       => now(),
        'updated_at'       => now(),
    ]);

    return redirect()->back()->with('success', 'Operational expense recorded successfully.');
}


}
