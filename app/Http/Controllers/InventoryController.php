<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Inventory;
use App\Models\JournalEntry;
use App\Models\JournalLine;
use App\Models\InventoryHistory;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\StreamedResponse;

use Illuminate\Support\Facades\DB;

class InventoryController extends Controller
{
    public function fullInventoryDetails()
    {
        // Get products belonging to the logged-in admin
        $products = Inventory::where('admin_id', auth()->id())
            ->with(['inventoryHistories' => function ($query) {
                $query->orderBy('created_at', 'asc');
            }])
            ->orderBy('name')
            ->paginate(15);

        $products->getCollection()->transform(function ($product) {
            $validHistories = $product->inventoryHistories->filter(function ($history) {
                return !is_null($history->previous_quantity);
            });

            if ($validHistories->isNotEmpty()) {
                $product->initial_quantity = $validHistories->max('previous_quantity');
            } elseif ($product->inventoryHistories->isNotEmpty()) {
                $product->initial_quantity = $product->inventoryHistories->first()->new_quantity;
            } else {
                $product->initial_quantity = $product->quantity;
            }

            return $product;
        });

        return view('products.fullInventory', compact('products'));
    }

    public function showUploadForm()
    {
        return view('inventory.upload');
    }

    // public function uploadInventory(Request $request)
    // {
    //     $data = $request->validate([
    //         'products' => 'required|array|min:1',
    //         'products.*.sku' => 'required|string',
    //         'products.*.name' => 'required|string',
    //         'products.*.quantity' => 'required|integer|min:0',
    //         'products.*.price' => 'required|numeric|min:0',
    //         'products.*.purchase_price' => 'required|numeric|min:0',
    //     ]);

    //     foreach ($data['products'] as $productData) {
    //         // Only find product owned by current admin
    //         $product = Product::where('sku', $productData['sku'])
    //                           ->where('admin_id', auth()->id())
    //                           ->first();

    //         if ($product) {
    //             $product->quantity += $productData['quantity'];
    //             $product->name = $productData['name'];
    //             $product->price = $productData['price'];
    //             $product->purchase_price = $productData['purchase_price'];
    //             $product->total_price = $product->quantity * $product->price;
    //             $product->total_purchase_price = $product->quantity * $product->purchase_price;
    //             $product->save();
    //         } else {
    //             $productData['total_price'] = $productData['quantity'] * $productData['price'];
    //             $productData['total_purchase_price'] = $productData['quantity'] * $productData['purchase_price'];
    //             $productData['admin_id'] = auth()->id(); // Assign ownership
    //             Product::create($productData);
    //         }
    //     }

    //     return redirect()->back()->with('success', 'Inventory uploaded successfully!');
    // }

    //
    public function list()
{
    $products = Inventory::where('admin_id', auth()->id())
        ->orderBy('name')
        ->paginate(10);

    $totalPurchaseValue = 0;
    $totalSellValue = 0;

    foreach ($products as $product) {
        // Calculate total purchase value
        $product->total_purchase_value = $this->calculateTotalValue(
            $product->quantity,
            $product->unit,
            $product->purchase_price_bulk,
            $product->purchase_price
        );

        // Calculate total sell value
        $product->total_sell_value = $this->calculateTotalValue(
            $product->quantity,
            $product->unit,
            $product->selling_price_bulk,
            $product->price
        );

        // Calculate expected profit
        $product->expected_profit = $product->total_sell_value - $product->total_purchase_value;

        $totalPurchaseValue += $product->total_purchase_value;
        $totalSellValue += $product->total_sell_value;
    }

    $expectedProfit = $totalSellValue - $totalPurchaseValue;

    return view('inventory.list', compact(
        'products',
        'totalPurchaseValue',
        'totalSellValue',
        'expectedProfit'
    ));
}

/**
 * Calculate total value based on quantity, unit, bulk price and unit price.
 *
 * @param int|float $quantity
 * @param string $unit
 * @param float|null $bulkPrice
 * @param float|null $unitPrice
 * @return float
 */
protected function calculateTotalValue($quantity, $unit, $bulkPrice, $unitPrice)
{
    // Normalize prices (treat null as zero)
    $bulkPrice = $bulkPrice ?? 0;
    $unitPrice = $unitPrice ?? 0;

    // Decide price based on unit type
    if (in_array(strtolower($unit), ['dozen', 'carton'])) {
        // For bulk units, multiply quantity by bulk price
        return $quantity * $bulkPrice;
    } else {
        // For individual units or unknown units, multiply quantity by unit price
        return $quantity * $unitPrice;
    }
}


