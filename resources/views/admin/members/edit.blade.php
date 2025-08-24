@extends('admin.layouts.master')

@section('title')
    Edit Member Details
@endsection

@section('content')
    @include('admin.breadcrumbs', [
       'crumbs' => [
           'Edit Member Details'
       ]
   ])
    <div class="row">
        <div class="col-lg-5">
            <form method="post" action="{{ route('admin.members.update', $member) }}">
                @csrf
                @method('patch')
                <div class="card">
                    <div class="card-body">
                        <h5 class="text-primary mb-3"> {{ $member->user->name }} | Member ID
                            : {{ $member->code }}</h5>
                        <div class="form-group mb-3">
                            <small class="text-light fw-semibold d-block">Gender</small>
                            <div class="form-check form-check-inline mt-1">
                                <input class="form-check-input" type="radio" name="gender" id="male" value="1" {{ old('gender', $member->user->gender) == 1 ? 'checked' : '' }}>
                                <label class="form-check-label" for="male">Male</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="gender" id="female" value="2" {{ old('gender', $member->user->gender) == 2 ? 'checked' : '' }}>
                                <label class="form-check-label" for="female">Female</label>
                            </div>
                        </div>
                        <div class="form-group mb-3">
                            <div class="form-floating form-floating-outline">
                                <input type="text" name="name" id="name"
                                       value="{{ old('name', $member->user->name) }}"
                                       class="form-control" placeholder="Enter Name" required>
                                <label for="name" class="required">Name</label>
                            </div>
                            @foreach($errors->get('name') as $error)
                                <span class="text-danger">{{ $error }}</span>
                            @endforeach
                        </div>
                        <div class="form-group mb-3">
                            <div class="form-floating form-floating-outline">
                                <input type="email" name="email" id="email"
                                       value="{{ old('email', $member->user->email) }}"
                                       class="form-control"
                                       placeholder="Enter Email ID" >
                                <label for="email" class="">Email ID</label>
                            </div>
                            @foreach($errors->get('email') as $error)
                                <span class="text-danger">{{ $error }}</span>
                            @endforeach
                        </div>
                        <div class="form-group mb-3">
                            <div class="form-floating form-floating-outline">
                                <input type="text" name="mobile" id="mobile"
                                       value="{{ old('mobile', $member->user->mobile) }}"
                                       class="form-control" placeholder="Enter Mobile Number" required>
                                <label for="mobile" class="required">Mobile Number</label>
                            </div>
                            @foreach($errors->get('mobile') as $error)
                                <span class="text-danger">{{ $error }}</span>
                            @endforeach
                        </div>
                        <div class="form-group mb-3">
                            <div class="form-floating form-floating-outline">
                                <input type="date" name="dob" class="form-control" id="basic-datepicker"
                                       placeholder="Enter DOB" required readonly >
                                <label for="basic-datepicker" class="col-form-label">Date Of Birth</label>
                            </div>
                            @foreach($errors->get('dob') as $error)
                                <span class="text-danger">{{ $error }}</span>
                            @endforeach
                        </div>
                        <div class="form-group d-flex justify-content-center">
                            <button type="submit" class="btn btn-primary">
                                <i class="uil uil-message me-1"></i> Submit
                            </button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection

@push('page-javascript')
    <script>
        $("#basic-datepicker").flatpickr({
            maxDate: new Date(),
            defaultDate: ["{{ old('dob', optional($member->user->dob)->dateFormat()) }}"],
            dateFormat: 'd-m-Y'
        });
    </script>
@endpush
