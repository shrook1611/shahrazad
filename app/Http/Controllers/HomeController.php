<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $newproducts = \App\Models\Product::all()->sortByDesc('created_at')->take(4);
        $categories = \App\Models\Category::all();
        $allproducts = \App\Models\Product::all();
        return view('user.index', compact('newproducts', 'categories', 'allproducts'));
       
    }
}
