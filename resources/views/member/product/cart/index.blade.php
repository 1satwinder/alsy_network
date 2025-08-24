@extends('website.layouts.master')
@section('title',':: Shopping Cart | '.settings('company_name').' ::')

@section('content')
    <section class="breadcrumb_area">
        <img class="breadcrumb_shap" src="{{ asset('images/banner_bg.png') }}" alt="">
        <div class="container">
            <div class="breadcrumb_content text-center">
                <h1 class="f_p f_700 f_size_50 w_color l_height50 mb_20">Shopping Cart</h1>
            </div>
        </div>
    </section>
    @if(!count($cartProducts) > 0)
        <section class="error_two_area">
            <div class="container flex">
                <div class="error_content_two text-center">
                    <h2>YOUR CART IS EMPTY</h2>
                    <p>Sorry Mate... No Item Found Inside Your Cart!</p>
                    <a onclick="history.back()" class="about_btn btn_hover">Back to Page <i class="arrow_right"></i></a>
                </div>
            </div>
        </section>
    @else
        <section class="bg-light-gray">
            <div class="container">
                <div class="cart-section">
                    @foreach($cartProducts as $product)
                        <div class="cartBlock" id="productRow_{{ $product->id }}">
                            <input type="hidden" name="proId[]" value="{{ $product->id }}">
                            <div class="row">
                                <div class="col-lg-2 col-3 text-center">
                                    <div class="cartImg">
                                        <a href="javascript:void(0)">
                                            <img src="{{ $product->imageUrl }}" alt="{{ $product->name }}"
                                                 class="img-fluid"/>
                                            <div class="flash">
                                                <span class="onnew">{{ round($product->bv,2) }} BV</span>
                                            </div>
                                        </a>
                                    </div>
                                </div>
                                <div class="col-lg-6 col-9">
                                    <div class="cartInfo">
                                        <h4>
                                            {{ $product->name }}
                                        </h4>
                                        <div class="price-box mb-2">
                                            <span class="main-price">र {{ round($product->mrp, 2) }}</span>
                                            <span class="discounted-price">र {{ round($product->dp, 2) }}</span>
                                        </div>
                                        @if($product->shipping_charge)
                                            <p class="CartDeliver" id="shippingChargeRow_{{ $product->id }}">
                                                <i class='bx bxs-truck' ></i> Deliver Charge :
                                                र {{ round($product->shipping_charge, 2) }}
                                            </p>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-lg-2 col-6 text-center">
                                    <div class="pro-quantity">
                                        <div class="input-group">
                                    <span class="input-group-btn">
                                        <button type="button" class="btn btn-default btn-number" data-type="minus"
                                                onclick="decreaseProductQuantity({{ $product->id }});">
                                            <span class="bx bx-minus"></span>
                                        </button>
                                    </span>
                                            <input type="text" name="quant[{{ $product->id }}]"
                                                   class="form-control input-number text-center"
                                                   data-quantity="{{ $product->quantity }}"
                                                   data-value="{{ round($product->ep, 2) }}"
                                                   value="{{ $product->quantity }}" id="product_{{ $product->id }}"
                                                   disabled>
                                            <span class="input-group-btn">
                                        <button type="button" class="btn btn-default btn-number" data-type="plus"
                                                onclick="increaseProductQuantity({{ $product->id}});">
                                            <span class="bx bx-plus"></span>
                                        </button>
                                    </span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-2 col-6 text-right">
                                    <a href="JavaScript:void(0);"
                                       data-shipping="{{ round($product->shipping_charge, 2) }}"
                                       data-subTotal="{{ round($product->subTotal, 2) }}"
                                       data-total="{{ round($product->total) }}"
                                       id="removeProduct_{{ $product->id }}"
                                       onclick="removeFromCart({{ $product->id}});" class="text-danger font-weight-600">
                                        <i class="bx bx-trash"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                    <form action="{{ route('website.orders.store') }}" method="POST" class="filePondForm"
                          onsubmit="ordersButton.disabled = true; return true;">
                        @csrf
                        <div class="row">
                            <div class="col-lg-8 col-12 pad-r">
                                <div class="bg-white p-3 mt-4 mt-lg-0 rounded">
                                    <h4 class="header-title mb-3">Delivery Address</h4>
                                    <div class="row d-flex mb-4">
                                        <div class="col-6">
                                            <div class="custom-control custom-radio">
                                                <input type="radio" id="left" value="1"
                                                       name="payment_type"
                                                       {{ old('payment_type') == 1 ? 'checked' : '' }}
                                                       onclick="deliveredType(1)"
                                                       class="custom-control-input">
                                                <label class="custom-control-label" for="left">
                                                    Fund Wallet <b
                                                        class="text-danger">(Balance: {{ Auth::user()->member->fund_wallet_balance }}
                                                        )</b>
                                                </label>
                                            </div>
                                        </div>
                                        @if(env('PAYTM_MERCHANT_ID'))
                                            <div class="col-3">
                                                <div class="custom-control custom-radio">
                                                    <input type="radio" id="right" value="2"
                                                           onclick="deliveredType(2)"
                                                           name="payment_type"
                                                           {{ old('payment_type') == 2 ? 'checked' : '' }} class="custom-control-input">
                                                    <label class="custom-control-label" for="right">Paytm</label>
                                                </div>
                                            </div>
                                        @endif
                                        <div class="col-6">
                                            @foreach($errors->get('payment_type') as $error)
                                                <span class="error">{{ $error }}</span>
                                            @endforeach
                                        </div>
                                    </div>
                                    <div class="row">
                                        {{--                                <div class="form-group col-lg-6 col-12 mb-3" id="check_wallet_amount">--}}
                                        {{--                                    <label>Member ID</label>--}}
                                        {{--                                    <input class="form-control memberCodeInput" type="text"--}}
                                        {{--                                           placeholder="Enter Member ID" name="code" value="" autocomplete="off"--}}
                                        {{--                                           required="">--}}
                                        {{--                                    <div class="memberName font-weight-bold text-danger">Member not found</div>--}}
                                        {{--                                </div>--}}
                                        <div class="form-group col-lg-6 col-12 mb-3" id="check_wallet_amount">
                                            <label>Transaction Password <span class="text-danger">*</span></label>
                                            <input type="password" name="financial_password"
                                                   placeholder="Enter Transaction Password"
                                                   class="form-control financial_password">
                                            @foreach($errors->get('financial_password') as $error)
                                                <span class="text-danger">{{ $error }}</span>
                                            @endforeach
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="form-group col-lg-6 col-12 mb-3">
                                            <label>Name <span class="text-danger">*</span></label>
                                            <input type="text" name="name" class="form-control" value="{{old('name')}}"
                                                   placeholder="Enter Name"
                                                   required="">
                                            @foreach($errors->get('name') as $error)
                                                @foreach($errors->get('name') as $error)
                                                    <span class="text-danger">{{ $error }}</span>
                                                @endforeach
                                            @endforeach
                                        </div>
                                        <div class="form-group col-lg-6 col-12 mb-3">
                                            <label>Mobile <span class="text-danger">*</span> </label>
                                            <input type="number" name="phone" class="form-control"
                                                   value="{{old('phone')}}" placeholder="Enter Mobile Number"
                                                   required="">
                                            @foreach($errors->get('phone') as $error)
                                                <span class="text-danger">{{ $error }}</span>
                                            @endforeach
                                        </div>
                                        <div class="form-group col-lg-12 col-12 mb-3">
                                            <label>Email <span class="text-danger">*</span> </label>
                                            <input type="text" name="email" class="form-control"
                                                   placeholder="Enter Email"
                                                   value="{{old('email')}}"
                                                   required="">
                                            @foreach($errors->get('email') as $error)
                                                <span class="text-danger">{{ $error }}</span>
                                            @endforeach
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="form-group col-lg-6 col-12 mb-3">
                                            <label>Address <span class="text-danger">*</span></label>
                                            <input type="text" name="address" class="form-control"
                                                   value="{{old('address')}}" required=""
                                                   placeholder="Enter Address ">
                                            @foreach($errors->get('address') as $error)
                                                <span class="text-danger">{{ $error }}</span>
                                            @endforeach
                                        </div>

                                        <div class="form-group col-lg-6 col-12 mb-4">
                                            <label>Pincode <span class="text-danger">*</span></label>
                                            <input type="number" name="pincode" class="form-control"
                                                   value="{{old('pincode')}}" required="" placeholder="Enter Pincode">
                                            @foreach($errors->get('pincode') as $error)
                                                <span class="text-danger">{{ $error }}</span>
                                            @endforeach
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="form-group mb-4 col-lg-4 col-12">
                                            <label>State <span class="text-danger">*</span></label>
                                            <select name="state_id" id="state" class="form-control state_id"
                                                    data-toggle="select2" required>
                                                <option value="">Select State</option>
                                                @foreach($states as $state)
                                                    <option
                                                        value="{{ $state->id }}" {{ old('state_id') == $state->id ? 'selected' : '' }}>
                                                        {{ $state->name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            @foreach($errors->get('state_id') as $error)
                                                <span class="text-danger">{{ $error }}</span>
                                            @endforeach
                                        </div>
                                        <div class="form-group mb-4 col-lg-4 col-12">
                                            <label id="cities">City <span
                                                    class="text-danger">*</span></label>
                                            <select name="city_id" id="city_id" class="form-control city_id"
                                                    data-toggle="select2" required>
                                                <option value="">Select City</option>
                                            </select>
                                            @foreach($errors->get('city_id') as $error)
                                                <span class="text-danger">{{ $error }}</span>
                                            @endforeach
                                        </div>
                                        <div class="form-group col-lg-4 col-12 mb-4">
                                            <label>Pincode<span class="text-danger">*</span></label>
                                            <input type="number" name="pincode" class="form-control"
                                                   value="{{old('pincode')}}" required="" placeholder="Enter Pincode">
                                            @foreach($errors->get('pincode') as $error)
                                                <span class="text-danger">{{ $error }}</span>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-4 col-12 pad-l">
                                <div class="bg-white p-3 mt-4 mt-lg-0 rounded">
                                    <h4 class="header-title mb-3">Order Summary</h4>
                                    <div class="table-responsive">
                                        <table class="table mb-0">
                                            <tbody>
                                            <tr>
                                                <td>Sub Total :</td>
                                                <td>
                                                <span id="mainTotal"
                                                      data-value="{{ round($cartTotal, 2) }}">र {{ round($cartTotal, 2) }}</span>
                                                </td>
                                            </tr>
                                            <tr style="display: none">
                                                <td>Shipping Charge :</td>
                                                <td>
                                                <span id="shippingCharge"
                                                      data-value="{{ round($cartShippingTotal, 2) }}">र {{ round($cartShippingTotal, 2) }}</span>
                                                </td>
                                            </tr>

                                            <tr>
                                                <th>Total :</th>
                                                <th>
                                                 <span id="grandTotal"
                                                       data-value="{{ round($cartTotal + $cartShippingTotal , 2) }}">र {{ round($cartTotal + $cartShippingTotal , 2) }}
                                                    </span>
                                                </th>
                                            </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                    <button class="btn btn-primary font-weight-bold text-uppercase btn-block"
                                            type="submit"
                                            name="ordersButton">Process To Payment
                                    </button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </section>
    @endif
@endsection



@push('page-javascript')
    <script src="{{ asset('js/vapor.min.js') }}"></script>
    <script src="{{ asset('js/filepond.min.js') }}"></script>
    <script>
        $('.memberCodeInput').each(function () {
            let el = $(this);

            if (el.val()) {
                getMemberName(el);
            }
        });

        $('.memberCodeInput').on('input', function () {
            getMemberName($(this));
        });

        var addCartUrl = "{{ route('website.cart.products.update') }}";
        var removeCartUrl = "{{ route('website.cart.products.remove') }}";
        var deliveredTypeCartUrl = "{{ route('website.cart.products.delivered-type') }}";
        var csrfToken = "{{ csrf_token() }}";
        var cartCountEl = $('#cartCount');

        $(document).ready(function () {
            $('#passwordCheck').hide();

            if ('{{ old('#deliveredType') }} === 1' || '{{ old('password') }}') {
                $('#passwordCheck').show();
            } else {
                $('#passwordCheck').hide();
            }
        });

        function deliveredType(val) {
            if (val == 2) {
                $('#passwordCheck').hide();
            } else {
                $('#passwordCheck').show();
            }
        }

        function removeFromCart(productId) {
            var removeProductEl = $('#removeProduct_' + productId);
            var productSubTotal = removeProductEl.data('subtotal');
            var shippingCharge = removeProductEl.data('shipping');
            var total = removeProductEl.data('total');
            var gstTotalEl = $('#gstCharge');

            var mainTotalEl = $('#mainTotal');
            var shippingTotalEl = $('#shippingCharge');
            var grandTotalEl = $('#grandTotal');
            var mainTotalValue = mainTotalEl.data('value');
            var shippingTotalValue = shippingTotalEl.data('value');
            var gstTotalValue = gstTotalEl.data('value');
            var newQuantity = removeProductEl.data('quantity') - 1;
            var oldQuantity = removeProductEl.data('quantity');

            $.ajax({
                url: removeCartUrl,
                data: {"_token": csrfToken, "product_id": productId},
                type: "POST",
                dataType: 'json',
                success: function (response) {
                    cartCountEl.html(response.cartCount);
                    if (response.cartCount > 0) {
                        $('#productRow_' + productId).remove();
                        Swal.fire('Yay', response.message, 'success');

                        var changeMainTotal = (parseFloat(mainTotalValue) - parseFloat(productSubTotal)).toFixed(2);
                        mainTotalEl.text('र ' + changeMainTotal);
                        mainTotalEl.data('value', changeMainTotal);
                        var changeShippingTotal = 0;

                        changeShippingTotal = (parseFloat(shippingTotalValue) - parseFloat(shippingCharge)).toFixed(2);
                        shippingTotalEl.text('र ' + changeShippingTotal);
                        shippingTotalEl.data('value', changeShippingTotal);

                        var newGst = parseFloat(total) - parseFloat(shippingCharge) - parseFloat(changeMainTotal)
                        var changeGstTotal = (parseFloat(gstTotalValue) - parseFloat(newGst)).toFixed(2);
                        gstTotalEl.text('र ' + changeGstTotal);
                        gstTotalEl.data('value', changeGstTotal);


                        var changeGrandTotal = (parseFloat(changeMainTotal) + parseFloat(changeShippingTotal)).toFixed(2);
                        grandTotalEl.text('र ' + changeGrandTotal);
                        grandTotalEl.data('value', changeGrandTotal);

                    } else {
                        location.reload();
                    }
                }
            });
        }

        function increaseProductQuantity(productId) {
            var subTotalEl = $('#subTotal_' + productId);
            var mainTotalEl = $('#mainTotal');
            var grandTotalEl = $('#grandTotal');
            var gstTotalEl = $('#gstCharge');
            var shippingCharge = $('#shippingCharge');

            var productEl = $('#product_' + productId);
            var newQuantity = productEl.data('quantity') + 1;
            var oldQuantity = productEl.data('quantity');

            $.ajax({
                url: addCartUrl,
                data: {"_token": csrfToken, "product_id": productId, "quantity": 1, "status": 1},
                type: "POST",
                dataType: 'json',
                success: function (response) {
                    if (response.status == false) {
                        Swal.fire('Yay', response.message, 'error');
                    } else {
                        productEl.data('quantity', newQuantity);
                        productEl.val(newQuantity);
                        var productValue = productEl.data('value');
                        var mainTotalValue = mainTotalEl.data('value');
                        var grandTotalValue = grandTotalEl.data('value');
                        var gstTotalValue = gstTotalEl.data('value');
                        var shipping = shippingCharge.data('value');

                        subTotalEl.text('र ' + (productValue * newQuantity).toFixed(2));

                        var removeProductEl = $('#removeProduct_' + productId);
                        removeProductEl.data('subtotal', (parseFloat(productValue) * parseFloat(newQuantity).toFixed(2)));

                        var changeMainTotal = (parseFloat(mainTotalValue) + parseFloat(productValue)).toFixed(2);
                        mainTotalEl.text('र ' + changeMainTotal);
                        mainTotalEl.data('value', changeMainTotal);

                        var changeGstTotal = ((parseFloat(gstTotalValue) / oldQuantity) * newQuantity).toFixed(2);
                        gstTotalEl.text('र ' + changeGstTotal);
                        gstTotalEl.data('value', changeGstTotal);

                        var changeGrandTotal = (parseFloat(changeMainTotal) + parseFloat(shipping)).toFixed(2);
                        grandTotalEl.text('र ' + changeGrandTotal);
                        grandTotalEl.data('value', changeGrandTotal);

                        cartCountEl.html(response.cartCount);
                    }
                }
            });


            // addToCart(productId, 1, 1);
            //
            // var productValue = productEl.data('value');
            // var mainTotalValue = mainTotalEl.data('value');
            // var grandTotalValue = grandTotalEl.data('value');
            //
            // subTotalEl.text('र ' + (productValue * newQuantity).toFixed(2));
            //
            // var removeProductEl = $('#removeProduct_' + productId);
            // removeProductEl.data('subtotal', (parseFloat(productValue) * parseFloat(newQuantity).toFixed(2)));
            //
            // var changeMainTotal = (parseFloat(mainTotalValue) + parseFloat(productValue)).toFixed(2);
            // mainTotalEl.text('र ' + changeMainTotal);
            // mainTotalEl.data('value', changeMainTotal);
            //
            // var changeGrandTotal = (parseFloat(grandTotalValue) + parseFloat(productValue)).toFixed(2);
            // grandTotalEl.text('र ' + changeGrandTotal);
            // grandTotalEl.data('value', changeGrandTotal);
        }

        function decreaseProductQuantity(productId) {
            var subTotalEl = $('#subTotal_' + productId);
            var mainTotalEl = $('#mainTotal');
            var grandTotalEl = $('#grandTotal');
            var shippingCharge = $('#shippingCharge');

            var productEl = $('#product_' + productId);
            var oldQuantity = productEl.data('quantity');
            var newQuantity = productEl.data('quantity') - 1;
            var gstTotalEl = $('#gstCharge');

            if (newQuantity <= 0) {
                return false;
            }

            addToCart(productId, 1, 2);

            productEl.data('quantity', newQuantity);
            productEl.val(newQuantity);

            var productValue = productEl.data('value');
            var mainTotalValue = mainTotalEl.data('value');
            var grandTotalValue = grandTotalEl.data('value');
            var gstTotalValue = gstTotalEl.data('value');
            var shipping = shippingCharge.data('value');

            subTotalEl.text('र ' + (productValue * newQuantity).toFixed(2));

            var removeProductEl = $('#removeProduct_' + productId);
            removeProductEl.data('subtotal', (parseFloat(productValue) * parseFloat(newQuantity).toFixed(2)));

            var changeMainTotal = (parseFloat(mainTotalValue) - parseFloat(productValue)).toFixed(2);
            mainTotalEl.text('र ' + changeMainTotal);
            mainTotalEl.data('value', changeMainTotal);

            var changeGstTotal = ((parseFloat(gstTotalValue) / oldQuantity) * newQuantity).toFixed(2);
            gstTotalEl.text('र ' + changeGstTotal);
            gstTotalEl.data('value', changeGstTotal);

            var changeGrandTotal = (parseFloat(changeMainTotal) + parseFloat(shipping)).toFixed(2);
            grandTotalEl.text('र ' + changeGrandTotal);
            grandTotalEl.data('value', changeGrandTotal);
        }

        function addToCart(productId, quantity, status) {
            $.ajax({
                url: addCartUrl,
                data: {"_token": csrfToken, "product_id": productId, "quantity": quantity, "status": status},
                type: "POST",
                dataType: 'json',
                success: function (response) {
                    // if (response.status == false) {
                    //     Swal.fire('Yay', response.message, 'error');
                    // } else {
                    cartCountEl.html(response.cartCount);
                    // }
                }
            });
        }

        $(document).ready(function () {

            @if (old('state_id'))
            getCity({{ old('state_id') }});
            @endif

            $('#state').on('change', function () {
                if ($(this).val()) {
                    $.ajax({
                        url: '/admin/get/city/' + $(this).val() + '',
                        success: function (data) {
                            var select = ' <option value="">Select City</option>';
                            $.each(data, function (key, value) {
                                select += '<option value=' + value.id + '>' + value.name + '</option>';
                            });
                            $('#city_id').html(select);

                        }
                    });
                } else {
                    $('#city_id').html('<option value="">Select City</option>');
                }
            })

        });

        function getCity(id) {
            if (id) {
                $.ajax({
                    url: '/admin/get/city/' + id + '',
                    success: function (data) {
                        var select = ' <option value="">Select City</option>';
                        $.each(data, function (key, value) {
                            select += '<option value="' + value.id + '" ' + (value.id == '{{ old('city_id') }}' ? 'selected' : '') + '>' + value.name + '</option>';
                        });
                        $('#city_id').html(select);
                    }
                });

            } else {
                $('#city_id').html('<option value="">Select City</option>');
            }
        }
    </script>
@endpush
