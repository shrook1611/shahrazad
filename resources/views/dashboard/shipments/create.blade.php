@extends('dashboard.main')
@section('content')
    <div class="container py-5">

        <!-- Page Header -->
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h2 class="fw-bold mb-1">Receive New Shipment</h2>
                <p class="text-muted mb-0">
                    Add incoming products and update your inventory.
                </p>
            </div>

            <a href="{{ route('admin.shipments.index') }}" class="btn btn-outline-secondary">
                <i class="fas fa-arrow-left me-2"></i>
                Back to Shipments
            </a>
        </div>

        <form action="{{ route('admin.shipments.store') }}" method="POST">
            @csrf

            <!-- Shipment Information -->
            <div class="card border-0 shadow-sm rounded-3 mb-4">
                <div class="card-header bg-white py-3">
                    <h5 class="fw-bold mb-0">
                        <i class="fas fa-truck me-2 text-primary"></i>
                        Shipment Information
                    </h5>
                </div>

                <div class="card-body p-4">
                    <div class="row g-3">

                        <div class="col-md-6">
                            <label class="form-label fw-semibold">
                                Supplier Name <span class="text-danger">*</span>
                            </label>

                            <input type="text" name="supplier_name" class="form-control"
                                value="{{ old('supplier_name') }}" placeholder="Enter supplier name" required>

                            @error('supplier_name')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        <div class="col-md-6">
                            <label class="form-label fw-semibold">
                                Reference / Invoice Number
                            </label>

                            <input type="text" name="reference_number" class="form-control"
                                value="{{ old('reference_number') }}" placeholder="e.g. INV-001">
                        </div>

                        <div class="col-md-6">
                            <label class="form-label fw-semibold">
                                Received Date <span class="text-danger">*</span>
                            </label>

                            <input type="date" name="received_at" class="form-control"
                                value="{{ old('received_at', now()->toDateString()) }}" required>

                            @error('received_at')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        <div class="col-12">
                            <label class="form-label fw-semibold">Notes</label>

                            <textarea name="notes" class="form-control" rows="3" placeholder="Additional shipment details...">{{ old('notes') }}</textarea>
                        </div>

                    </div>
                </div>
            </div>

            <!-- Products -->
            <div class="card border-0 shadow-sm rounded-3 mb-4">

                <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
                    <h5 class="fw-bold mb-0">
                        <i class="fas fa-boxes me-2 text-primary"></i>
                        Shipment Products
                    </h5>

                    <button type="button" class="btn btn-primary btn-sm" id="add-product">
                        <i class="fas fa-plus me-1"></i>
                        Add Product
                    </button>
                </div>

                <div class="card-body p-4">

                    <div class="row text-muted small fw-semibold mb-2 d-none d-md-flex">
                        <div class="col-md-5">PRODUCT</div>
                        <div class="col-md-3">QUANTITY</div>
                        <div class="col-md-3">UNIT COST</div>
                        <div class="col-md-1"></div>
                    </div>

                    <div id="products-container">

                        <!-- First product row -->
                        <div class="row g-2 align-items-end mb-3 product-row">

                            <div class="col-md-5">
                                <label class="form-label fw-semibold d-md-none">
                                    Product
                                </label>

                                <select name="items[0][product_id]" class="form-select" required>
                                    <option value="">Select Product</option>

                                    @foreach ($products as $product)
                                        <option value="{{ $product->id }}"
                                            {{ old('items.0.product_id') == $product->id ? 'selected' : '' }}>
                                            {{ $product->name }}
                                            (Stock: {{ $product->stock }})
                                        </option>
                                    @endforeach
                                </select>

                                @error('items.0.product_id')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>

                            <div class="col-md-3">
                                <label class="form-label fw-semibold d-md-none">
                                    Quantity
                                </label>

                                <input type="number" name="items[0][quantity]" class="form-control" placeholder="Quantity"
                                    value="{{ old('items.0.quantity') }}" min="1" required>
                            </div>

                            <div class="col-md-3">
                                <label class="form-label fw-semibold d-md-none">
                                    Unit Cost
                                </label>

                                <input type="number" name="items[0][unit_cost]" class="form-control"
                                    placeholder="Unit cost" value="{{ old('items.0.unit_cost') }}" min="0"
                                    step="0.01">
                            </div>

                            <div class="col-md-1">
                                <button type="button" class="btn btn-outline-danger w-100 remove-product"
                                    title="Remove product" disabled>
                                    <i class="fas fa-trash"></i>
                                </button>
                            </div>

                        </div>

                    </div>

                    <div class="text-muted small mt-3">
                        <i class="fas fa-info-circle me-1"></i>
                        You can add multiple existing products to one shipment.
                    </div>

                </div>
            </div>

            <!-- Submit -->
            <div class="d-flex justify-content-end gap-2">

                <a href="{{ route('admin.shipments.index') }}" class="btn btn-light border px-4">
                    Cancel
                </a>

                <button type="submit" class="btn btn-success px-4">
                    <i class="fas fa-check me-2"></i>
                    Receive Shipment
                </button>

            </div>

        </form>
    </div>

    <!-- Product Row Template -->
    <template id="product-template">
        <div class="row g-2 align-items-end mb-3 product-row">

            <div class="col-md-5">
                <label class="form-label fw-semibold d-md-none">Product</label>

                <select class="form-select product-select" required>
                    <option value="">Select Product</option>

                    @foreach ($products as $product)
                        <option value="{{ $product->id }}">
                            {{ $product->name }}
                            (Stock: {{ $product->stock }})
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="col-md-3">
                <label class="form-label fw-semibold d-md-none">Quantity</label>

                <input type="number" class="form-control quantity-input" placeholder="Quantity" min="1"
                    required>
            </div>

            <div class="col-md-3">
                <label class="form-label fw-semibold d-md-none">Unit Cost</label>

                <input type="number" class="form-control cost-input" placeholder="Unit cost" min="0"
                    step="0.01">
            </div>

            <div class="col-md-1">
                <button type="button" class="btn btn-outline-danger w-100 remove-product" title="Remove product">
                    <i class="fas fa-trash"></i>
                </button>
            </div>

        </div>
    </template>

    <script>
        let productIndex = 1;

        const container = document.getElementById('products-container');
        const template = document.getElementById('product-template');

        document.getElementById('add-product').addEventListener('click', function() {

            const clone = template.content.cloneNode(true);

            clone.querySelector('.product-select').name =
                `items[${productIndex}][product_id]`;

            clone.querySelector('.quantity-input').name =
                `items[${productIndex}][quantity]`;

            clone.querySelector('.cost-input').name =
                `items[${productIndex}][unit_cost]`;

            container.appendChild(clone);

            productIndex++;
            updateRemoveButtons();
        });

        container.addEventListener('click', function(event) {

            const button = event.target.closest('.remove-product');

            if (!button) return;

            button.closest('.product-row').remove();

            updateRemoveButtons();
        });

        function updateRemoveButtons() {

            const rows = container.querySelectorAll('.product-row');

            rows.forEach(row => {
                row.querySelector('.remove-product').disabled = rows.length === 1;
            });
        }
    </script>
@endsection
