<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = \App\Models\Category::all();
        return view('categories.index', compact('categories'));
       
    }
  public function create()
  {
      return view('categories.create');
  }
  public function store(Request $request)
  {
      $request->validate([
          'name' => 'required|string|max:255',
          
      ]);

        \App\Models\Category::create([
            'name' => $request->name,
            
        ]);

      return redirect()->route('category.index')->with('success', 'Category created successfully.');
  }
}
