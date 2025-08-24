@if(count($cartProducts) > 0)
    <form action="{{ route('website.orders.store') }}" method="POST" class="filePondForm"
          onsubmit="ordersButton.disabled = true; return true;">
        @csrf
        <section class="py-14 py-md-5">
            <div class="container py-14 py-md-16">
                <div class="row">
                    <div class="col-12 col-md-7">
                        <ul class="list-group list-group-lg list-group-flush-x mb-6 list-unstyled">
                            @foreach($cartProducts as $product)
                                <li class="list-group-item" id="productRow_{{ $product->id }}">
                                    <input type="hidden" name="proId[]" value="{{ $product->id }}">
                                    <div class="row align-items-center">
                                        <div class="col-3">
                                            <img src="{{ $product->imageUrl }}" alt="{{ $product->name }}"
                                                 class="img-fluid"/>
                                        </div>
                                        <div class="col">
                                            <div class="d-flex mb-2 font-weight-bold">
                                                <a class="text-dark"
                                                   href="{{ route('website.product.detail', $product->slug) }}">
                                                    {{ $product->name }}
                                                </a>
                                                <span id="subTotal_{{ $product->id }}"
                                                      class="ml-auto">र {{ round($product->subTotalDp, 2) }}</span>
                                            </div>
                                            <p class="mb-7 font-size-sm text-muted">
                                                <span>Price: <span id="product_{{ $product->id }}"
                                                                   data-value="{{ round($product->dp,2) }}"
                                                                   data-quantity="{{ $product->selected_qty }}"
                                                                   class="text-primary">र {{ round($product->dp,2) }}</span></span><br>
                                                <span>BV: <span class="text-success">{{ round($product->bv,2) }}</span></span>
                                                <br>
                                                Product Code: {{ $product->sku }}
                                            </p>
                                            <div class="d-flex align-items-center">
                                                <select class="custom-select w-auto quantityChange"
                                                        data-productId="{{ $product->id }}"
                                                        name="quant[{{ $product->id }}]">
                                                    @for($i=1;$i<=15;$i++)
                                                        <option value="{{ $i }}"
                                                                @if($product->selected_qty == $i)
                                                                selected
                                                            @endif
                                                        >{{ $i }}</option>
                                                    @endfor
                                                </select>
                                                <a class="text-danger ml-auto cursor-pointer"
                                                   data-shipping="{{ isset($product->shipping_charge)?round($product->shipping_charge, 2):0 }}"
                                                   data-subTotal="{{ round($product->subTotalDp, 2) }}"
                                                   data-total="{{ round($product->subTotalDp) }}"
                                                   id="removeProduct_{{ $product->id }}"
                                                   onclick="removeFromCart({{ $product->id}});">
                                                    <i class="uil uil-times"></i> Remove
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                    <div class="col-12 col-md-5 col-lg-4 {{ Agent::isMobile() ? '' : 'sticky-sidebar'}}">
                        <div class="card mb-7 bg-soft-primary">
                            <div class="card-body">
                                <ul class="list-group list-group-sm list-group-flush-y list-group-flush-x">
                                    <li class="list-group-item d-flex">
                                        <span>Subtotal</span>
                                        <span class="ml-auto font-size-sm" id="mainTotal"
                                              data-value="{{ round($cartDetail->totalDp, 2) }}">
                                            र {{ round($cartDetail->totalDp, 2) }}
                                        </span>
                                    </li>
                                    <li class="list-group-item d-flex">
                                        <span>Total BV</span>
                                        <span class="ml-auto font-size-sm" id="mainTotal"
                                              data-value="{{ round($cartDetail->totalBv, 2) }}">
                                           {{ round($cartDetail->totalBv, 2) }} BV
                                        </span>
                                    </li>
                                    @if(isset($cartDetail->totalShipping) && $cartDetail->totalShipping>0 )
                                        <li class="list-group-item d-flex">
                                            <span>Shipping Charge</span>
                                            <span class="ml-auto font-size-sm" id="shippingCharge"
                                                  data-value="{{ round($cartDetail->totalShipping, 2) }}">
                                               र {{ round($cartDetail->totalShipping, 2) }}
                                            </span>
                                        </li>
                                    @endif
                                    <li class="list-group-item d-flex font-size-lg font-weight-bold">
                                        <span>Total</span>
                                        <span class="ml-auto font-size-sm" id="grandTotal"
                                              data-value="{{ round(($cartDetail->totalDp) + $cartDetail->totalShipping , 2) }}">
                                            र {{ round(($cartDetail->totalDp) + $cartDetail->totalShipping , 2) }}
                                        </span>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-7 my-3">
                        <div class="addressBlock bg-white p-3">
                            <h4 class="header-title mb-5">Delivery Address</h4>
                            <div class="payment-mode mb-3">
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="pay_by" id="pay_by_1"
                                           value="{{\App\Models\Order::PAY_BY_WALLET}}"
                                           {{ old('pay_by') == \App\Models\Order::PAY_BY_WALLET ? 'checked' : '' }}
                                           checked
                                           required>
                                    <label class="form-check-label" for="pay_by_1">
                                        Wallet
                                        <b class="text-danger">
                                            (Balance: {{ Auth::user()->member->wallet_balance }})
                                        </b>
                                    </label>
                                </div>
                                @if(settings('payment_gateway'))
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="pay_by"
                                               id="pay_by_2" value="{{\App\Models\Order::PAY_BY_ONLINE}}"
                                               {{ old('pay_by') == \App\Models\Order::PAY_BY_ONLINE ? 'checked' : '' }}
                                               required>
                                        <label class="form-check-label" for="pay_by_2">
                                            Online
                                        </label>
                                    </div>
                                @endif
                                @foreach($errors->get('pay_by') as $error)
                                    <div class="text-danger">{{ $error }}</div>
                                @endforeach
                            </div>
                            <div class="row">
                                <div class="form-group col-lg-6 mb-3" id="check_wallet_amount">
                                    <label for="password-icon" class="required">Transaction Password</label>
                                    <div class="input-group input-group-merge form-password-toggle">
                                        <input id="password-field" type="password" name="financial_password"
                                               placeholder="Enter Transaction Password"
                                               class="form-control financial_password"
                                               autocomplete="new-password" required>
                                        <div class="input-group-append">
                                                <span class="input-group-text cursor-pointer">
                                                    <i toggle="#password-field" class="uil uil-eye toggle-password"></i>
                                                </span>
                                        </div>
                                    </div>
                                    @foreach($errors->get('financial_password') as $error)
                                        <span class="text-danger">{{ $error }}</span>
                                    @endforeach
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-lg-4 mb-3">
                                    <label for="name" class="required">Name</label>
                                    <input id="name" type="text" name="name" class="form-control"
                                           value="{{ old('name', $member->user->name) }}"
                                           placeholder="Enter Name" required>
                                    @foreach($errors->get('name') as $error)
                                        <span class="text-danger">{{ $error }}</span>
                                    @endforeach
                                </div>
                                <div class="form-group col-lg-4 mb-3">
                                    <label for="mobile" class="required">Mobile</label>
                                    <input id="mobile" type="number" name="phone" class="form-control"
                                           value="{{ old('phone', $member->user->mobile) }}"
                                           placeholder="Enter Mobile Number"
                                           required>
                                    @foreach($errors->get('phone') as $error)
                                        <span class="text-danger">{{ $error }}</span>
                                    @endforeach
                                </div>
                                <div class="form-group col-lg-4 mb-3">
                                    <label for="email" class="required">Email</label>
                                    <input id="email" type="text" name="email" class="form-control"
                                           placeholder="Enter Email"
                                           value="{{ old('email', $member->user->email) }}" required>
                                    @foreach($errors->get('email') as $error)
                                        <span class="text-danger">{{ $error }}</span>
                                    @endforeach
                                </div>
                                <div class="form-group col-lg-12 col-12 mb-3">
                                    <label for="address" class="required">Address</label>
                                    <input id="address" type="text" name="address" class="form-control"
                                           value="{{ old('address', $member->user->address) }}"
                                           placeholder="Enter Address" required>
                                    @foreach($errors->get('address') as $error)
                                        <span class="text-danger">{{ $error }}</span>
                                    @endforeach
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group mb-4 col-lg-4 col-12 select">
                                    <label for="state" class="required">State</label>
                                    <select name="state_id" id="state" class="form-control state_id"
                                            data-toggle="select2" required>
                                        <option value="">Select State</option>
                                        @foreach($states as $state)
                                            <option
                                                value="{{ $state->id }}" {{ old('state_id',Auth::user()->member->user->state_id) == $state->id ? 'selected' : '' }}>
                                                {{ $state->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @foreach($errors->get('state_id') as $error)
                                        <span class="text-danger">{{ $error }}</span>
                                    @endforeach
                                </div>
                                <div class="form-group mb-4 col-lg-4 col-12 select">
                                    <label for="city_id" class="required">City </label>
                                    <select name="city_id" id="city_id" class="form-control city_id"
                                            data-toggle="select2" required>
                                        <option value="">Select City</option>
                                    </select>
                                    @foreach($errors->get('city_id') as $error)
                                        <span class="text-danger">{{ $error }}</span>
                                    @endforeach
                                </div>
                                <div class="form-group col-lg-4 col-12 mb-4">
                                    <label class="required">Pincode</label>
                                    <input type="number" name="pincode" class="form-control"
                                           value="{{ old('pincode', $member->user->pincode==0 ? "" : $member->user->pincode ) }}"
                                           placeholder="Enter Pincode" required>
                                    @foreach($errors->get('pincode') as $error)
                                        <span class="text-danger">{{ $error }}</span>
                                    @endforeach
                                </div>
                                <div class="col-lg-12">
                                    <button class="btn btn-sm btn-primary rounded" type="submit"
                                            name="ordersButton">Process To Payment
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </form>
@else
    <section class="wow fadeInUp py-6">
        <div class="container py-18 py-md-18">
            <div class="col-lg-12 d-flex text-center justify-content-center">
                <div class="error-content">
                    <img class="img-fluid"
                         src="{{ asset('images/empty_item.svg') }}" alt="no-data">
                    <div class="notfound-404">
                        <h1 class="text-primary">
                            <i class="uil uil-sad-squint"></i> Oops!
                            <span class="text-body">Shopping Cart is Empty.</span>
                        </h1>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endif
