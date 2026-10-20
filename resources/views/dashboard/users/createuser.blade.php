@extends('dashboard.main')
@section('content')
    <div class="col-8 grid-margin mx-auto stretch-card">
        @if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">create user</h4>

                <form class="forms-sample" action="{{ route('users.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="form-group">
                        <label for="exampleInputName1">Name</label>
                        <input type="text" class="form-control" id="exampleInputName1" placeholder="Name" name="name">
                    </div>
                    <div class="form-group">
                        <label for="exampleInputEmail3">Email</label>
                        <input type="email" class="form-control" id="exampleInputEmail3" placeholder="Email" name="email">
                    </div>
                    <div class="form-group">
                        <label for="exampleInputEmail8">Address</label>
                        <input type="text" class="form-control" id="exampleInputEmail8" placeholder="Address"
                            name="address">
                    </div>
                    <div class="form-group">
                        <label for="exampleInputPassword4">Phone</label>
                        <input type="tel" class="form-control" id="exampleInputPassword4" placeholder="Phone" name="phone">
                    </div>
                    <div class="form-group">
                        <label for="exampleSelectGender">Role</label>
                        <select class="form-select" id="exampleSelectGender" name="role">
                            <option value="user">User</option>
                            <option value="admin">Admin</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="exampleInputPassword4">Password</label>
                        <input type="password" class="form-control" id="exampleInputPassword4" placeholder="Password"
                            name="password">
                    </div>

                    <button type="submit" class="btn btn-gradient-primary me-2">Submit</button>
                    
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
