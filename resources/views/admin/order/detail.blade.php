@extends('admin.layouts.master')

@section('title')
    Order Details
@endsection

@section('content')
    @include('admin.breadcrumbs', [
       'crumbs' => [
           route('admin.orders.index')=>'Orders',
           'Details'
       ]
   ])
    <div class="row">
        <div class="col-xl-4 col-lg-4">
            <div class="card">
                <div class="card-body">
                    <div class="media ">
                        <img class="d-flex mr-3 rounded-circle avatar-lg" src="{{ asset('images/user.png') }}">
                        <div class="media-body">
                            <h4 class="mt-0 mb-1">{{ $order->member->user->name }}</h4>
                            <p class="text-muted">{{ $order->member->user->email }}</p>
                            <p class="text-muted"><i class="bx bx-mobile-alt"></i> {{ $order->member->user->mobile }}
                            </p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card mt-3">
                <div class="card-body">
                    <div class="card-widgets">
                        <a data-toggle="collapse" href="#orderStatus" role="button" aria-expanded="false"
                           aria-controls="orderStatus"><i class="mdi mdi-minus"></i></a>
                    </div>
                    <h5 class="card-title mb-0">UPDATE ORDER STATUS</h5>
                    <div id="orderStatus" class="collapse pt-3 show">
                        <form method="post" action="{{ route('admin.orders.status-update',$order) }}">
                            @csrf
                            <div class="form-group">
                                <label class="required">Status</label>
                                <select class="form-control" name="status" data-toggle="select2" required>
                                    <option value="" disabled="">Select Status</option>
                                    @foreach(\App\Models\Order::STATUSES as $key => $status)
                                        <option
                                            value="{{ $key }}" {{ $key == $order->status ? 'selected' : '' }}>{{ $status }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="remark" class="required">Remarks</label>
                                <input type="text" class="form-control" name="remarks" placeholder="Enter Remarks"
                                       required>
                            </div>
                            <input type="hidden" name=sub_order_id value="{{ $order->id }}">
                            <div class="form-group">
                                <button class="btn btn-primary text-center" type="submit" value="update_status"
                                        name="update_status">
                                    Update <i class="ti-arrow-right"></i>
                                </button>
                                {{--                                 <button type="button" class="btn btn-danger text-center" data-toggle="modal"--}}
                                {{--                                         data-target=".refundModal">--}}
                                {{--                                     <i class="ti-share"></i> Refund--}}
                                {{--                                 </button>--}}
                                <button type="button" class="btn btn-dark text-center" data-toggle="modal"
                                        data-target=".logModal">
                                    <i class='bx bx-file'></i> Log
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            {{--            <div class="card mt-3">--}}
            {{--                <div class="card-body">--}}
            {{--                    <div class="card-widgets">--}}
            {{--                        <a data-toggle="collapse" href="#AWB" role="button" aria-expanded="false"--}}
            {{--                           aria-controls="AWB"><i class="mdi mdi-minus"></i></a>--}}
            {{--                    </div>--}}
            {{--                    <h5 class="card-title mb-0">UPDATE COURIER DETAILS</h5>--}}
            {{--                    <div id="AWB" class="collapse pt-3 show">--}}
            {{--                        <form method="post" action="{{ route('admin.orders.awb.update', $order) }}">--}}
            {{--                            @method('PATCH')--}}
            {{--                            @csrf--}}
            {{--                            <div class="form-group">--}}
            {{--                                <label>Courier Partner</label>--}}
            {{--                                <input type="text" class="form-control" name="courier_partner"--}}
            {{--                                       value="{{ $order->courier_partner }}"--}}
            {{--                                       placeholder="Enter Courier Partner" required="">--}}
            {{--                                @foreach($errors->get('courier_partner') as $error)--}}
            {{--                                    <span class="text-danger">{{ $error }}</span>--}}
            {{--                                @endforeach--}}
            {{--                            </div>--}}
            {{--                            <div class="form-group">--}}
            {{--                                <label>AWB/Docket Number</label>--}}
            {{--                                <input type="text" class="form-control" name="courier_awb"--}}
            {{--                                       value="{{ $order->courier_awb }}"--}}
            {{--                                       placeholder="Enter AWB/Docket Number" required="">--}}
            {{--                                @foreach($errors->get('courier_awb') as $error)--}}
            {{--                                    <span class="text-danger">{{ $error }}</span>--}}
            {{--                                @endforeach--}}
            {{--                            </div>--}}
            {{--                            <div class="form-group">--}}
            {{--                                <label>Tracking Link</label>--}}
            {{--                                <input type="text" class="form-control" name="courier_tracking_url"--}}
            {{--                                       value="{{ $order->courier_tracking_url }}"--}}
            {{--                                       placeholder="Enter Tracking Link" required="">--}}
            {{--                                @foreach($errors->get('courier_tracking_url') as $error)--}}
            {{--                                    <span class="text-danger">{{ $error }}</span>--}}
            {{--                                @endforeach--}}
            {{--                            </div>--}}
            {{--                            <div class="form-group">--}}
            {{--                                <button class="btn btn-primary text-center" type="submit" value="update_awb"--}}
            {{--                                        name="update_awb">--}}
            {{--                                    Submit--}}
            {{--                                    <i class="ti-arrow-right"></i>--}}
            {{--                                </button>--}}
            {{--                            </div>--}}
            {{--                        </form>--}}
            {{--                    </div>--}}
            {{--                </div>--}}
            {{--            </div>--}}
        </div>
        <div class="col-lg-8 col-xl-8">
            <div class="card">
                <div class="card-header bg-primary py-3 text-white">
                    <div class="card-widgets">
                        <a data-toggle="collapse" href="#address" role="button" aria-expanded="false"
                           aria-controls="cardCollpase2"><i class="mdi mdi-minus"></i></a>
                    </div>
                    <h5 class="card-title mb-0 text-white">CUSTOMER ADDRESS DETAILS</h5>
                </div>
                <div id="address" class="collapse show">
                    <div class="card-body">
                        <div class="row">
                            <div class="form-group mb-2 col-md-6">
                                <label>Name</label>
                                <input type="text" name="name" class="form-control"
                                       value="{{$order->name}}" readonly>
                            </div>
                            <div class="form-group mb-2 col-md-6">
                                <label>Mobile</label>
                                <input type="text" name="mobile" required="" class="form-control"
                                       value="{{$order->phone}}"
                                       readonly>
                            </div>
                            <div class="form-group mb-2 col-md-12">
                                <label>Address</label>
                                <textarea class="form-control" name="address" id="" cols="5" rows="5"
                                          readonly>{{$order->address}}</textarea>
                            </div>
                            <div class="form-group mb-2 col-md-4">
                                <label>State</label>
                                <input type="text" name="state" required="" class="form-control"
                                       value="{{$order->state->name}}" readonly>
                            </div>
                            <div class="form-group mb-2 col-md-4">
                                <label>State</label>
                                <input type="text" name="city" required="" class="form-control"
                                       value="{{$order->city->name}}" readonly>
                            </div>
                            <div class="form-group mb-2 col-md-4">
                                <label>Pincode</label>
                                <input type="number" name="pincode" id="pincode" maxlength="6" class="form-control"
                                       value="{{$order->pincode}}" readonly>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card mt-3">
                <div class="card-header bg-danger py-3 text-white">
                    <div class="card-widgets">
                        <a data-toggle="collapse" href="#mainOrder" role="button" aria-expanded="false"
                           aria-controls="cardCollpase2"><i class="mdi mdi-minus"></i></a>
                    </div>
                    <h5 class="card-title mb-0 text-white">
                        MAIN ORDER SUMMARY - {{ $order->order_no}}</h5>
                </div>
                <div id="mainOrder" class="collapse show">
                    <div class="card-body">
                        <table class="display table table-bordered" id="example-table">
                            <thead>
                            <tr>
                                <th>Sr. No.</th>
                                <th width="30%">Name</th>
                                <th>Photo</th>
                                <th>Qty</th>
                                <th>Unit Price</th>
                                <th>BV</th>
                                <th>Amount</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($productDetails as  $key => $detail)
                                <tr>
                                    <td class="align-center">{{ $key+1 }}</td>
                                    <td>
                                        {{ $detail->product->name }}
                                    </td>
                                    <td>
                                        <img
                                            src="{{ $detail->product->getFirstMediaUrl(\App\Models\Product::MC_PRODUCT_IMAGE) }}"
                                            width="50">
                                    </td>
                                    <td>
                                        {{ $detail->quantity }}
                                    </td>
                                    <td>
                                        {{ env('APP_CURRENCY', ' र ') }} {{ $detail->dp }}
                                    </td>
                                    <td>
                                        {{ $detail->bv }}
                                    </td>
                                    <td>{{ env('APP_CURRENCY', ' र ') }} {{ $detail->total + ($detail->shipping_charge)  }}
                                    </td>
                                </tr>
                            @endforeach
                            <tr>
                                <td colspan="3"></td>
                                <th colspan="3">Total Unit Price [+]</th>
                                <td>{{ env('APP_CURRENCY', ' र ') }}{{ $order->total }}</td>
                            </tr>
                            <tr>
                                <td colspan="3"></td>
                                <th colspan="3">Total BV</th>
                                <td>{{ $order->total_bv }}</td>
                            </tr>
                            <tr>
                                <td colspan="3"></td>
                                <th colspan="3">Total Shipping Cost [+]</th>
                                <td>{{ env('APP_CURRENCY', ' र ') }}{{ $order->shipping_charge  }}</td>
                            </tr>
                            <tr>
                                <td colspan="3"></td>
                                <th colspan="3">Gross Amount</th>
                                <td>
                                    {{ env('APP_CURRENCY', ' र ') }}{{ $order->total }}
                                </td>
                            </tr>
                            @if($order->wallet > 0)
                                <tr>
                                    <td colspan="3"></td>
                                    <th colspan="3">Wallet Apply</th>
                                    <td>
                                        {{ env('APP_CURRENCY', ' र ') }}{{ $order->wallet }}
                                    </td>
                                </tr>
                            @endif
                            {{--                            <tr>--}}
                            {{--                                <td colspan="3"></td>--}}
                            {{--                                <th colspan="3">Net Amount</th>--}}
                            {{--                                <td>{{ env('APP_CURRENCY', ' र ') }}{{ $order->cart_amount }}--}}
                            {{--                                </td>--}}
                            {{--                            </tr>--}}
                            </tbody>
                            <tfoot>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade refundModal" tabindex="-1" role="dialog" aria-labelledby="myCenterModalLabel"
         aria-hidden="true" style="display: none;">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="myCenterModalLabel">Refund for {{ $order->order_no }}</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Amount</label>
                                <input type="text" class="form-control" name="amount" placeholder="Enter Refund Amount"
                                       required="">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <label>Refund Type</label>
                            <select name="type" class="form-control payment_type" required="">
                                <option value="" selected="" disabled="">Select Options</option>
                                <option value="1">Wallet</option>
                                <option value="2">Cheque</option>
                                <option value="3">NEFT</option>
                                <option value="4">Payment Getways partner</option>
                            </select>
                        </div>
                        <div class="col-md-12 payment_options" style="display:none;">
                            <div class="col-md-6">
                                <label>Transaction Id</label>
                                <input type="text" class="form-control" id="transaction_id" name="transaction_id"
                                       placeholder="Enter transaction id">
                            </div>
                            <div class="col-md-6">
                                <label>Bank name</label>
                                <input type="text" class="form-control" name="bank_name" placeholder="Enter bank name">
                            </div>
                        </div>
                        <div class="col-md-12">
                            <textarea name="remark" class="form-control" placeholder="Enter Remarks" rows="2"
                                      required=""></textarea>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light waves-effect" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary waves-effect waves-light">Save changes</button>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->
    <div class="modal fade logModal" tabindex="-1" role="dialog" aria-labelledby="myCenterModalLabel"
         aria-hidden="true" style="display: none;">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="myCenterModalLabel">Order Log {{ $order->order_no }}</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                </div>
                <div class="modal-body">
                    <table class="table table-striped table-bordered">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th>Status</th>
                            <th>Remark</th>
                            <th>Date</th>
                        </tr>
                        </thead>
                        <tbody>
                        @php ($i = 1)
                        @foreach($orderLogs as  $key => $log)
                            <tr>
                                <td>
                                    {{ $i }}
                                </td>
                                <td>
                                    {{ \App\Models\OrderStatusLog::STATUSES[$log->status] }}
                                </td>
                                <td>
                                    {{ $log->remarks }}
                                </td>
                                <td>
                                    {{ $log->created_at }}
                                </td>

                            </tr>
                            @php ($i++)
                        @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light waves-effect" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary waves-effect waves-light">Save changes</button>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->
@endsection


