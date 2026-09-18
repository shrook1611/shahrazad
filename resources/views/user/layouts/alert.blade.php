<style>
.toast {
  position: fixed;  right: 20px;
bottom: 20px;
  z-index: 9999;
}
</style>







@if(session('success'))
<div class="alert alert-success alert-dismissible fade show toast" role="alert">
  <strong>{{session('success')}}</strong> 
 
</div>
@endif


@if($errors->any())
<div class="alert alert-danger alert-dismissible fade show toast" role="alert">
  <ul>
    @foreach($errors->all() as $error)
    <li>{{$error}}</li>
    @endforeach
  </ul>
 
</div>
@endif