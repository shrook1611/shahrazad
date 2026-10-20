<style>
.toast {
  position: fixed;  right: 20px;
bottom: 20px;
  z-index: 9999;
    transition: opacity 0.5s ease;

}
</style>


<script>
    setTimeout(function () {
        const toast = document.querySelector('.toast');

        if (toast) {
            toast.style.opacity = '0';

            setTimeout(function () {
                toast.remove();
            }, 500);
        }
    }, 3000);
</script>




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