<section class="py-md-5 bg-soft-primary">
    <div class="container py-8 py-md-5">
        <div class="row">
            <div class="col-lg-12">
                @if($order->isPaymentFailed())
                    <div class="alert alert-danger" role="alert">
                        <h4 class="alert-heading"><i class="las la-sad-tear"></i> Oppss! </h4>
                        <p>Due to Some Unknown Reason we cant Placed your Order..</p>
                        <hr>
                        <p class="mb-0">Your order was not placed successfully please try again.</p>
                    </div>
                @else
                    @if($order->isPaymentAuthorise())
                        <div class="alert alert-success" role="alert">
                            <h4 class="alert-heading"><i class="las la-sad-tear"></i>Order Pending!</h4>
                            <p>Aww yeah, Your order has been Requested Successfully!</p>
                            <hr>
                            <p class="mb-0">Thank You for placing order with us!!!</p>
                        </div>
                    @else
                        <div class="alert alert-success" role="alert">
                            <h4 class="alert-heading"><i class="las la-sad-tear"></i>Well done!</h4>
                            <p>Aww yeah, Order Placed Successfully</p>
                            <hr>
                            <p class="mb-0">Thank You for placing order with us!!!</p>
                        </div>
                    @endif
                @endif
            </div>
        </div>
    </div>
</section>
<section class="py-6 py-md-10 mb-md-14">
    <div class="container py-14 py-md-14">
        <div class="row">
            <div class="col-12 col-md-7">
                <ul class="list-group list-group-lg list-group-flush-x mb-6 list-unstyled">
                    @foreach($order->products()->with('product.media')->get() as $product)
                        <li class="list-group-item" id="productRow_{{ $product->id }}">
                            <input type="hidden" name="proId[]" value="{{ $product->id }}">
                            <div class="row align-items-center">
                                <div class="col-3">
                                    <img
                                        src="{{ $product->product->getFirstMediaUrl(\App\Models\Product::MC_PRODUCT_IMAGE) }}"
                                        alt="{{ $product->name }}" class="img-fluid"/>
                                </div>
                                <div class="col">
                                    <div class="d-flex mb-2 font-weight-bold">
                                        <a class="text-dark" href="javascript:void(0)">
                                            {{ $product->product->name }}
                                        </a>
                                        <span
                                            class="ml-auto text-danger font-weight-600">र {{ round($product->dp, 2) }}</span>
                                    </div>
                                    <p class="mb-7 font-size-sm text-muted">
                                        <span>Price: <span
                                                class="text-primary">र {{ round($product->dp,2) }}</span></span><br>
                                        <span>BV: <span class="text-success">{{ round($product->bv,2) }}</span></span>
                                        <br>
                                        Product Quantity: {{ $product->quantity}}
                                    </p>
                                </div>
                            </div>
                        </li>
                    @endforeach
                </ul>
            </div>
            <div class="col-12 col-md-5 col-lg-4">
                <div class="card mb-7 bg-soft-primary">
                    <div class="card-body">
                        <ul class="list-group list-group-sm list-group-flush-y list-group-flush-x">
                            <li class="list-group-item d-flex">
                                <span>Subtotal</span>
                                <span class="ml-auto font-size-sm">
                                    र {{ round($order->total, 2) }}
                                </span>
                            </li>
                            <li class="list-group-item d-flex">
                                <span>Total BV</span>
                                <span class="ml-auto font-size-sm">
                                     {{ round($order->total_bv, 2) }} BV
                                </span>
                            </li>
                            <li class="list-group-item d-flex font-weight-600 text-danger">
                                <span>Total</span>
                                <span class="ml-auto font-size-sm">
                                    र {{ round($order->total, 2) }}
                                </span>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
