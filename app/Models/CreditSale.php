<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CreditSale extends Model
{
   protected $fillable = [
    'product_id',
    'user_id',
    'admin_id',
    'employee_id',
    'customer_name',
    'quantity',
    'unit',
    'price',
    'unit_price',
    'total_pieces',
    'expected_total',
    'amount_paid',
    'balance_left',
    'discount',
    'sale_date',
    'status',
];


    public function product()
    {
        return $this->belongsTo(inventory::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
