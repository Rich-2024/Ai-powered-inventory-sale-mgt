<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\ExpenseController as ControllersExpenseController;
use App\Http\Controllers\MessageController;
use App\Http\Controllers\SaleController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\InventoryController;
use App\Http\Controllers\JournalEntryController as ControllersJournalEntryController;
use App\Models\controllers\ExpenseController;
use App\Models\controllers\JournalEntryController;


use App\Models\controllers\AdminRegisterController;
use App\Models\InventoryHistory;

/*
|--------------------------------------------------------------------------
| Public Routes
|--------------------------------------------------------------------------
*/
Route::get('/keep-alive', function () {
    return response()->noContent(); // returns 204 No Content
});
Route::get('/terms-and-conditions', [AdminController::class, 'tot'])->name('tot');

Route::get('/suspended', function () {
    return view('auth.suspended');
})->name('suspension.page');
Route::patch('/admin/employees/{id}/reactivate', [EmployeeController::class, 'reactivate'])
    ->name('admin.employees.reactivate');

Route::get('/', function () {
    return view('welcome');
})->name('welcome');
    Route::get('/register', [LoginController::class, 'showRegistrationForm'])->name('register');

Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login'])->name('login.submit');
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');
  Route::resource('admin/employees', EmployeeController::class)
        ->names([
            'index' => 'admin.employees.index',
            'create' => 'admin.employees.create',
            'storemployee' => 'admin.employees.store',
            'edit' => 'admin.employees.edit',
            'update' => 'admin.employees.update',
            'destroy' => 'admin.employees.destroy',
        ]);
/*
|--------------------------------------------------------------------------
| Admin Routes
|--------------------------------------------------------------------------
*/
//journall


Route::get('/inventory/template/download', [InventoryController::class, 'downloadTemplate'])->name('inventory.template.download');

Route::post('/inventory/bulk/upload', [InventoryController::class, 'bulkUpload'])
    ->name('inventory.bulk.upload');

Route::get('/inventory/download/template', [InventoryController::class, 'downloadTemplate'])->name('inventory.download.template');

Route::get('/admin/operational-costs', [ControllersExpenseController::class, 'returnOperationalcost'])->name('operational-costs.store');

Route::post('/admin/operational-costs', [ControllersExpenseController::class, 'storeoperationalcost'])->name('operational-costs.store');

Route::get('/report-dashboard', [ControllersJournalEntryController::class, 'report'])->name('reports.journal');

Route::get('/journal-entries/summary', [ControllersJournalEntryController::class, 'summary'])->name('journal.summary');

Route::get('/admin/journal-entries', [ControllersJournalEntryController::class, 'index'])

    ->name('admin.journal_entries.index');
    Route::get('/reports/profit-loss', [ControllersJournalEntryController::class, 'profitAndLoss'])->name('reports.profit_loss');
Route::get('/reports/balance-sheet', [ControllersJournalEntryController::class, 'balanceSheet'])->name('reports.balance_sheet');

  Route::get('/journal/capital-loan', [ControllersJournalEntryController::class, 'createCapitalLoan'])->name('journal.createCapitalLoan');
    Route::post('/journal/capital-loan', [ControllersJournalEntryController::class, 'storeCapitalLoan'])->name('journal.storeCapitalLoan');
Route::get('/credit-salesR', [SaleController::class, 'credit'])->name('credit.sales');

    Route::get('/credit-sales', [SaleController::class, 'index'])->name('credit.sales.index');
     Route::post('/credit-sales/store', [SaleController::class, 'storeCreditSale'])->name('credit.sales.store');
   Route::patch('/credit-sales/{id}/paid', [SaleController::class, 'markAsPaid'])->name('credit.sales.paid');
Route::patch('/credit-sales/{id}/returned', [SaleController::class, 'markAsReturned'])->name('credit.sales.returned');


Route::get('/reports/adminsale', [ProductController::class, 'salesReport'])->name('reports.admins');
Route::get('/reports/EmpRecord', [ProductController::class, 'salesemp'])->name('reports.admin');

Route::get('/reports/adminRecord', [SaleController::class, 'salesReports'])->name('reports.sales');

    Route::get('/sales', [ControllersExpenseController::class, 'adminSalesWithExpenses'])->name('admin.sales.index');

 Route::get('/admin/sales/create', [SaleController::class, 'create'])->name('admin.sales.create');
  Route::post('/admin/sales/store', [SaleController::class, 'storesales'])->name('admin.sales.store');


Route::get('/inventoryfullDetails', [InventoryController::class, 'fullInventoryDetails'])->name('products.full');

 Route::get('/purchase', [AdminController::class, 'showPurchaseForm'])->name('admin.stocks.purchase');
    Route::post('/store', [AdminController::class, 'storePurchase'])->name('purchases.store');
