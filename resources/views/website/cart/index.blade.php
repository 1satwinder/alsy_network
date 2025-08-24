@extends('website.layouts.master')

@section('title',':: Shopping Cart | '.settings('company_name').' ::')

@section('content')
    <section class="wrapper bg-soft-primary">
        <div class="container pt-10 pb-12 pt-md-14 pb-md-16 text-center">
            <div class="row">
                <div class="col-lg-8 mx-auto">
                    <h1 class="display-1 mb-3">Shopping Cart</h1>
                    <nav class="d-inline-block" aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="#">Home</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Shopping Cart</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </section>
    @include('website.shopping-partials.cartbox')
@endsection
@push('page-css')
    <link rel="stylesheet" href="{{ asset('css/cart.css') }}">
@endpush
@push('page-javascript')
    <script src="{{ asset('js/vapor.min.js') }}"></script>
    <script src="{{ asset('js/filepond.min.js') }}"></script>
    @if(isset($paymentGatWay))
        <script src="https://checkout.razorpay.com/v1/checkout.js"></script>
        <script>
            let options = {
                "key": '{{env('settings('razor_pay_key')')}}',
                "amount": '{{ $order->total * 100}}',
                "name": '{{ $member->user->name }}',
                "currency": "INR",
                "handler": function (res) {
                    window.location.href = '{{ route('website.orders.payment-process',$order) }}' + '?order={{$order->order_no }}&transaction_id=' + res.razorpay_payment_id + '&status=success';
                },
                "prefill": {
                    "name": '{{ $member->user->name }}',
                    "email": '{{ $member->user->email }}',
                    "contact": '{{ $member->user->mobile }}'
                },
                "theme": {
                    "color": '#6ab2fb'
                },
                "modal": {
                    "ondismiss": function () {
                        window.location.href = '{{ route('website.orders.payment-process',$order) }}' + '?order={{$order->order_no }}&status=failed';
                    },
                    escape: false
                }
            };
            new Razorpay(options).open();
        </script>
    @endif
    <script>
        $(function () {
            $(".quantityChange").change(function () {
                var quantity = $('option:selected', this).text();
                var productId = $(this).attr("data-productId");

                increaseProductQuantity(productId, quantity);
            });
        });

        $(".toggle-password").click(function () {
            $(this).toggleClass("uil uil-eye uil uil-eye-slash");
            var input = $($(this).attr("toggle"));
            if (input.attr("type") == "password") {
                input.attr("type", "text");
            } else {
                input.attr("type", "password");
            }
        });

        var addCartUrl = "{{ route('website.cart.products.update') }}";
        var removeCartUrl = "{{ route('website.cart.products.remove') }}";
        var csrfToken = "{{ csrf_token() }}";
        var cartCountEl = $('#cartCount');

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
            var shippingTotalValue = shippingTotalEl.data('value') !== 'undefined' ? 0 : shippingTotalEl.data('value');
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

                        mainTotalEl.text('₹ ' + changeMainTotal);
                        mainTotalEl.data('value', changeMainTotal);


                        var changeShippingTotal = 0;

                        changeShippingTotal = (parseFloat(shippingTotalValue) - parseFloat(shippingCharge)).toFixed(2);
                        shippingTotalEl.text('₹ ' + changeShippingTotal);
                        shippingTotalEl.data('value', changeShippingTotal);

                        var newGst = parseFloat(total) - parseFloat(shippingCharge) - parseFloat(changeMainTotal);
                        var changeGstTotal = (parseFloat(gstTotalValue) - parseFloat(newGst)).toFixed(2);
                        gstTotalEl.text('₹ ' + changeGstTotal);
                        gstTotalEl.data('value', changeGstTotal);

                        var changeGrandTotal = 0;
                        changeGrandTotal = (parseFloat(changeMainTotal) + parseFloat(changeShippingTotal)).toFixed(2);
                        grandTotalEl.text('₹ ' + changeGrandTotal);
                        grandTotalEl.data('value', changeGrandTotal);
                    } else {
                        location.reload();
                    }
                }
            });
        }

        function increaseProductQuantity(productId, quantity) {
            var subTotalEl = $('#subTotal_' + productId);
            var mainTotalEl = $('#mainTotal');

            var mainTotalFV = $('#subTotalFirst_' + productId);
            var grandTotalEl = $('#grandTotal');
            var gstTotalEl = $('#gstCharge');
            var shippingCharge = $('#shippingCharge');

            var productEl = $('#product_' + productId);
            var newQuantity = quantity;
            var oldQuantity = productEl.data('quantity');

            $.ajax({
                url: addCartUrl,
                data: {"_token": csrfToken, "product_id": productId, "quantity": quantity, "status": 1},
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
                        var gstTotalValue = gstTotalEl.data('value');
                        var shipping = shippingCharge.data('value') !== 'undefined' ? 0 : shippingCharge.data('value');

                        var oldCartProductValue = (productValue * oldQuantity).toFixed(2);
                        subTotalEl.text('₹ ' + (productValue * newQuantity).toFixed(2));

                        var removeProductEl = $('#removeProduct_' + productId);
                        removeProductEl.data('subtotal', (parseFloat(productValue) * parseFloat(newQuantity).toFixed(2)));

                        var changeMainTotal = ((mainTotalValue - oldCartProductValue) + (productValue * newQuantity)).toFixed(2);
                        mainTotalEl.text('₹ ' + changeMainTotal);
                        mainTotalEl.data('value', changeMainTotal);

                        // var changeMainTotalFV = (parseFloat(mainTotalFirstValue) + parseFloat(productValue)).toFixed(2);
                        var changeMainTotalFV = (productValue * newQuantity).toFixed(2);
                        mainTotalFV.text('₹ ' + changeMainTotalFV);
                        mainTotalFV.data('value', changeMainTotalFV);
                        //------------------------
                        var changeGstTotal = ((parseFloat(gstTotalValue)) * newQuantity).toFixed(2);
                        gstTotalEl.text('₹ ' + changeGstTotal);
                        gstTotalEl.data('value', changeGstTotal);
                        var changeGrandTotal = 0;

                        changeGrandTotal = (parseFloat(changeMainTotal) + parseFloat(shipping)).toFixed(2);
                        grandTotalEl.text('₹ ' + changeGrandTotal);
                        grandTotalEl.data('value', changeGrandTotal);

                        cartCountEl.html(response.cartCount);
                    }
                }
            });
        }

        function addToCart(productId, quantity, status) {
            $.ajax({
                url: addCartUrl,
                data: {"_token": csrfToken, "product_id": productId, "quantity": quantity, "status": status},
                type: "POST",
                dataType: 'json',
                success: function (response) {
                    cartCountEl.html(response.cartCount);
                }
            });
        }

        $(document).ready(function () {

            @if (old('state_id',Auth::user()->member->user->state_id))
            getCity({{ old('state_id',Auth::user()->member->user->state_id) }});
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
