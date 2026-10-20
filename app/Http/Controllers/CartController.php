<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Product;
use Illuminate\Http\Request;

class CartController extends Controller
{
     public function addToCart(Request $request, $id ){
$cart= Cart::firstOrCreate(['user_id'=>auth()->user()->id]);
$product=Product::find($id);

$item=$cart->cartitems()->where('product_id',$product->id)->first();
if($item){
    $item->update([
        'quantity'=>$item->quantity+1,
        'totalPrice'=>$product->price * ($item->quantity+1),
    ]);
}else{
    $cart->cartitems()->create([
        'product_id'=>$product->id,
        'quantity'=>1,
        'totalPrice'=>$product->price,
    ]);
}

return redirect()->back()->with('success','Product added to cart successfully');

     }
}
