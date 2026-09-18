@extends('dashboard.main')
@section('content')
    <div class="col-8 grid-margin mx-auto stretch-card">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">create product</h4>

                <form class="forms-sample" action="{{ route('product.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="form-group">
                        <label for="exampleInputName1">Name</label>
                        <input type="text" class="form-control" id="exampleInputName1" placeholder="Name" name="name">
                    </div>
                    <div class="form-group">
                        <label for="exampleInputEmail3">price</label>
                        <input type="number" class="form-control" id="exampleInputEmail3" placeholder="price"
                            name="price">
                    </div>
                    <div class="form-group">
                        <label for="exampleInputEmail8">Stok</label>
                        <input type="number" class="form-control" id="exampleInputEmail8" placeholder="Stok"
                            name="stock">
                    </div>
                    <div class="form-group">
                        <label for="exampleInputPassword4">Description</label>
                        <textarea class="form-control" id="exampleInputPassword4" placeholder="Description" name="description"></textarea>
                    </div>
                    <div class="form-group">
                        <label for="exampleSelectGender">Category</label>
                        <select class="form-select" id="exampleSelectGender" name="category_id">
                            @foreach ($categories as $category)
                                <option value="{{ $category->id }}">
                                    {{ $category->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Image Upload</label>

                        <div class="input-group col-xs-12">
                            <input type="text" class="form-control" id="file-name" readonly placeholder="Upload Image">

                            <label for="image-upload" class="btn btn-gradient-primary py-3 mb-0">
                                Upload
                            </label>

                            <input type="file" name="img" id="image-upload" style="display: none;" accept="image/*">
                        </div>
                    </div>


                    <button type="submit" class="btn btn-gradient-primary me-2">Submit</button>
                    {{-- <button class="btn btn-light">Cancel</button> --}}
                </form>
            </div>
        </div>
    </div>
@endsection
@push('scripts')
    <script>
        document.getElementById('image-upload').addEventListener('change', function() {
            const fileName = this.files[0]?.name || '';
            document.getElementById('file-name').value = fileName;
        });
    </script>
@endpush
