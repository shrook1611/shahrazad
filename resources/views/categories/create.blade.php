@extends('dashboard.main')
@section('content')
    <div class="col-8 grid-margin mx-auto stretch-card">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">create category</h4>

                <form class="forms-sample" action="{{ route('category.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="form-group">
                        <label for="exampleInputName1">Name</label>
                        <input type="text" class="form-control" id="exampleInputName1" placeholder="Name" name="name">
                    </div>
            

                    <button type="submit" class="btn btn-gradient-primary me-2">Submit</button>
                    {{-- <button class="btn btn-light">Cancel</button> --}}
                </form>
            </div>
        </div>
    </div>
@endsection

