<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ShippingArea extends Model
{
       protected $fillable = [
        'name',
        'shipping_fee',
        'is_active',
    ];
}
