<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class InventoryHistory extends Model
{
    use HasFactory;

  protected $fillable = [
    'product_id',
    'user_id',
    'type',
    'quantity',
    'previous_quantity',
    'new_quantity',
    'note',
     'admin_id',
];

    // Optional relationships
    // public function product()
    // {
    //     return $this->belongsTo(Product::class);
    // }
 public function product()
    {
        return $this->belongsTo(Inventory::class);
    }
    public function user()
    {
        return $this->belongsTo(User::class);
    }


}
