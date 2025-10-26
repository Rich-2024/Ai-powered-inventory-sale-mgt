<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Sale extends Model
{
protected $fillable = [
    'employee_id',
    'user_id',
    'product_id',
    'quantity',
    'admin_id',
    'total_amount',
    'pieces_sold',
    'price_per_piece',
    'discount',
    'status',
    'unit',
];


    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function saleItems()
    {
        return $this->hasMany(SaleItem::class);
    }
    public function product()
{
    return $this->belongsTo(Inventory::class);
}
    public function employee()
    {
        return $this->belongsTo(User::class, 'employee_id');
    }
    const STATUS_PENDING = 'pending';
    const STATUS_PAID = 'paid';
    const STATUS_CANCELLED = 'cancelled';

    // A helper methods for convenience
    public function isPending() { return $this->status === self::STATUS_PENDING; }
    public function isPaid() { return $this->status === self::STATUS_PAID; }
    public function isCancelled() { return $this->status === self::STATUS_CANCELLED; }


}