    public function showAdjustmentForm()
    {
        // Only allow selecting owned products
        $products = Inventory::where('admin_id', auth()->id())
            ->orderBy('name')
            ->get();

        return view('inventory.adjust', compact('products'));
    }

    public function processAdjustments(Request $request)
    {
        dd($request->all);
        $validated = $request->validate([
'product_id' => 'required|exists:inventories,id',
            'type' => 'required|in:increase,decrease',
            'quantity' => 'required|integer|min:1',
            'note' => 'nullable|string|max:255',
        ]);

        // Ensure product belongs to current admin
        $product = Inventory::where('id', $validated['product_id'])
                          ->where('admin_id', auth()->id())
                          ->firstOrFail();

        $original = $product->quantity;

        if ($validated['type'] === 'increase') {
            $product->quantity += $validated['quantity'];
        } else {
            $product->quantity -= $validated['quantity'];
            if ($product->quantity < 0) {
                return back()->withErrors(['quantity' => 'Quantity cannot go below 0.']);
            }
        }

        $product->save();

        return redirect()->route('inventory.list')->with('success', "Stock Quantity adjusted from $original to {$product->quantity} for {$product->name}.");
    }

   public function processAdjustment(Request $request)
{
    $validated = $request->validate([
        'product_id' => 'required|exists:inventories,id',
        'type' => 'required|in:increase,decrease',
        'quantity' => 'required|integer|min:1',
        'note' => 'nullable|string|max:255',
    ]);

    $adminId = auth()->id();

    // Ensure inventory belongs to current admin
    $product = Inventory::where('id', $validated['product_id'])
                      ->where('admin_id', $adminId)
                      ->firstOrFail();

    $original = $product->quantity;
    $newQuantity = $original;

    if ($validated['type'] === 'increase') {
        $newQuantity += $validated['quantity'];
    } else {
        $newQuantity -= $validated['quantity'];

        if ($newQuantity < 0) {
            return back()->withErrors(['quantity' => 'Quantity cannot go below 0.']);
        }
    }

    $product->quantity = $newQuantity;
    $product->save();

    // Log history
    InventoryHistory::create([
        'product_id' => $product->id,
        'user_id' => $adminId,
        'type' => $validated['type'],
        'quantity' => $validated['quantity'],
        'previous_quantity' => $original,
        'new_quantity' => $newQuantity,
        'note' => $validated['note'],
    ]);

    // ⚙️ 3. Accounting Journal Entry for INCREASE
    if ($validated['type'] === 'increase') {
        $purchasePrice = $product->purchase_price ?? 0;
        $quantityInPieces = $validated['quantity'];
        $inventoryValue = $purchasePrice * $quantityInPieces;

        if ($inventoryValue > 0) {
            $accountCodes = [
                'Inventory' => '1200',
                'Cash' => '1000',
            ];

            $accountIds = [];
            foreach ($accountCodes as $name => $code) {
                $accountIds[$name] = \App\Models\Account::where('code', $code)
                    ->where('admin_id', $adminId)
                    ->value('id');

                if (!$accountIds[$name]) {
                    throw new \Exception("Account $name ($code) not found for admin $adminId");
                }
            }

            $journal = \App\Models\JournalEntry::create([
                'reference' => 'INV-UP-' . strtoupper($product->sku),
                'description' => "Manual stock increase of {$product->name} ({$quantityInPieces} pieces)",
                'entry_date' => now()->toDateString(),
                'admin_id' => $adminId,
            ]);

            // Debit Inventory
            \App\Models\JournalLine::create([
                'journal_entry_id' => $journal->id,
                'account_id' => $accountIds['Inventory'],
                'debit' => $inventoryValue,
                'credit' => 0,
            ]);

            // Credit Cash
            \App\Models\JournalLine::create([
                'journal_entry_id' => $journal->id,
                'account_id' => $accountIds['Cash'],
                'debit' => 0,
                'credit' => $inventoryValue,
            ]);
        }
    }

    return redirect()->route('inventory.history')->with('success', "Stock adjusted and logged.");
}


