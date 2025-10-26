<?php


namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\JournalEntry;
use App\Models\JournalLine;
use Carbon\Carbon;
use App\Models\Account;

use Illuminate\Support\Facades\DB;
class JournalEntryController extends Controller
{

public function index()
{
    $adminId = auth()->id();

    // Fetch and group journal entries by entry_date (most recent first)
    $journalEntries = JournalEntry::with(['journalLines.account'])
        ->where('admin_id', $adminId)
        ->whereNotNull('entry_date') // ✅ Prevent grouping issues
        ->orderByDesc('entry_date')  // ✅ Show most recent entries first
        ->get()
        ->groupBy('entry_date');

    // Compute account balances
    $revenue = JournalLine::whereHas('account', function ($q) use ($adminId) {
        $q->where('code', '4000')->where('admin_id', $adminId);
    })->sum('credit');

    $cogs = JournalLine::whereHas('account', function ($q) use ($adminId) {
        $q->where('code', '5000')->where('admin_id', $adminId);
    })->sum('debit');

    $cash = JournalLine::whereHas('account', function ($q) use ($adminId) {
        $q->where('code', '1000')->where('admin_id', $adminId);
    })->sum(DB::raw('debit - credit'));

    $inventory = JournalLine::whereHas('account', function ($q) use ($adminId) {
        $q->where('code', '1200')->where('admin_id', $adminId);
    })->sum(DB::raw('debit - credit'));

    return view('journal_entries.index', compact('journalEntries', 'revenue', 'cogs', 'cash', 'inventory'));
}

public function profitAndLoss(Request $request)
{
    $adminId = auth()->id();

    // Filter by date range (optional)
    $startDate = $request->input('start_date', now()->startOfMonth()->toDateString());
    $endDate = $request->input('end_date', now()->endOfMonth()->toDateString());

    // Sum Revenue (Credit)
    $revenue = JournalLine::whereHas('account', function ($q) use ($adminId) {
        $q->where('code', '4000')->where('admin_id', $adminId);
    })->whereBetween('created_at', [$startDate, $endDate])->sum('credit');

    // Sum COGS (Debit)
    $cogs = JournalLine::whereHas('account', function ($q) use ($adminId) {
        $q->where('code', '5000')->where('admin_id', $adminId);
    })->whereBetween('created_at', [$startDate, $endDate])->sum('debit');

    // Sum Expenses (example code 6000)
    $expenses = JournalLine::whereHas('account', function ($q) use ($adminId) {
        $q->where('code', '>=', '6000')->where('code', '<', '7000')->where('admin_id', $adminId);
    })->whereBetween('created_at', [$startDate, $endDate])->sum(DB::raw('debit - credit'));

    // Calculate Net Profit
    $netProfit = $revenue - $cogs - $expenses;

    return view('journal_entries.profit_loss', compact('revenue', 'cogs', 'expenses', 'netProfit', 'startDate', 'endDate'));
}


public function balanceSheet(Request $request)
{
    $adminId = auth()->id();
    $date = $request->input('date', now()->toDateString());
    $endOfDay = Carbon::parse($date)->endOfDay();

    // Helper function to calculate balance for account codes in range and account type
    $getBalance = function($codeStart, $codeEnd, $type) use ($adminId, $endOfDay) {
        $query = JournalLine::whereHas('account', function ($q) use ($adminId, $codeStart, $codeEnd) {
            $q->where('code', '>=', $codeStart)
              ->where('code', '<', $codeEnd)
              ->where('admin_id', $adminId);
        })
        ->where('created_at', '<=', $endOfDay);

        if (in_array($type, ['asset', 'expense'])) {
            return $query->sum(DB::raw('debit - credit'));
        } else {
            return $query->sum(DB::raw('credit - debit'));
        }
    };

    // Calculate totals by code ranges and types
    $assetsTotal = $getBalance('1000', '2000', 'asset');
    $liabilitiesTotal = $getBalance('2000', '3000', 'liability');
    $equityTotal = $getBalance('3000', '4000', 'equity');

    // Calculate Sales Revenue and COGS separately
    $salesRevenue = JournalLine::whereHas('account', function($q) use ($adminId) {
        $q->where('code', '>=', '4000')->where('code', '<', '5000')->where('admin_id', $adminId);
    })->where('created_at', '<=', $endOfDay)
    ->sum(DB::raw('credit - debit'));

    $cogs = JournalLine::whereHas('account', function($q) use ($adminId) {
        $q->where('code', '>=', '5000')->where('code', '<', '6000')->where('admin_id', $adminId);
    })->where('created_at', '<=', $endOfDay)
    ->sum(DB::raw('debit - credit'));

    // Calculate operational expenses
    $operationalExpenses = JournalLine::whereHas('account', function($q) use ($adminId) {
        $q->where('code', '>=', '6000')->where('code', '<', '7000')->where('admin_id', $adminId);
    })->where('created_at', '<=', $endOfDay)
    ->sum(DB::raw('debit - credit'));

    // Calculate net profit considering operational expenses
    $netProfit = $salesRevenue - $cogs - $operationalExpenses;

    // Add net profit to equity total to balance the sheet
    $equityTotal += $netProfit;

    $isBalanced = abs($assetsTotal - ($liabilitiesTotal + $equityTotal)) < 0.01;

    // Get all accounts for admin
    $accounts = Account::where('admin_id', $adminId)->get();

    // Preload journal lines for all accounts before looping (improves performance)
    $journalLines = JournalLine::whereIn('account_id', $accounts->pluck('id'))
        ->where('created_at', '<=', $endOfDay)
        ->get()
        ->groupBy('account_id');

    $balances = [];

    foreach ($accounts as $account) {
        $lines = $journalLines->get($account->id, collect());

        $totalDebit = $lines->sum('debit');
        $totalCredit = $lines->sum('credit');

        // Asset & Expense accounts: balance = debit - credit; others: credit - debit
        $balance = in_array($account->type, ['asset', 'expense'])
            ? $totalDebit - $totalCredit
            : $totalCredit - $totalDebit;

        $balances[$account->type][] = [
            'name' => $account->name,
            'code' => $account->code,
            'balance' => number_format($balance, 2),
        ];
    }

    return view('inventory.balance_sheet', [
        'assets' => $assetsTotal,
        'liabilities' => $liabilitiesTotal,
        'equity' => $equityTotal,
        'netProfit' => $netProfit,
        'salesRevenue' => $salesRevenue,
        'cogs' => $cogs,
        'operationalExpenses' => $operationalExpenses,
        'balances' => $balances,
        'date' => $date,
        'isBalanced' => $isBalanced,
    ]);
}

