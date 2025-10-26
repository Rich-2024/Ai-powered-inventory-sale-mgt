<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    // protected $fillable = ['name', 'price', 'quantity','sku','note','purchase_price' ,  'total_price', 'total_purchase_price', 'admin_id','image_path'];
protected $fillable = [
    'sku',
    'name',
    'unit',               // e.g., 'dozen', 'carton', etc.
    'original_qty',       // full cartons/dozens in stock
    'loose_pieces',       // loose pieces outside full cartons
    'unit_conversion',    // pieces per carton/dozen
    'purchase_price_per_piece',
    'selling_price_per_piece',
    'purchase_price_per_carton',
    'selling_price_per_carton',
    'admin_id',
     'price',
      'quantity',
    // any other product attributes
];

    public function saleItems()
    {
        return $this->hasMany(SaleItem::class);
    }
    public function inventoryHistories()
{
    return $this->hasMany(InventoryHistory::class, 'product_id');
}
protected $casts = [
    'original_qty'    => 'integer', // number of full cartons/dozens
    'loose_pieces'    => 'integer', // loose pieces not forming full carton
    'unit_conversion' => 'integer', // pieces per carton/dozen
];

// Total pieces = (full cartons * pieces per carton) + loose pieces
public function getTotalPiecesAttribute(): int
{
    return ($this->original_qty * $this->unit_conversion) + $this->loose_pieces;
}

/**
 * Deduct stock in pieces.
 * Breaks full units into pieces if needed.
 *
 * @param int $piecesToDeduct
 * @return bool True if stock deducted, false if insufficient stock.
 */
// app/Models/Product.php

public function convertToPieces($quantity, $unit)
{
    return match ($unit) {
        'piece' => $quantity,
        'dozen' => $quantity * 12,
        'carton' => $quantity * $this->unit_conversion,
        default => throw new \InvalidArgumentException("Invalid unit: $unit"),
    };
}

public function recalculateUnitsFromPieces()
{
    if ($this->unit_type === 'carton' && $this->unit_conversion > 0) {
        $this->full_cartons = floor($this->total_pieces / $this->unit_conversion);
        $this->loose_pieces = $this->total_pieces % $this->unit_conversion;
    } elseif ($this->unit_type === 'dozen') {
        $this->full_dozens = floor($this->total_pieces / 12);
        $this->loose_pieces = $this->total_pieces % 12;
    } else {
        $this->loose_pieces = $this->total_pieces;
    }

    $this->save();
}



}
