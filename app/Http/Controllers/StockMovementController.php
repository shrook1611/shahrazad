<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\StockMovement;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class StockMovementController extends Controller
{
 public function index(Request $request)
{
    $query = StockMovement::with(['product', 'shipment']);

    // Filter by product
    if ($request->filled('product_id')) {
        $query->where('product_id', $request->product_id);
    }

    // Filter by movement type
    if ($request->filled('type')) {
        $query->where('type', $request->type);
    }

    // Filter by start date
    if ($request->filled('date_from')) {
        $query->whereDate('created_at', '>=', $request->date_from);
    }

    // Filter by end date
    if ($request->filled('date_to')) {
        $query->whereDate('created_at', '<=', $request->date_to);
    }

    $movements = $query->latest()->paginate(20)->withQueryString();

    $products = \App\Models\Product::orderBy('name')->get();

    return view('dashboard.inventory.movements', compact(
        'movements',
        'products'
    ));
}

public function create()
{
    $products = Product::orderBy('name')->get();

    return view('dashboard.inventory.adjustment', compact('products'));
}

public function store(Request $request)
{
    $validated = $request->validate([
        'product_id' => 'required|exists:products,id',
        'direction' => 'required|in:increase,decrease',
        'quantity' => 'required|integer|min:1',
        'notes' => 'required|string|max:1000',
    ]);

    DB::transaction(function () use ($validated) {

        $product = Product::where('id', $validated['product_id'])
            ->lockForUpdate()
            ->firstOrFail();

        $stockBefore = (int) $product->stock;
        $quantity = (int) $validated['quantity'];

        $change = $validated['direction'] === 'increase'
            ? $quantity
            : -$quantity;

        $stockAfter = $stockBefore + $change;

        if ($stockAfter < 0) {
            throw \Illuminate\Validation\ValidationException::withMessages([
                'quantity' => 'The adjustment cannot make stock negative.',
            ]);
        }

        $product->update([
            'stock' => $stockAfter,
        ]);

        StockMovement::create([
            'product_id' => $product->id,
            'shipment_id' => null,
            'type' => 'adjustment',
            'quantity' => $change,
            'stock_before' => $stockBefore,
            'stock_after' => $stockAfter,
            'notes' => $validated['notes'],
        ]);
    });

    return redirect()
        ->route('admin.stock-movements.index')
        ->with('success', 'Stock adjusted successfully!');
}











}