 public function createCapitalLoan()
{
    $adminId = auth()->id();

    $equityAccount = Account::where('admin_id', $adminId)->where('code', '3000')->first();
    $liabilityAccount = Account::where('admin_id', $adminId)->where('code', '2000')->first();

    return view('journal_entries.summary', [
        'equityAccountId' => $equityAccount?->id,
        'liabilityAccountId' => $liabilityAccount?->id,
    ]);
}


   public function storeCapitalLoan(Request $request)
{
    $request->merge([
        'amount' => str_replace(',', '', $request->amount),
    ]);

    // dd($request->all());
    $request->validate([
        'amount' => 'required|numeric|min:0',
        'type' => 'required|in:equity,liability',
        'entry_date' => 'required|date',
        'description' => 'nullable|string',
    ]);

    $adminId = auth()->id();

    // Determine the credit account code based on type
    $creditAccountCode = $request->type === 'equity' ? '3000' : '2000';

    // Find the system account for the credit side
    $creditAccount = Account::where('admin_id', $adminId)
        ->where('code', $creditAccountCode)
        ->first();

    if (!$creditAccount) {
        return back()->withErrors(['type' => 'System account not found for this entry type (equity/liability).']);
    }

    // Find the default cash account for the admin
    $cashAccount = Account::where('admin_id', $adminId)
        ->where('code', '1000')
        ->first();

    if (!$cashAccount) {
        return back()->withErrors(['cash' => 'Cash account not found. Please set one up.']);
    }

    // Create journal entry and lines
    DB::transaction(function () use ($request, $adminId, $creditAccount, $cashAccount) {
        $journalEntry = JournalEntry::create([
            'reference'   => ucfirst($request->type) . ' Entry',
            'description' => $request->description ?? ucfirst($request->type) . ' added',
            'entry_date'  => $request->entry_date ?? now()->toDateString(),
            'admin_id'    => $adminId,
        ]);

        // Debit Cash
        JournalLine::create([
            'journal_entry_id' => $journalEntry->id,
            'account_id'       => $cashAccount->id,
            'debit'            => $request->amount,
            'credit'           => 0,
        ]);

        // Credit Equity or Liability
        JournalLine::create([
            'journal_entry_id' => $journalEntry->id,
            'account_id'       => $creditAccount->id,
            'debit'            => 0,
            'credit'           => $request->amount,
        ]);
    });

    return redirect()
        ->route('journal.createCapitalLoan')
        ->with('success', 'Entry successfully recorded.');
}
public function report()
    {

        $reportCount = 9;
        $isLive = true;
        $accuracy = '100%';
        $exportOptions = 'PDF/Excel';

        return view('journal_entries.report', [
            'reportCount' => $reportCount,
            'isLive' => $isLive,
            'accuracy' => $accuracy,
            'exportOptions' => $exportOptions,
        ]);
    }
}
