<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StockMovement extends Model
{
    protected $fillable = [
        'product_id',
        'shipment_id',
        'type',
        'quantity',
        'stock_before',
        'stock_after',
        'notes',
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function shipment()
    {
        return $this->belongsTo(Shipment::class);
    }
}
