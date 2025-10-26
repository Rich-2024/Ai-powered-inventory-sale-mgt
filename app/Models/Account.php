<?php

namespace App\Models;
use Illuminate\Support\Facades\Log;

use Illuminate\Database\Eloquent\Model;

class Account extends Model
{
    protected $fillable = [
        'admin_id',
        'code',
        'name',
        'type',
    ];


   public function admin()
{
    return $this->belongsTo(User::class, 'admin_id');
}
public static function createDefaultAccountsFor($admin)
{
    \Log::info('Creating accounts for admin ID: ' . $admin->id);

    $accounts = [
        ['code' => '1000', 'name' => 'Cash', 'type' => 'asset'],
        ['code' => '1200', 'name' => 'Inventory', 'type' => 'asset'],
        ['code' => '1100', 'name' => 'Accounts Receivable', 'type' => 'asset'],
        ['code' => '4000', 'name' => 'Sales Revenue', 'type' => 'income'],
        ['code' => '5000', 'name' => 'COGS', 'type' => 'expense'],
        ['code' => '6000', 'name' => 'Operational Expense', 'type' => 'expense'],
        ['code' => '3000', 'name' => 'Owner’s Capital', 'type' => 'equity'],
        ['code' => '2000', 'name' => 'Loan Payable', 'type' => 'liability'],
    ];

    foreach ($accounts as $account) {
        \Log::info('Creating account: ' . $account['code']);

        self::create([
            'admin_id' => $admin->id,
            ...$account,
        ]);
    }
}

    // Static method to create default accounts
// public static function createDefaultAccountsFor($admin)
// {
//     $accounts = [
//         ['code' => '1000', 'name' => 'Cash', 'type' => 'asset'],
//         ['code' => '1200', 'name' => 'Inventory', 'type' => 'asset'],
//            ['code' => '1100', 'name' => 'Accounts Receivable', 'type' => 'asset'],
//         ['code' => '4000', 'name' => 'Sales Revenue', 'type' => 'income'],
//         ['code' => '5000', 'name' => 'COGS', 'type' => 'expense'],
//         ['code' => '6000', 'name' => 'Operational Expense', 'type' => 'expense'],
//         ['code' => '3000', 'name' => 'Owner’s Capital', 'type' => 'equity'],
//         ['code' => '2000', 'name' => 'Loan Payable', 'type' => 'liability'],
//     ];

//     foreach ($accounts as $account) {
//         self::create([
//             'admin_id' => $admin->id,
//             ...$account,
//         ]);
//     }
// }


    public function journalLines()
{
    return $this->hasMany(JournalLine::class);
}

}
