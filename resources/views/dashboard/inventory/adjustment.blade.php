@extends('dashboard.main')
@section('content')


<div class="container py-4">


<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h2>Manual Stock Adjustment</h2>
        <p class="text-muted mb-0">
            Increase or decrease product stock and record the reason.
        </p>
    </div>

    <a href="{{ route('admin.stock-movements.index') }}"
       class="btn btn-outline-secondary">
        <i class="fas fa-arrow-left me-2"></i> Back to History
    </a>
</div>

<div class="card shadow-sm">
    <div class="card-body">

        <form action="{{ route('admin.stock-adjustment.store') }}"
              method="POST">
            @csrf

            <div class="mb-3">
                <label class="form-label">Select Product</label>

                <select name="product_id"
                        class="form-select @error('product_id') is-invalid @enderror"
                        required>
                    <option value="">Choose a product</option>

                    @foreach($products as $product)
                        <option value="{{ $product->id }}"
                            {{ old('product_id') == $product->id ? 'selected' : '' }}>
                            {{ $product->name }} — Current Stock: {{ $product->stock }}
                        </option>
                    @endforeach
                </select>

                @error('product_id')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label class="form-label">Adjustment Type</label>

                <select name="direction"
                        class="form-select @error('direction') is-invalid @enderror"
                        required>
                    <option value="">Choose adjustment type</option>
                    <option value="increase" {{ old('direction') == 'increase' ? 'selected' : '' }}>
                        Increase Stock
                    </option>
                    <option value="decrease" {{ old('direction') == 'decrease' ? 'selected' : '' }}>
                        Decrease Stock
                    </option>
                </select>

                @error('direction')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label class="form-label">Quantity</label>

                <input type="number"
                       name="quantity"
                       min="1"
                       value="{{ old('quantity') }}"
                       class="form-control @error('quantity') is-invalid @enderror"
                       required>

                @error('quantity')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label class="form-label">Reason / Notes</label>

                <textarea name="notes"
                          rows="4"
                          class="form-control @error('notes') is-invalid @enderror"
                          placeholder="Example: 3 products damaged during storage..."
                          required>{{ old('notes') }}</textarea>

                @error('notes')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <button type="submit" class="btn btn-primary">
                <i class="fas fa-save me-2"></i>
                Save Adjustment
            </button>

        </form>

    </div>
</div>


</div>

@endsection