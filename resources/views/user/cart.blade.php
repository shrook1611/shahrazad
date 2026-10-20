  <div class="offcanvas offcanvas-end" data-bs-scroll="true" tabindex="-1" id="offcanvasCart"
      aria-labelledby="My Cart">
      <div class="offcanvas-header justify-content-center">
          <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
      </div>
      <div class="offcanvas-body">
        @if($cart && $cart->cartitems->count() > 0)
          <div class="order-md-last">
              <h4 class="d-flex justify-content-between align-items-center mb-4">
                  <span class="text-primary">Your cart</span>
                  <span class="badge bg-primary rounded-circle pt-2">{{ $cart?->cartitems->count() ?? 0 }}</span>
              </h4>




              {{-- table test --}}



              <div class="row">
                  <div class="col-lg-8 grid-margin stretch-card">
                      <div class="card">
                          <div class="card-body">


                              <table class="table">
                                  <thead>
                                      <tr>
                                          <th>Name</th>
                                          <th>image</th>
                                          <th>Qnt</th>
                                          <th>price</th>

                                          <th>Actions</th>
                                      </tr>
                                  </thead>
                                  <tbody>
                                      @foreach ($cart->cartitems as $item)
                                          <tr>
                                              <td>{{ $item->product->name }}</td>
                                              <td><img class="img-fluid"
                                                      src="{{ asset('storage/' . $item->product->img) }}"
                                                      alt="image"></td>
                                              <td>{{ $item->quantity }}</td>
                                              <td>${{ $item->product->price * $item->quantity }}</td>

                                              <td>

                                                  <form action="#" method="POST" style="display: inline;">
                                                      @csrf
                                                      @method('DELETE')
                                                      <button type="submit" class="btn btn-sm text-danger fw-bold "
                                                          onclick="return confirm('Are you sure?')"><i
                                                              class="fa-solid fa-trash"></i></button>
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

















              <ul class="list-group mb-4">



                  <li class="list-group-item d-flex justify-content-between">
                      <span class="fw-bold">Total (USD)</span>
                      <strong>${{ $total }}</strong>
                  </li>
              </ul>
<form action="{{ route('checkout') }}" method="POST">
                @csrf
              <button class="w-100 btn btn-dark" type="submit">Continue to checkout</button>
            </form>
          </div>
          @else
              <div class="text-center"> 
                
                  <h4 class="text-primary text-uppercase mb-3">Your cart is empty</h4>
                  <p class="text-muted">Add items to your cart to see them here.</p>
              </div>
          @endif
      </div>
  </div>
