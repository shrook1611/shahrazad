@include('user.layouts.header')

@include('user.layouts.alert')


<div class="container py-5">
    <h2 class="mb-4">Checkout</h2>

    @if (session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('createOrder') }}" method="POST">
        @csrf

        <div class="row g-4">
            {{-- Shipping Information --}}
            <div class="col-md-7">
                <div class="card shadow-sm border-0 p-4">
                    <h5 class="mb-3">Shipping Information</h5>

                    <div class="mb-3">
                        <label class="form-label">Full Name</label>
                        <input type="text" class="form-control" value="{{ auth()->user()->name }}" readonly>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Email</label>
                        <input type="email" class="form-control" value="{{ auth()->user()->email }}" readonly>
                    </div>

                    <div class="mb-3">
                        <label for="phone" class="form-label">Phone Number</label>
                        <input type="text" id="phone" name="phone" class="form-control"
                            value="{{ old('phone') }}" required>
                    </div>

                    <div class="mb-3">
                        <label for="shipping_address" class="form-label">
                            Shipping Address
                        </label>
                        <textarea id="shipping_address" name="shipping_address" class="form-control" rows="3" required>{{ old('shipping_address') }}</textarea>
                    </div>

                    <div class="mb-3">
                        <label for="notes" class="form-label">
                            Order Notes (Optional)
                        </label>
                        <textarea id="notes" name="notes" class="form-control" rows="2">{{ old('notes') }}</textarea>
                    </div>
                    <div class="mb-3">
                        <label for="shipping_area_id" class="form-label">
                            Shipping Area
                        </label>

                        <select name="shipping_area_id" id="shipping_area_id" class="form-select" required>
                            <option value="">Select your area</option>

                            @foreach ($shippingAreas as $area)
                                <option value="{{ $area->id }}"
                                    {{ old('shipping_area_id') == $area->id ? 'selected' : '' }}>
                                    {{ $area->name }} -
                                    {{ number_format($area->shipping_fee, 2) }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <h5 class="mt-3 mb-3">Payment Method</h5>

                    <div class="form-check border rounded p-3 ps-5 mb-2">
                        <input class="form-check-input" type="radio" name="payment_method" id="cod"
                            value="cod" checked>
                        <label class="form-check-label" for="cod">
                            Cash on Delivery
                        </label>
                    </div>

                    <button type="submit" class="btn btn-dark w-100 mt-3">
                        Place Order
                    </button>
                </div>
            </div>

            {{-- Order Summary --}}
            <div class="col-md-5">
                <div class="card shadow-sm border-0 p-4">
                    <h5 class="mb-3">Your Order</h5>

                    @foreach ($cart->cartitems as $item)
                        <div class="d-flex justify-content-between gap-3 mb-3">
                            <div>
                                <div>{{ $item->product->name }}</div>
                                <small class="text-muted">
                                    Quantity: {{ $item->quantity }}
                                </small>
                            </div>

                            <span class="text-nowrap">
                                {{ number_format($item->product->price * $item->quantity, 2) }}
                            </span>
                        </div>
                    @endforeach

                    <hr>

                    <div class="d-flex justify-content-between mb-2">
                        <span>Subtotal</span>
                        <span>{{ number_format($subtotal, 2) }}</span>
                    </div>

                    <div class="d-flex justify-content-between mb-2">
                        <span>Shipping</span>
                        <span>{{ number_format($shippingFee, 2) }}</span>
                    </div>

                    <hr>

                    <div class="d-flex justify-content-between fw-bold fs-5">
                        <span>Total</span>
                        <span>
                            {{ number_format($subtotal + $shippingFee, 2) }}
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>
