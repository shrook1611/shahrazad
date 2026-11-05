@extends('dashboard.main')
@section('content')


@include('user.layouts.alert')

<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>Inventory Shipments</h2>

        <a href="{{ route('admin.shipments.create') }}"
           class="btn btn-primary">
            Add New Shipment
        </a>
    </div>

    @if ($shipments->isEmpty())
        <div class="alert alert-info">
            No shipments have been recorded yet.
        </div>
    @else
        <div class="table-responsive">
            <table class="table table-bordered table-striped align-middle">
                <thead>
                    <tr>
                        <th>Shipment ID</th>
                        <th>Supplier</th>
                        <th>Reference</th>
                        <th>Received Date</th>
                        <th>Products</th>
                        <th>Notes</th>
                    </tr>
                </thead>

                <tbody>
                    @foreach ($shipments as $shipment)
                        <tr>
                            <td>{{ $shipment->id }}</td>
                            <td>{{ $shipment->supplier_name }}</td>
                            <td>{{ $shipment->reference_number ?? '—' }}</td>
                            <td>
                                {{ $shipment->received_at->format('d M Y') }}
                            </td>
                            <td>
                                {{ $shipment->items->count() }}
                            </td>
                            <td>{{ $shipment->notes ?? '—' }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        {{ $shipments->links() }}
    @endif
</div>

@endsection