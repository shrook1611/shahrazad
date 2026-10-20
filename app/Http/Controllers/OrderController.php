<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\order;
use App\Models\ShippingArea;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

class OrderController extends Controller
{
    // public function createOrder()
    // {
    //     try {
    //         DB::beginTransaction();
    //         $cart = Cart::with('cartitems.product')->where('user_id', auth()->user()->id)->first();

    //         $total = $cart->cartitems->sum(fn($cartitem) => $cartitem->TotalPrice);

    //         $order = order::create([

    //             'user_id' => auth()->user()->id,
    //             'total' => $total,
    //         ]);
    //         foreach ($cart->cartitems as $cartitem) {
    //             $order->orderitems()->create([
    //                 'product_id' => $cartitem->product_id,
    //                 'quantity' => $cartitem->quantity,
    //                 'price' => $cartitem->product->price,
    //             ]);
    //         }

    //         $cart->cartitems()->delete();
    //         DB::commit();

    //         return redirect()->route('home')->with('success', 'Order created successfully');
    //     } catch (\Exception $e) {
    //         DB::rollBack();
    //          dd($e->getMessage());
    //         return redirect()->route('home')->with('error', 'Failed to create order: ' . $e->getMessage());
    //     }
    // }


    public function createOrder(Request $request)
    {
        $validated = $request->validate([
            'phone' => 'required|string|max:20',
            'shipping_address' => 'required|string|max:1000',
            'notes' => 'nullable|string|max:1000',
            'payment_method' => 'required|in:cod',
            'shipping_area_id' => [
                'required',
                'exists:shipping_areas,id',
            ],
        ]);

        try {
            $order = DB::transaction(function () use ($validated) {

                $area = ShippingArea::where('is_active', true)
                    ->find($validated['shipping_area_id']);

                if (!$area) {
                    throw ValidationException::withMessages([
                        'shipping_area_id' => 'Please select a valid shipping area.',
                    ]);
                }

                $cart = Cart::where('user_id', auth()->id())
                    ->with('cartitems.product')
                    ->lockForUpdate()
                    ->first();

                if (!$cart || $cart->cartitems->isEmpty()) {
                    throw ValidationException::withMessages([
                        'cart' => 'Your cart is empty.',
                    ]);
                }

                $subtotal = 0;

                foreach ($cart->cartitems as $item) {
                    if (!$item->product) {
                        throw ValidationException::withMessages([
                            'cart' => 'A product in your cart is unavailable.',
                        ]);
                    }

                    $subtotal += $item->product->price * $item->quantity;
                }

                $shippingFee = $area->shipping_fee;

                $order = order::create([
                    'user_id' => auth()->id(),
                    'order_number' => 'SHZ-' . Str::upper(Str::random(12)),
                    'total' => $subtotal + $shippingFee,
                    'shipping_fee' => $shippingFee,
                    'shipping_area_id' => $area->id,
                    'status' => 'pending',
                    'payment_method' => $validated['payment_method'],
                    'payment_status' => 'unpaid',
                    'phone' => $validated['phone'],
                    'shipping_address' => $validated['shipping_address'],
                    'notes' => $validated['notes'] ?? null,
                ]);

                foreach ($cart->cartitems as $item) {
                    $order->orderitems()->create([
                        'product_id' => $item->product_id,
                        'quantity' => $item->quantity,
                        'price' => $item->product->price,
                    ]);
                }

                $cart->cartitems()->delete();

                return $order;
            });

            return redirect()
                ->route('orders.show', $order->id)
                ->with('success', 'Order placed successfully!');
        } catch (ValidationException $e) {
            throw $e;
        } catch (\Throwable $e) {
            report($e);

            return redirect()->back()
                ->withInput()
                ->with('error', 'Unable to place your order. Please try again.');
        }
    }

    public function index()
    {
        $orders = order::with('orderitems.product')->get();
        $userOrders = order::with('orderitems.product')->where('user_id', auth()->user()->id)->get();
        return view('dashboard.allOrders.allorders', compact('userOrders', 'orders'));
    }


    public function checkout()
    {
        $cart = Cart::where('user_id', auth()->id())
            ->with('cartitems.product')
            ->first();

        if (!$cart || $cart->cartitems->isEmpty()) {
            return redirect()->back()
                ->with('error', 'Your cart is empty.');
        }

        $subtotal = $cart->cartitems->sum(function ($item) {
            return $item->product
                ? $item->product->price * $item->quantity
                : 0;
        });
        $order = order::with([
            'orderitems.product',
            'shippingArea'
        ])
            ->where('user_id', auth()->id())
            ->get();
        $shippingFee = 0;

        $shippingAreas = ShippingArea::where('is_active', true)
            ->orderBy('name')
            ->get();

        return view('user.checkout.index', compact(
            'cart',
            'subtotal',
            'shippingFee',
            'shippingAreas',
            'order'

        ));
    }
    public function show($id)
    {
        $cart = Cart::with('cartitems.product')->where('user_id', auth()->user()->id)->first();


        $order = order::with([
            'orderitems.product',
            'shippingArea'
        ])
            ->where('user_id', auth()->id())
            ->findOrFail($id);
        return view('user.orders.show', compact('order', 'cart'));
    }
    public function showCustomerOrder($id)
    {
        $cart = Cart::with('cartitems.product')->where('user_id', auth()->user()->id)->first();



        $order = order::with([
            'orderitems.product',
            'shippingArea'
        ])
            ->where('user_id', auth()->id())
            ->findOrFail($id);
        return view('dashboard.allOrders.showcstomerorder', compact('order', 'cart'));
    }


public function adminIndex(Request $request)
{
    abort_unless(auth()->user()->role === 'admin', 403);

    $query = order::with('user');

    // Filter by order status
    if ($request->filled('status')) {
        $query->where('status', $request->status);
    }

    // Search by order number or customer name/email
    if ($request->filled('search')) {
        $search = $request->search;

        $query->where(function ($q) use ($search) {
            $q->where('order_number', 'like', "%{$search}%")
                ->orWhereHas('user', function ($userQuery) use ($search) {
                    $userQuery->where('name', 'like', "%{$search}%")
                        ->orWhere('email', 'like', "%{$search}%");
                });
        });
    }

    // Sort orders
    $sort = $request->get('sort', 'newest');

    if ($sort === 'oldest') {
        $query->orderBy('created_at', 'asc');
    } elseif ($sort === 'total_high') {
        $query->orderBy('total', 'desc');
    } elseif ($sort === 'total_low') {
        $query->orderBy('total', 'asc');
    } else {
        $query->orderBy('created_at', 'desc');
    }

    $orders = $query->paginate(15)->withQueryString();

    return view('dashboard.allOrders.orders', compact('orders'));
}



public function updateStatus(Request $request, $id)
{
    abort_unless(auth()->user()->role === 'admin', 403);

    $validated = $request->validate([
        'status' => [
            'required',
            'in:pending,confirmed,processing,shipped,delivered,completed,cancelled',
        ],
    ]);

    $order = order::findOrFail($id);

    $order->update([
        'status' => $validated['status'],
    ]);

    return redirect()->back()
        ->with('success', 'Order status updated successfully.');
}


public function myOrders()
{
    $orders = order::where('user_id', auth()->id())
        ->orderByDesc('created_at')
        ->paginate(10);

    return view('user.orders.history', compact('orders'));
}











}
