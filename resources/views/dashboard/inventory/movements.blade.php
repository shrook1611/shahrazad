@extends('dashboard.main')
@section('content')


    <div class="container-fluid py-4">


        <div class="d-flex justify-content-between align-items-center mb-4 ">
            <div>
                <h2 class="mb-1">Stock Movement History</h2>
                <p class="text-muted mb-0">Track all inventory changes.</p>
            </div>
            <a href="{{ route('admin.shipments.index') }}" class="btn btn-outline-primary">
                <i class="fas fa-truck me-2"></i> Shipments
            </a>
            <a href="{{ route('admin.stock-adjustment.create') }}" class="btn btn-warning me-5">
                <i class="fas fa-sliders-h me-2"></i>
                Adjust Stock
            </a>
        </div>

        <div class="card shadow-sm">
            <div class="card-body">

                <form action="{{ route('admin.stock-movements.index') }}" method="GET" class="row g-3 mb-4">

                    <div class="col-md-3">
                        <label class="form-label">Product</label>
                        <select name="product_id" class="form-select">
                            <option value="">All Products</option>

                            @foreach ($products as $product)
                                <option value="{{ $product->id }}"
                                    {{ request('product_id') == $product->id ? 'selected' : '' }}>
                                    {{ $product->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-2">
                        <label class="form-label">Movement Type</label>
                        <select name="type" class="form-select">
                            <option value="">All Types</option>
                            <option value="shipment" {{ request('type') == 'shipment' ? 'selected' : '' }}>Shipment</option>
                            <option value="sale" {{ request('type') == 'sale' ? 'selected' : '' }}>Sale</option>
                            <option value="adjustment" {{ request('type') == 'adjustment' ? 'selected' : '' }}>Adjustment
                            </option>
                        </select>
                    </div>

                    <div class="col-md-2">
                        <label class="form-label">From Date</label>
                        <input type="date" name="date_from" value="{{ request('date_from') }}" class="form-control">
                    </div>

                    <div class="col-md-2">
                        <label class="form-label">To Date</label>
                        <input type="date" name="date_to" value="{{ request('date_to') }}" class="form-control">
                    </div>

                    <div class="col-md-3 d-flex align-items-end gap-2">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-filter me-1"></i> Filter
                        </button>

                        <a href="{{ route('admin.stock-movements.index') }}" class="btn btn-outline-secondary">
                            Reset
                        </a>
                    </div>
                </form>

                @if ($movements->isEmpty())
                    <div class="alert alert-info mb-0">
                        No stock movements recorded yet.
                    </div>
                @else
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover align-middle">
                            <thead class="table-light">
                                <tr>
                                    <th>#</th>
                                    <th>Date</th>
                                    <th>Product</th>
                                    <th>Movement Type</th>
                                    <th>Quantity</th>
                                    <th>Stock Before</th>
                                    <th>Stock After</th>
                                    <th>Supplier</th>
                                    <th>Notes</th>
                                </tr>
                            </thead>

                            <tbody>
                                @foreach ($movements as $movement)
                                    <tr>
                                        <td>{{ $movement->id }}</td>

                                        <td>
                                            {{ $movement->created_at->format('d M Y, h:i A') }}
                                        </td>

                                        <td>
                                            {{ $movement->product->name ?? 'Deleted product' }}
                                        </td>

                                        <td>
                                            @if ($movement->type === 'shipment')
                                                <span class="badge bg-success">Shipment</span>
                                            @elseif($movement->type === 'sale')
                                                <span class="badge bg-danger">Sale</span>
                                            @else
                                                <span class="badge bg-warning text-dark">
                                                    {{ ucfirst($movement->type) }}
                                                </span>
                                            @endif
                                        </td>

                                        <td>
                                            <span class="{{ $movement->quantity > 0 ? 'text-success' : 'text-danger' }}">
                                                {{ $movement->quantity > 0 ? '+' : '' }}{{ $movement->quantity }}
                                            </span>
                                        </td>

                                        <td>{{ $movement->stock_before }}</td>

                                        <td>
                                            <strong>{{ $movement->stock_after }}</strong>
                                        </td>

                                        <td>
                                            {{ $movement->shipment->supplier_name ?? '—' }}
                                        </td>

                                        <td>{{ $movement->notes ?? '—' }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <div class="mt-3">
                        {{ $movements->links() }}
                    </div>
                @endif

            </div>
        </div>


    </div>
@endsection
