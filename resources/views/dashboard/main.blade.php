@include('dashboard.layouts.head')
@include('dashboard.layouts.navbar')

    <!-- partial -->
  @yield('content')
      @stack('scripts')
    <!-- macoin-panel ends -->
</div>
<!-- page-body-wrapper ends -->
</div>
@include('dashboard.layouts.footer')