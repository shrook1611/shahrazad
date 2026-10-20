<section id="new-arrival" class="product-store">
    <div class="container padding-medium" data-aos="fade-up">
        <h2 class="display-5 fw-light text-uppercase text-center">New Arrivals</h2>
        <p class="text-center mb-4">Browse our brand new collections</p>
        <div class="row">
            @foreach ($newproducts as $product)
                <div class="col-md-6 col-lg-3 my-4">
                    <div class="product-item">
                       <div class="product-item position-relative">
                        @if($product->stock !== 0 && $product->created_at->diffInDays(now()) <= 30)
                        <div class="z-1 position-absolute rounded-3 m-3 px-3 py-0 fs-6 bg-primary text-white">
                            New
                        </div>
                        @else
                        <div class="z-1 position-absolute rounded-3 m-3 px-3 py-0 fs-6 bg-danger text-white">
                            sold
                        </div>
                        @endif

                        <div class="image-holder" style="width: 100%; height: 100%;">
                            <img src="{{ $product->img }}" alt="Books" class="product-image img-fluid">
                        </div>
                        <div class="cart-concern">
                            <div class="cart-button d-flex justify-content-between align-items-center">
                                <form action="{{ route('addToCart', $product->id) }}" method="POST">
                                    @csrf
                                <button type='submit' 
                                    class="btn-wrap cart-link d-flex align-items-center text-capitalize fs-6 ">add to
                                    cart <i class="icon icon-arrow-io pe-1"></i>
                                </button>
                                </form>
                                <a href="single-product.html" class="view-btn mt-1">
                                    <i class="icon icon-screen-full"></i>
                                </a>
                                <a href="#" class="wishlist-btn mt-1">
                                    <i class="icon icon-heart"></i>
                                </a>
                            </div>
                        </div>
                        <div class="product-detail d-flex justify-content-between align-items-center mt-2">
                            <a href="single-product.html">
                                <h5 class="product-title mb-0">
                                    {{ $product->name }}
                                </h5>
                            </a>
                            <p class="m-0 fs-5 fw-normal">${{ number_format($product->price, 2) }}</p>
                        </div>
                    </div>
                    </div>
                </div>
            @endforeach


        </div>
        <div class="text-center mt-5 pt-4">
            <a href="{{ route('allproducts') }}" type="submit" class="btn btn-primary">View All Products</a>
        </div>
    </div>
</section>
