
@extends('dashboard.main')
@include('user.layouts.alert')
@section('content')
<div class="container py-5">
    <h2 class="mb-4">Order Management</h2>

    <form method="GET" action="{{ route('admin.orders.index') }}"
          class="row g-3 mb-4">

        <div class="col-md-5">
            <input type="text" name="search"
                   class="form-control"
                   placeholder="Search order or customer..."
                   value="{{ request('search') }}">
        </div>

        <div class="col-md-3">
            <select name="status" class="form-select">
                <option value="">All statuses</option>
                @foreach ([
                    'pending', 'confirmed', 'processing',
                    'shipped', 'delivered', 'completed', 'cancelled'
                ] as $status)
                    <option value="{{ $status }}"
                        @selected(request('status') === $status)>
                        {{ ucfirst($status) }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="col-md-2">
            <select name="sort" class="form-select">
                <option value="newest"
                    @selected(request('sort', 'newest') === 'newest')>
                    Newest
                </option>
                <option value="oldest"
                    @selected(request('sort') === 'oldest')>
                    Oldest
                </option>
                <option value="total_high"
                    @selected(request('sort') === 'total_high')>
                    Highest total
                </option>
                <option value="total_low"
                    @selected(request('sort') === 'total_low')>
                    Lowest total
                </option>
            </select>
        </div>

        <div class="col-md-2">
            <button class="btn btn-dark w-100">Apply</button>
        </div>
    </form>

    <div class="table-responsive">
        <table class="table table-bordered table-hover align-middle">
            <thead class="table-light">
                <tr>
                    <th>Order</th>
                    <th>Customer</th>
                    <th>Date</th>
                    <th>Total</th>
                    <th>Status</th>
                    <th>Update Status</th>
                    <th>Details</th>
                </tr>
            </thead>

            <tbody>
                @forelse ($orders as $order)
                    <tr>
                        <td>
                            {{ $order->order_number ?? $order->id }}
                        </td>

                        <td>
                            {{ $order->user->name ?? 'Unknown' }}
                            <br>
                            <small>
                                {{ $order->user->email ?? '' }}
                            </small>
                        </td>

                        <td>
                            {{ $order->created_at->format('d M Y') }}
                        </td>

                        <td>
                            {{ number_format($order->total, 2) }}
                        </td>

                        <td>
                            <span class="badge bg-secondary">
                                {{ ucfirst($order->status) }}
                            </span>
                        </td>

                        <td>
                            <form method="POST"
                                  action="{{ route('admin.orders.updateStatus', $order->id) }}">
                                @csrf
                                @method('PATCH')

                                <select name="status"
                                        class="form-select form-select-sm mb-2">
                                    @foreach ([
                                        'pending', 'confirmed', 'processing',
                                        'shipped', 'delivered', 'completed',
                                        'cancelled'
                                    ] as $status)
                                        <option value="{{ $status }}"
                                            @selected($order->status === $status)>
                                            {{ ucfirst($status) }}
                                        </option>
                                    @endforeach
                                </select>

                                <button class="btn btn-sm btn-primary">
                                    Save
                                </button>
                            </form>
                        </td>

                        <td>
                            <a href="{{ route('customer-orders.show', $order->id) }}"
                               class="btn btn-sm btn-outline-dark">
                                View
                            </a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="text-center">
                            No orders found.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{ $orders->links() }}
</div>

@endsection