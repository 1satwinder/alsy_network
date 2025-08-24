@extends('admin.layouts.master')

@section('title') Update Payment Gateway Reference @endsection

@section('content')
    @include('admin.breadcrumbs', [
       'crumbs' => [
           'Update Payment Gateway Reference'
       ]
   ])
    <div class="row">
        <div class="col-8">
            <div class="card mt-2">
                <div class="card-header bg-dark py-3 text-white">
                    <h5 class="card-title mb-0 text-white">Payment Gateway Reference</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.orders.update.transaction.id') }}" method="post">
                        @csrf
                        <div class="row">
                            <div class="form-group col-xl-12 col-lg-12 col-md-12 col-12">
                                <label class="required">Order ID</label>
                                <input type="text" name="order_id" value="{{ $order->order_no }}" class="form-control" readonly>
                            </div>
                        </div>

                        <div class="row">
                            <div class="form-group col-xl-12 col-lg-12 col-md-12 col-12">
                                <label class="required">Payment Gateway Reference ID </label>
                                <input type="text" name="transaction_id" class="form-control"
                                       placeholder="Transaction ID" value="{{ old('transaction_id') }}" required>
                                @foreach($errors->get('transaction_id') as $error)
                                    <span class="text-danger">{{ $error }}</span>
                                @endforeach
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-12">
                                <a href="" class="btn btn-danger waves-effect waves-light font-weight-bold">
                                    <i class="mdi mdi-reload mr-1 font-weight-bold"></i> Reset
                                </a>
                                <button type="submit" class="btn btn-primary waves-effect waves-light font-weight-bold">
                                    <i class="mdi mdi-send mr-1 font-weight-bold mr-1"></i> Submit
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
