@extends('website.layouts.master')

@section('title',':: Return Policy | '.settings('company_name').' ::')

@section('content')
    <section class="wrapper bg-soft-primary">
        <div class="container pt-10 pb-10 pt-md-14 pb-md-16 text-center">
            <div class="row">
                <div class="col-lg-8 mx-auto">
                    <h1 class="display-1 mb-3">Return Policy</h1>
                    <nav class="d-inline-block" aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('website.home') }}">Home</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Return Policy</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </section>
    <section class="wrapper bg-light wrapper-border">
        <div class="container py-6 py-md-10">
            <div class="row gx-lg-8 gx-xl-12 gy-10 align-items-center mb-5">
                <div class="col-lg-12">
                    @if(settings('return_policy'))
                        <p> {!! settings('return_policy') !!}</p>
                    @else
                        <p class="l_height50">
                            In the event you receive a product in damaged/ defective condition and wish to return it,
                            please
                            contact our Customer Care at settings('mobile') or e-mail us
                            at {{ settings('email') }}
                            within 3 days and inform us about the same with your Order ID No.
                        </p>
                        <p>
                            We do not accept returns of product that has been fully/ partially lost or damaged by the
                            customer.
                        </p>
                        <p>
                            The exchange/refund will be issued when the product is received, inspected & approved by our
                            Quality Check team.
                        </p>
                        <p>
                            The refunds will take a minimum of 6-7 working days from the date of receipt of the goods by
                            us
                            at our below-mentioned address.
                        </p>
                        <p>
                            <b>{{ settings('company_name') }}</b> <br>
                            {{ settings('address_line_1') }} <br>
                            {{ settings('address_line_2') }} <br>
                            {{ settings('city') }}, {{ settings('state') }}

                            -{{ settings('pincode') }}
                        </p>
                        <p>
                            Post receipt and approval of goods a confirmation will be sent to the customer on the status
                            of
                            the request placed by the customer on the communication details provided to us.
                        </p>
                        <p>
                            All return/ exchange products must be in unused condition, in their original box & includes
                            all
                            packing material, & all accessories. Customer cannot return any product purchased via E-
                            Commerce Partners or at our Retail stores, similarly vice versa.
                        </p>
                    @endif
                </div>
            </div>
        </div>
    </section>
@endsection


