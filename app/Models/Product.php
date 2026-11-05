<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    /** @use HasFactory<\Database\Factories\ProductFactory> */
    use HasFactory;
 protected $fillable = [
        'name',
        'price',
        'description',
        'category_id',
        'stock',
        'img',
    ];
public function category()
    {
        return $this->belongsTo(category::class);
    }

public function shipmentItems()
{
    return $this->hasMany(ShipmentItem::class);
}

public function stockMovements()
{
    return $this->hasMany(StockMovement::class);
}







}
