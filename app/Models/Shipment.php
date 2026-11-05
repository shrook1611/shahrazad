<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Shipment extends Model
{
      protected $fillable = [
        'supplier_name',
        'reference_number',
        'received_at',
        'notes',
    ];

    protected $casts = [
        'received_at' => 'date',
    ];

    public function items()
    {
        return $this->hasMany(ShipmentItem::class);
    }

    public function stockMovements()
{
    return $this->hasMany(StockMovement::class);
}
}
