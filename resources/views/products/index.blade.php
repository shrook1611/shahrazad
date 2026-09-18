@extends('dashboard.main')
@section('content')
    <div class="main-panel">
        <div class="content-wrapper">
            <div class="page-header">
                <h3 class="page-title"> Products </h3>
                <a href="{{ route('product.create') }}" class="btn btn-primary">Add Product</a>
            </div>
            <div class="row">
                <div class="col-lg-12 grid-margin stretch-card">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="card-title">products</h4>

                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>Name</th>
                                        <th>image</th>
                                        <th>description</th>
                                        <th>price</th>
                                        <th>category</th>
                                        <th>Created at</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($products as $product)
                                        
                                   
                                    <tr>
                                        <td>{{ $product->name }}</td>
                                        <td><img src="{{ asset('storage/' . $product->img) }}" alt="image"></td>
                                        <td>{{ $product->description }}</td>
                                        <td>${{ $product->price }}</td>
                                        <td>{{ $product->category->name }}</td>
                                        <td>{{ $product->created_at->format('d M Y') }}</td>
                                        <td>
                                            <a href="{{ route('product.edit', $product->id) }}" class="btn btn-sm btn-primary">Edit</a>
                                            <form action="{{ route('product.delete', $product->id) }}" method="POST" style="display: inline;">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure?')">Delete</button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
             
            </div>
        </div>
    @endsection
