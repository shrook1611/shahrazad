<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Shipment;
use App\Models\StockMovement;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ShipmentController extends Controller
{
    // Display all shipments
    public function index()
    {
        $shipments = Shipment::with('items.product')
            ->latest('received_at')
            ->paginate(15);

        return view('dashboard.shipments.index', compact('shipments'));
    }

    // Show the create shipment form
    public function create()
    {
        $products = Product::orderBy('name')->get();

        return view('dashboard.shipments.create', compact('products'));
    }


public function store(Request $request)
{
    $validated = $request->validate([
        'supplier_name' => 'required|string|max:255',
        'reference_number' => 'nullable|string|max:255',
        'received_at' => 'required|date',
        'notes' => 'nullable|string|max:1000',

        'items' => 'required|array|min:1',
        'items.*.product_id' => 'required|exists:products,id|distinct',
        'items.*.quantity' => 'required|integer|min:1',
        'items.*.unit_cost' => 'nullable|numeric|min:0',
    ]);

    DB::transaction(function () use ($validated) {
        $shipment = Shipment::create([
            'supplier_name' => $validated['supplier_name'],
            'reference_number' => $validated['reference_number'] ?? null,
            'received_at' => $validated['received_at'],
            'notes' => $validated['notes'] ?? null,
        ]);

        foreach ($validated['items'] as $item) {
            $product = Product::where('id', $item['product_id'])
                ->lockForUpdate()
                ->firstOrFail();

            $stockBefore = (int) $product->stock;
            $quantity = (int) $item['quantity'];
            $stockAfter = $stockBefore + $quantity;

            $shipment->items()->create([
                'product_id' => $product->id,
                'quantity' => $quantity,
                'unit_cost' => $item['unit_cost'] ?? null,
            ]);

            $product->update([
                'stock' => $stockAfter,
            ]);

            StockMovement::create([
                'product_id' => $product->id,
                'shipment_id' => $shipment->id,
                'type' => 'shipment',
                'quantity' => $quantity,
                'stock_before' => $stockBefore,
                'stock_after' => $stockAfter,
                'notes' => 'Stock received from supplier: ' . $shipment->supplier_name,
            ]);
        }
    });

    return redirect()
        ->route('admin.shipments.index')
        ->with('success', 'Shipment received and stock updated successfully!');
}

}