Route::get('/my-purchases', [AdminController::class, 'index'])
    ->name('purchases.view')
    ->middleware('auth');
    Route::get('/sales/report', [SaleController::class, 'salesReport'])->name('sales.report');
Route::delete('/messages/{id}/delete', [MessageController::class, 'delete'])->name('messages.delete')->middleware('auth');

Route::post('/admin/messages/send', [MessageController::class, 'adminSend'])->name('admin.messages.send')->middleware('auth', 'admin');
Route::get('/admin/messages/sent', [MessageController::class, 'sent'])->name('admin.messages.sent');

     Route::get('/admin/messages', [MessageController::class, 'adminIndex'])->name('admin.messages.index');
    Route::post('/admin/messages/{id}/reply', [MessageController::class, 'adminReply'])->name('admin.messages.reply');
    Route::get('/admin/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');
 Route::get('/inventory/upload', [InventoryController::class, 'showUploadForm'])->name('inventory.upload.form');
    Route::post('/inventory/upload', [InventoryController::class, 'uploadInventory'])->name('inventory.upload.process');
Route::get('/inventory/listings', [InventoryController::class, 'list'])->name('inventory.list');
Route::get('/inventory/adjust', [InventoryController::class, 'showAdjustmentForm'])->name('inventory.adjust.form');
Route::post('/inventory/adjust', [InventoryController::class, 'processAdjustment'])->name('inventory.adjust.process');
Route::get('/inventory/history', [InventoryController::class, 'history'])->name('inventory.history');
    Route::get('/inventorys', [InventoryController::class, 'index'])->name('inventory.index');
Route::get('/inventory', [InventoryController::class, 'index'])->name('inventory.list');
        Route::get('/admin', [AdminController::class, 'dashboard'])->name('admin.products.index');
Route::patch('/admin/employees/{id}/suspend', [EmployeeController::class, 'suspend'])->name('admin.employees.suspend');
    Route::get('/expenses', [ ControllersExpenseController::class, 'index'])->name('expenses.index');

Route::get('/register', [LoginController::class, 'showRegistrationForm'])->name('register');
    Route::post('/register', [LoginController::class, 'store'])->name('store');
Route::middleware(['auth', 'admin'])->group(function () {
    Route::resource('/admin/products', ProductController::class);
    Route::get('/admin/sales', [AdminController::class, 'salesReport'])->name('admin.sales');
    Route::post('/admin/employees', [EmployeeController::class, 'storemployee'])->name('admin.employees.store');
    Route::post('/admin/users/status/{id}', [AdminController::class, 'toggleStatus'])->name('admin.users.status');
});

/*
|--------------------------------------------------------------------------
| Employee Routes
|--------------------------------------------------------------------------

*/
// For products resource CRUD routes
Route::resource('products', ProductController::class);
Route::resource('products', ProductController::class)->only(['edit', 'update', 'destroy']);

  Route::get('/expenses', [ControllersExpenseController::class, 'index'])->name('employee.expenses.index');
    Route::post('/expenses/store', [ControllersExpenseController::class, 'store'])->name('employee.expenses.store');
    Route::delete('/expenses/{expense}', [ControllersExpenseController::class, 'destroy'])->name('employee.expenses.destroy');
Route::get('/expenses/{expense}/edit', [ControllersExpenseController::class, 'edit'])->name('employee.expenses.edit');
Route::get('/expenses/{expense}/edit', [ControllersExpenseController::class, 'edit'])->name('employee.expenses.edit');
Route::put('/expenses/{expense}', [ControllersExpenseController::class, 'update'])->name('employee.expenses.update');

 Route::get('/chat', [MessageController::class, 'index'])->name('chat.index');
    Route::post('/chat', [MessageController::class, 'store'])->name('chat.store');
Route::middleware(['auth', 'employee'])->group(function () {

    Route::get('/employee/dashboard', [EmployeeController::class, 'dashboard'])->name('employee.dashboard');
    Route::get('/employee/sales/create', [SaleController::class, 'create'])->name('employee.sales.create');
    Route::post('/employee/sales', [SaleController::class, 'store'])->name('employee.sales.store');

    Route::get('/employee/sales/history', [SaleController::class, 'history'])->name('employee.sales.history');
Route::get('/employee/sales/report', [SaleController::class, 'report'])->name('employee.sales.report');

    Route::get('/employee/prices', [InventoryController::class, 'priceLookup'])->name('employee.prices');
Route::delete('/admin/messages/{id}', [MessageController::class, 'destroy'])->name('admin.messages.delete');
  Route::get('/expenses/create', [ControllersExpenseController::class, 'create'])->name('employee.expenses.create]');
    Route::post('/expenses/store', [ControllersExpenseController::class, 'store'])->name('employee.expenses.store');
    Route::get('/employee/messages', [MessageController::class, 'create'])->name('employee.messages.create');
    Route::post('/employee/messages', [MessageController::class, 'store'])->name('employee.messages.store');
});
