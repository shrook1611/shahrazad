<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class order extends Model
{
    protected $fillable = [
        'user_id',
        'total',
        'status',
        'order_number',
        'payment_method',
        'payment_status',
        'shipping_fee',
        'phone',
        'shipping_address',
        'notes',
        'shipping_area_id'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function orderitems()
    {
        return $this->hasMany(orderitem::class);
    }
    public function shippingArea()
{
    return $this->belongsTo(ShippingArea::class);
}
}
