<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cartitem extends Model
{
    protected $guarded = [];

    public function Cart()
    {
        return $this->belongsTo(Cart::class);
    }

    public function Product()
    {
        return $this->belongsTo(Product::class);
    }
}
