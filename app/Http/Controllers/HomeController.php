<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $newproducts = \App\Models\Product::all()->sortByDesc('created_at')->take(4);
        $categories = \App\Models\Category::all();
        $allproducts = \App\Models\Product::all();
        if (auth()->check()) {
            $cart = Cart::with('cartitems')->where('user_id', auth()->user()->id)->first();
        } else {
            $cart = null;
        }
        // $cart=Cart::with('cartitems')->where('user_id', auth()->user()->id)->first();
    
   if ($cart) {
    $total = $cart->cartitems->sum(function ($cartitem) {
        return $cartitem->TotalPrice;
    });
} else {
    $total = 0;
}
        return view('user.index', compact('newproducts', 'categories', 'allproducts', 'cart', 'total'));
       
    }
}
