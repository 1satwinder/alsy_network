@extends('website.layouts.master')

@section('title',':: Contact Us | '.settings('company_name').' ::')

@section('content')
    <section class="wrapper bg-soft-primary">
        <div class="container pt-10 pb-10 pt-md-14 pb-md-16 text-center">
            <div class="row">
                <div class="col-lg-8 mx-auto">
                    <h1 class="display-1 mb-3"> Contact Us</h1>
                    <nav class="d-inline-block" aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('website.home') }}">Home</a></li>
                            <li class="breadcrumb-item active" aria-current="page"> Contact Us</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </section>
    <section class="wrapper bg-light ">
        <div class="container py-14 py-md-10">
            <div class="row gy-10 gx-lg-8 gx-xl-12 mb-16 align-items-center">
                <div class="col-lg-7 position-relative">
                    <div class="row gx-md-5 gy-5">
                        <h2 class="display-4 mb-3 text-center">Drop Us a Line</h2>
                        <p class="lead text-center mb-10">Reach out to us from our contact form and we will get back to
                            you shortly.</p>
                        <form class="contact_form_box" onsubmit="subButton.disabled = true; return true;" name=""
                              action="{{route('website.contact')}}" method="post">
                            @csrf
                            <div class="messages"></div>
                            <div class="controls">
                                <div class="row">

                                <div class="row gx-4">
                                        <div class="col-md-6">
                                            <div class="form-label-group mb-4">
                                                <select name="country_id" class="form-control custom-select" data-toggle="select2" required>
                                                    <option value="">Select Country</option>
                                                    @foreach($countries as $country)
                                                        <option
                                                            value="{{ $country->id }}" {{ old('country_id')==$country->id ? 'selected' : '' }} >
                                                            {{ $country->name }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                                @foreach($errors->get('country_id') as $error)
                                                    <div class="text-danger font-weight-bold">{{ $error }}</div>
                                                @endforeach
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-label-group mb-4">
                                            <input class="form-control" type="text" id="name" name="name"
                                                   placeholder="Your Name *"
                                                   value="{{ old('name') }}" required>
                                            <label for="name" class="required">Name</label>
                                            @foreach($errors->get('name') as $error)
                                                <span class="text-danger">{{ $error }}</span>
                                            @endforeach
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-label-group mb-4">
                                            <input class="form-control" type="number" id="mobile" name="mobile"
                                                   placeholder="Your Mobile Number *" min="1"
                                                   value="{{ old('mobile') }}" required>
                                            <label for="mobile" class="required">Mobile Number</label>
                                            @foreach($errors->get('mobile') as $error)
                                                <span class="text-danger">{{ $error }}</span>
                                            @endforeach
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-label-group mb-4">
                                            <input class="form-control" type="email" name="email" id="email"
                                                   placeholder="Your Email ID"
                                                   value="{{ old('email') }}" required>
                                            <label for="email" class="required">Email ID</label>
                                            @foreach($errors->get('email') as $error)
                                                <span class="text-danger">{{ $error }}</span>
                                            @endforeach
                                        </div>
                                    </div>

                                    <div class="col-12">
                                        <div class="form-label-group mb-4">
                                           <textarea name="message" id="comment" class="form-control" rows="5"
                                                     placeholder="Enter Your comment *" required>{{old('message')}}</textarea>
                                            <label for="comment" class="required">Message</label>
                                            @foreach($errors->get('message') as $error)
                                                <span class="text-danger">{{ $error }}</span>
                                            @endforeach
                                        </div>
                                    </div>
                                    <div class="col-12 text-center">
                                        <input type="submit" class="btn btn-primary rounded btn-send mb-3"
                                               value="Send message" name="subButton">
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="col-lg-5">
                    @if(settings('address_enabled'))
                        <div class="d-flex flex-row">
                            <div>
                                <div class="icon text-primary fs-28 me-6 mt-n1"><i class="uil uil-location-pin-alt"></i>
                                </div>
                            </div>
                            <div>
                                <h5 class="mb-1">Address</h5>
                                <address>
                                    {{ settings('address_line_1') }} <br>
                                    {{ settings('address_line_2') }} <br>
                                    {{ settings('city') }}, {{ settings('state') }}, {{ settings('country') }}
                                    -{{ settings('pincode') }}
                                </address>
                            </div>
                        </div>
                    @endif
                    @if(settings('mobile'))
                        <div class="d-flex flex-row">
                            <div>
                                <div class="icon text-primary fs-28 me-6 mt-n1"><i class="uil uil-phone-volume"></i>
                                </div>
                            </div>
                            <div>
                                <h5 class="mb-1">Mobile Number</h5>
                                <p>{{ settings('mobile') }}</p>
                            </div>
                        </div>
                    @endif
                    @if(settings('email'))
                        <div class="d-flex flex-row">
                            <div>
                                <div class="icon text-primary fs-28 me-6 mt-n1"><i class="uil uil-envelope"></i></div>
                            </div>
                            <div>
                                <h5 class="mb-1">Email ID</h5>
                                <p class="mb-0">
                                    <a href="mailto:{{ settings('email') }}"
                                       class="link-body">{{ settings('email') }}</a>
                                </p>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </section>
@endsection



