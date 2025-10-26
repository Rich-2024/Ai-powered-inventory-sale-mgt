<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Inventory extends Model
{
    // Specify the fillable fields for mass assignment
    protected $fillable = [
        'sku',
        'name',
        'quantity',
        'unit',
        'original_quantity',
        'purchase_price_bulk',
        'selling_price_bulk',
        'purchase_price',
        'price',

    ];
    public function inventoryHistories()
{
    return $this->hasMany(InventoryHistory::class, 'inventory_id');
}
    // Set admin_d automatically when creating
    protected static function booted()
    {
        static::creating(function ($inventory) {
            if (Auth::check()) {
                $inventory->admin_id = Auth::id();
            }
        });
    }
    function sale(){
        return $this->hasMany(sale::class);
    }
}
