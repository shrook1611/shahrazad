@extends('dashboard.main')
@section('content')
    <div class="col-8 grid-margin mx-auto stretch-card">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">All Orders</h4>
                <div class="table-responsive">

                    <table class="table">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>User</th>
                                <th>Product</th>
                                <th>Quantity</th>
                                <th>Total</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>

                        <tbody>
                            @foreach ($orders as $order)
                                @foreach ($order->orderitems as $item)
                              
                                    <tr>
                                        
                                        <td>{{ $item->product->id ?? '-' }}</td>
                                        <td>{{ $order->user->name ?? '-' }}</td>
                                        <td>{{ $item->product->name ?? '-' }}</td>
                                        <td>{{ $item->quantity }}</td>
                                        <td>{{ $order->total }}</td>
                                        <td>{{ $order->status }}</td>
                                        <td>
                                            <a href="{{ route('customer-orders.show', $order->id) }}" class="btn btn-sm btn-primary">View</a>
                                        </td>
                                    </tr>
                               
                                @endforeach
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
