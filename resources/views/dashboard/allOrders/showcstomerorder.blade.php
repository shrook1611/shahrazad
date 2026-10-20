@extends('dashboard.main')


@section('content')
    <div class="container py-5 col-md-6 shadow-2xl">

        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2>Order Details</h2>
            <a href="{{ route('dashboard') }}" class="btn btn-outline-dark">
                Back to Home
            </a>
        </div>

        <div class="card shadow-sm border-0 p-4 mb-4 bg-amber-50">
            <div class="row">
                <div class="col-md-6 mb-3">
                    <strong>Order Number:</strong>
                    <p>{{ $order->order_number ?? $order->id }}</p>
                </div>

                <div class="col-md-6 mb-3">
                    <strong>Order Date:</strong>
                    <p>{{ $order->created_at->format('d M Y, h:i A') }}</p>
                </div>

                <div class="col-md-6 mb-3">
                    <strong>Status:</strong>
                    <p>
                        <span class="badge bg-primary">
                            {{ ucfirst($order->status) }}
                        </span>
                    </p>
                </div>

                <div class="col-md-6 mb-3">
                    <strong>Payment Method:</strong>
                    <p>{{ strtoupper($order->payment_method ?? 'N/A') }}</p>
                </div>

                <div class="col-md-6 mb-3">
                    <strong>Payment Status:</strong>
                    <p>{{ ucfirst($order->payment_status ?? 'N/A') }}</p>
                </div>

                <div class="col-md-6 mb-3">
                    <strong>Phone:</strong>
                    <p>{{ $order->phone ?? 'N/A' }}</p>
                </div>

                <div class="col-12 mb-3">
                    <strong>Shipping Address:</strong>
                    <p>{{ $order->shipping_address ?? 'N/A' }}</p>
                </div>

                @if ($order->notes)
                    <div class="col-12">
                        <strong>Order Notes:</strong>
                        <p>{{ $order->notes }}</p>
                    </div>
                @endif
            </div>
        </div>

        <div class="card shadow-sm border-0 p-4">
            <h4 class="mb-3">Ordered Products</h4>

            <div class="table-responsive">
                <table class="table align-middle">
                    <thead>
                        <tr>
                            <th>Product</th>
                            <th>Image</th>
                            <th>Price</th>
                            <th>Quantity</th>
                            <th>Subtotal</th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach ($order->orderitems as $item)
                            <tr>
                                <td>{{ $item->product->name ?? 'Product unavailable' }}</td>
                                <td>
                                    @if ($item->product && $item->product->img)
                                        <img src="{{ asset('storage/' . $item->product->img) }}" alt="Product Image"
                                            class="img-fluid" style="max-width: 100px;">
                                    @else
                                        <span class="text-muted">No image</span>
                                    @endif
                                </td>
                                <td>{{ number_format($item->price, 2) }}</td>
                                <td>{{ $item->quantity }}</td>
                                <td>
                                    {{ number_format($item->price * $item->quantity, 2) }}
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <hr>

            <div class="ms-auto" style="max-width: 300px;">
                <div class="d-flex justify-content-between mb-2">
                    <span>Shipping Area</span>
                    <span> {{ $order->shippingArea->name ?? 'N/A' }}</span>
                </div>
                <div class="d-flex justify-content-between mb-2">
                    <span>Shipping Fee</span>
                    <span> {{ number_format($order->shipping_fee, 2) }}</span>
                </div>

                <div class="d-flex justify-content-between fw-bold fs-5">
                    <span>Total</span>
                    <span>{{ number_format($order->total, 2) }}</span>
                </div>
            </div>
        </div>

    </div>
@endsection