    public function history()
    {
        // Only show history related to products owned by this admin
        $logs = InventoryHistory::whereHas('product', function ($q) {
                $q->where('admin_id', auth()->id());
            })
            ->with(['product', 'user'])
            ->latest()
            ->paginate(15);

        return view('inventory.history', compact('logs'));
    }

    public function index(Request $request)
    {
        $query = Inventory::where('admin_id', auth()->id());

        if ($request->filled('search')) {
            $query->where('name', 'like', '%'.$request->search.'%');
        }

        if ($request->filled('category')) {
            $query->where('category_id', $request->category);
        }

        if ($request->filled('stock_status')) {
            if ($request->stock_status === 'low') {
                $query->where('quantity', '<=', 10)->where('quantity', '>', 0);
            } elseif ($request->stock_status === 'out') {
                $query->where('quantity', 0);
            } elseif ($request->stock_status === 'in') {
                $query->where('quantity', '>', 10);
            }
        }

        $products = $query->paginate(15);

        return view('inventory.index', compact('products'));
    }

  public function priceLookup()
{
    $user = auth()->user();

    // Show products created by the admin this employee belongs to
    $adminId = $user->isAdmin() ? $user->id : $user->admin_id;

    $products = Inventory::where('admin_id', $adminId)->get();

    return view('employee.products.lookup', compact('products'));
}


//    public function uploadInventory(Request $request)
// {
//     $validated = $request->validate([
//         'products' => ['required', 'array', 'min:1'],
//         'products.*.sku' => ['required', 'string'],
//         'products.*.name' => ['required', 'string'],
//         'products.*.quantity' => ['required', 'integer', 'min:1'],
//         'products.*.unit' => ['required', 'in:piece,dozen,carton'],
//         'products.*.purchase_price_bulk' => ['nullable', 'string'],
//         'products.*.selling_price_bulk' => ['nullable', 'string'],
//         'products.*.purchase_price' => ['nullable', 'string'],
//         'products.*.price' => ['nullable', 'string'],
//     ]);

//     $unitQuantities = [
//         'piece' => 1,
//         'dozen' => 12,
//         'carton' => 24,
//     ];

//     foreach ($validated['products'] as $product) {
//         $unit = $product['unit'];
//         $unitSize = $unitQuantities[$unit] ?? 1;

//         $originalQuantity = (int) $product['quantity'];
//         $quantityInPieces = $unit === 'piece'
//             ? $originalQuantity
//             : $originalQuantity * $unitSize;

//         $isBulk = $unit !== 'piece';

//         $purchasePriceBulk = $isBulk
//             ? $this->parseCurrency($product['purchase_price_bulk'] ?? null)
//             : null;

//         $sellingPriceBulk = $isBulk
//             ? $this->parseCurrency($product['selling_price_bulk'] ?? null)
//             : null;

//         $purchasePrice = $isBulk
//             ? ($purchasePriceBulk > 0 ? $purchasePriceBulk / $quantityInPieces : 0)
//             : $this->parseCurrency($product['purchase_price'] ?? null);

//         $price = $isBulk
//             ? ($sellingPriceBulk > 0 ? $sellingPriceBulk / $quantityInPieces : 0)
//             : $this->parseCurrency($product['price'] ?? null);

//         Inventory::create([
//             'sku' => $product['sku'],
//             'name' => $product['name'],
//             'quantity' => $quantityInPieces,            // Stored in pieces
//             'original_quantity' => $originalQuantity,    // User input
//             'unit' => $unit,
//             'purchase_price_bulk' => $purchasePriceBulk,
//             'selling_price_bulk' => $sellingPriceBulk,
//             'purchase_price' => $purchasePrice,
//             'price' => $price,
//             'admin_id' => auth()->id(),
//         ]);
//     }

//     return redirect()->back()->with('success', 'Inventory uploaded successfully.');
// }

// /**
//  * Remove commas and convert to float.
//  */
// private function parseCurrency(?string $value): float
// {
//     return $value ? floatval(str_replace(',', '', $value)) : 0;
// }

// }
public function uploadInventory(Request $request)
{
    $validated = $request->validate([
        'products' => ['required', 'array', 'min:1'],
        'products.*.sku' => ['required', 'string'],
        'products.*.name' => ['required', 'string'],
        'products.*.quantity' => ['required', 'integer', 'min:1'],
        'products.*.unit' => ['required', 'in:piece,dozen,carton'],
        'products.*.purchase_price_bulk' => ['nullable', 'string'],
        'products.*.selling_price_bulk' => ['nullable', 'string'],
        'products.*.purchase_price' => ['nullable', 'string'],
        'products.*.price' => ['nullable', 'string'],
    ]);
 $adminId = auth()->id();


    $hasCapital = \App\Models\JournalLine::whereHas('journalEntry', function ($q) use ($adminId) {
        $q->where('admin_id', $adminId);
    })
    ->whereIn('account_id', function ($query) use ($adminId) {
        $query->select('id')
              ->from('accounts')
              ->where('admin_id', $adminId)
              ->whereIn('code', ['3000', '2000']);
    })
    ->exists();

    if (!$hasCapital) {
        return redirect()->route('journal.createCapitalLoan')
            ->withErrors(['error' => 'Please set your starting capital (equity or liability) before uploading inventory.']);
    }
    $unitQuantities = [
        'piece' => 1,
        'dozen' => 12,
        'carton' => 24,
    ];

    $adminId = auth()->id();

    DB::beginTransaction();

    try {
        foreach ($validated['products'] as $product) {
            $unit = $product['unit'];
            $unitSize = $unitQuantities[$unit] ?? 1;

            $originalQuantity = (int) $product['quantity'];
            $quantityInPieces = $unit === 'piece'
                ? $originalQuantity
                : $originalQuantity * $unitSize;

            $isBulk = $unit !== 'piece';

            $purchasePriceBulk = $isBulk
                ? $this->parseCurrency($product['purchase_price_bulk'] ?? null)
                : null;

            $sellingPriceBulk = $isBulk
                ? $this->parseCurrency($product['selling_price_bulk'] ?? null)
                : null;

            $purchasePrice = $isBulk
                ? ($purchasePriceBulk > 0 ? $purchasePriceBulk / $quantityInPieces : 0)
                : $this->parseCurrency($product['purchase_price'] ?? null);

            $price = $isBulk
                ? ($sellingPriceBulk > 0 ? $sellingPriceBulk / $quantityInPieces : 0)
                : $this->parseCurrency($product['price'] ?? null);

            // 1. Save inventory
            $productModel = Inventory::create([
                'sku' => $product['sku'],
                'name' => $product['name'],
                'quantity' => $quantityInPieces,
                'original_quantity' => $originalQuantity,
                'unit' => $unit,
                'purchase_price_bulk' => $purchasePriceBulk,
                'selling_price_bulk' => $sellingPriceBulk,
                'purchase_price' => $purchasePrice,
                'price' => $price,
                'admin_id' => $adminId,
            ]);

            // 2. Inventory history
            InventoryHistory::create([
                'product_id' => $productModel->id,
                'user_id' => $adminId,
                'type' => 'increase',
                'quantity' => $quantityInPieces,
                'previous_quantity' => 0,
                'new_quantity' => $quantityInPieces,
                'note' => 'Initial stock upload right first time',
            ]);

            // 3. Accounting Journal Entry
            $inventoryValue = $purchasePrice * $quantityInPieces;

            $accountCodes = [
                'Inventory' => '1200',
                'Cash' => '1000',
            ];

            $accountIds = [];
            foreach ($accountCodes as $name => $code) {
                $accountIds[$name] = \App\Models\Account::where('code', $code)
                    ->where('admin_id', $adminId)
                    ->value('id');

                if (!$accountIds[$name]) {
                    throw new \Exception("Account $name ($code) not found for admin $adminId");
                }
            }

            $journal = \App\Models\JournalEntry::create([
                'reference' => 'INV-UP-' . strtoupper($product['sku']),
                'description' => "Stock upload of {$product['name']} ({$quantityInPieces} pieces)",
                'entry_date' => now()->toDateString(),
                'admin_id' => $adminId,
            ]);

            // Debit Inventory
            \App\Models\JournalLine::create([
                'journal_entry_id' => $journal->id,
                'account_id' => $accountIds['Inventory'],
                'debit' => $inventoryValue,
                'credit' => 0,
            ]);

            // Credit Cash
            \App\Models\JournalLine::create([
                'journal_entry_id' => $journal->id,
                'account_id' => $accountIds['Cash'],
                'debit' => 0,
                'credit' => $inventoryValue,
            ]);
        }

        DB::commit();

        return redirect()->back()->with('success', 'Inventory uploaded and journaled successfully.');
    } catch (\Exception $e) {
        DB::rollBack();
        \Log::error('Inventory upload failed', ['error' => $e->getMessage()]);
        return back()->with('error', 'Failed to upload inventory: ' . $e->getMessage());
    }
}

/**
 * Remove commas and convert to float.
 */
private function parseCurrency(?string $value): float
{
    return $value ? floatval(str_replace(',', '', $value)) : 0;
}


public function downloadTemplate(): StreamedResponse
{
    $headers = [
        "Content-type" => "text/csv",
        "Content-Disposition" => "attachment; filename=inventory_template.csv",
        "Pragma" => "no-cache",
        "Cache-Control" => "must-revalidate, post-check=0, pre-check=0",
        "Expires" => "0"
    ];

    $columns = ['SKU', 'Name', 'Quantity', 'Unit', 'Purchase Price', 'Selling Price'];

    $callback = function () use ($columns) {
        $file = fopen('php://output', 'w');
        fputcsv($file, $columns);
        // Optional: add a sample row
        fputcsv($file, ['123456', 'Sample Product', '10', 'piece', '100.00', '150.00']);
        fclose($file);
    };

    return response()->stream($callback, 200, $headers);
}
public function bulkUpload(Request $request)
{
    $request->validate([
        'inventory_file' => 'required|file|mimes:csv,txt|max:2048',
    ]);

    $path = $request->file('inventory_file')->getRealPath();
    $rows = array_map('str_getcsv', file($path));

    // Skip the header row
    foreach (array_slice($rows, 1) as $row) {
        [$sku, $name, $quantity, $unit, $purchasePrice, $sellingPrice] = $row;

        Inventory::updateOrCreate(
            ['sku' => $sku],
            [
                'name'           => $name,
                'quantity'       => $quantity,
                'unit'           => $unit,
                'purchase_price' => $purchasePrice,
                'selling_price'  => $sellingPrice,
            ]
        );
    }

    return back()->with('success', 'Bulk inventory uploaded successfully.');
}


}
