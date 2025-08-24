@extends('member.layouts.master')

@section('title','My Profile')

@section('content')
    @include('member.breadcrumbs', [
          'crumbs' => [
              'My Profile'
          ]
     ])
    <div class="row">
        <div class="col-lg-7">
            <form action="{{route('member.profile.update')}}" method="post" class="filePondForm">
                @csrf
                <div class="card">
                    <div class="card-header">
                        <div class="card-title-wrap bar-success">
                            <h5 class="card-title mb-0">My Profile</h5>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-lg-4 form-group mb-3">
                                <small class="text-light fw-semibold d-block">Gender</small>
                                <div class="form-check form-check-inline mt-1">
                                    <input class="form-check-input" type="radio" name="gender" id="male"
                                           value="1" {{ old('gender', $member->user->gender) == 1 ? 'checked' : '' }}>
                                    <label class="form-check-label" for="male">Male</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="gender" id="female"
                                           value="2" {{ old('gender', $member->user->gender) == 2 ? 'checked' : '' }}>
                                    <label class="form-check-label" for="female">Female</label>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-3 form-group mb-3">
                                <div class="form-floating form-floating-outline">
                                    <input id="name" type="text" name="name" class="form-control"
                                           placeholder="Enter Name"
                                           value="{{ old('name', $member->user->name) }}" readonly>
                                    <label for="name">Name</label>
                                </div>
                            </div>
                            <div class="col-lg-3 form-group mb-3">
                                <div class="form-floating form-floating-outline">
                                    <input id="mobile" type="text" name="mobile" class="form-control"
                                           placeholder="Enter Mobile Number"
                                           value="{{ old('mobile', $member->user->mobile) }}" readonly>
                                    <label for="mobile">Mobile Number</label>
                                </div>
                            </div>
                            <div class="col-lg-3 form-group mb-3">
                                <div class="form-floating form-floating-outline">
                                    <input id="email" type="email" name="email" class="form-control"
                                           placeholder="Enter Email ID"
                                           value="{{ old('email', $member->user->email) }}" >
                                    <label for="email" class="">Email ID</label>
                                </div>
                                @foreach($errors->get('email') as $error)
                                    <span class="text-danger">{{ $error }}</span>
                                @endforeach
                            </div>
                            <div class="col-lg-3 form-group mb-3">
                                <div class="form-floating form-floating-outline ">
                                    <input id="basic-datepicker" type="text" name="dob" class="form-control"
                                           placeholder="Enter Date Of Birth">
                                    <label for="basic-datepicker">Date Of Birth</label>
                                </div>
                            </div>
                            <div class="col-lg-4 form-group mb-3">
                                <div class="form-floating form-floating-outline">
                                      <textarea id="Address" name="address" class="form-control  h-px-100"
                                                placeholder="Enter Address"
                                                >{{ old('address', $member->user->address) }}</textarea>
                                    <label for="Address" class="">Address</label>
                                </div>
                                @foreach($errors->get('address') as $error)
                                    <span class="text-danger">{{ $error }}</span>
                                @endforeach
                            </div>
                            <div class="col-lg-4 form-group mb-3">
                                <div class="form-floating form-floating-outline">
                                    <select id="state" class="form-select" name="state_id" data-toggle="select2">
                                        <option value="">Select State</option>
                                        @foreach($states as $state)
                                            <option
                                                value="{{ $state->id }}" {{ old('state_id',$member->user->state_id)==$state->id ? 'selected' : '' }}>
                                                {{ $state->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    <label for="state">State</label>
                                </div>
                                @foreach($errors->get('state_id') as $error)
                                    <div class="text-danger font-weight-bold">{{ $error }}</div>
                                @endforeach
                            </div>
                            <div class="col-lg-4 form-group mb-3">
                                <div class="form-floating form-floating-outline">
                                    <select id="city_id" class="form-select old_dist" name="city_id"
                                            data-toggle="select2">
                                        <option value="">Select City</option>
                                        @foreach($cities as $city)
                                            <option
                                                value="{{ $city->id }}" {{ old('city_id',$member->user->city_id)== $city->id ? 'selected' : '' }}>
                                                {{ $city->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    <label for="city">City</label>
                                </div>
                            </div>
                            <div class="col-lg-4 form-group mb-3">
                                <div class="form-floating form-floating-outline mb-3">
                                    <input id="pincode" type="number" name="pincode" class="form-control"
                                           placeholder="Enter Pincode" min="100000" max="999999"
                                           onkeydown="return max_length(this,event,6)" autocomplete="off"
                                           value="{{ old('pincode', $member->user->pincode==0 ? "" : $member->user->pincode ) }}"
                                           >
                                    <label for="pincode" class="">Pincode</label>
                                </div>
                                @foreach($errors->get('pincode') as $error)
                                    <span class="text-danger">{{ $error }}</span>
                                @endforeach
                            </div>
                            <div class="col-lg-4 form-group mb-3">
                                <label>Profile Image</label>
                                <input type="file" class="filePondInput" name="profile_image"
                                       data-url="{{ $member->getFirstMediaUrl(\App\Models\Member::MC_PROFILE_IMAGE) }}"
                                       accept="image/*"/>
                            </div>
                            <div class="col-12">
                                <div class="text-center">
                                    <button type="submit" name="profile" class="btn btn-primary">
                                        <i class="uil uil-message me-1"></i> Submit
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
        <div class="col-md-5 col-12">
            <div class="card">
                <div class="card-header">
                    <div class="card-title-wrap bar-success">
                        <h5 class="card-title mb-0">Change Password</h5>
                    </div>
                </div>
                <div class="card-body">
                    <form action="{{route('member.change-password.update')}}" method="post">
                        @csrf
                        <div class="row">
                            <div class="col-12">
                                <div class="form-group">
                                    <div class="form-password-toggle">
                                        <div class="input-group input-group-merge">
                                            <div class="form-floating form-floating-outline">
                                                <input type="password" name="old_password" class="form-control"
                                                       id="old_password"
                                                       placeholder="Enter Old Password" required>
                                                <label for="old_password" class="required">Old Password</label>
                                            </div>
                                            <span class="input-group-text cursor-pointer" id="old_password"><i
                                                    class="mdi mdi-eye-off-outline"></i></span>
                                        </div>
                                    </div>
                                    @foreach($errors->get('old_password') as $error)
                                        <span class="text-danger">{{ $error }}</span>
                                    @endforeach
                                </div>
                                <div class="form-group">
                                    <div class="form-password-toggle">
                                        <div class="input-group input-group-merge">
                                            <div class="form-floating form-floating-outline">
                                                <input type="password" name="password" class="form-control"
                                                       id="new_password"
                                                       placeholder="Enter New Password" required>
                                                <label for="new_password" class="required">New Password</label>
                                            </div>
                                            <span class="input-group-text cursor-pointer" id="new_password"><i
                                                    class="mdi mdi-eye-off-outline"></i></span>
                                        </div>
                                    </div>
                                    @foreach($errors->get('password') as $error)
                                        <span class="text-danger">{{ $error }}</span>
                                    @endforeach
                                </div>
                                <div class="form-group">

                                    <div class="form-password-toggle">
                                        <div class="input-group input-group-merge">
                                            <div class="form-floating form-floating-outline">
                                                <input type="password" name="password_confirmation" class="form-control"
                                                       id="new_confirm_password"
                                                       placeholder="Enter Confirm Password" required>
                                                <label for="new_confirm_password" class="required">Confirm
                                                    Password</label>
                                            </div>
                                            <span class="input-group-text cursor-pointer" id="new_confirm_password"><i
                                                    class="mdi mdi-eye-off-outline"></i></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="text-center">
                                    <button type="submit" name="" class="btn btn-primary">
                                        <i class="uil uil-message me-1"></i> Submit
                                    </button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            @if(settings('transaction_password'))
                <div class="card">
                    <div class="card-header">
                        <div class="card-title-wrap bar-success">
                            <h5 class="card-title mb-0">Change Transaction Password</h5>
                        </div>
                    </div>
                    <div class="card-body">
                        <form action="{{route('member.financial-change-password.update')}}" method="post">
                            @csrf
                            <div class="row">
                                <div class="col-12">
                                    <div class="form-group">
                                        <div class="form-password-toggle">
                                            <div class="input-group input-group-merge">
                                                <div class="form-floating form-floating-outline">
                                                    <input type="password" name="financial_old_password"
                                                           class="form-control"
                                                           id="financial_old_password"
                                                           placeholder="Enter Old Transaction Password" required>
                                                    <label for="financial_old_password" class="required">Old Transaction
                                                        Password</label>
                                                </div>
                                                <span class="input-group-text cursor-pointer"
                                                      id="financial_old_password"><i
                                                        class="mdi mdi-eye-off-outline"></i></span>
                                            </div>
                                        </div>
                                        @foreach($errors->get('financial_old_password') as $error)
                                            <span class="text-danger">{{ $error }}</span>
                                        @endforeach
                                    </div>
                                    <div class="form-group">
                                        <div class="form-password-toggle">
                                            <div class="input-group input-group-merge">
                                                <div class="form-floating form-floating-outline">
                                                    <input type="password" name="financial_password"
                                                           class="form-control"
                                                           id="financial_password"
                                                           placeholder="Enter New Transaction Password" required>
                                                    <label for="financial_password" class="required">New Transaction
                                                        Password</label>
                                                </div>
                                                <span class="input-group-text cursor-pointer"
                                                      id="financial_old_password"><i
                                                        class="mdi mdi-eye-off-outline"></i></span>
                                            </div>
                                        </div>
                                        @foreach($errors->get('financial_password') as $error)
                                            <span class="text-danger">{{ $error }}</span>
                                        @endforeach
                                    </div>
                                    <div class="form-group">
                                        <div class="form-password-toggle">
                                            <div class="input-group input-group-merge">
                                                <div class="form-floating form-floating-outline">
                                                    <input type="password" name="financial_password_confirmation"
                                                           class="form-control"
                                                           id="financial_password_confirmation"
                                                           placeholder="Enter Confirm Transaction Password" required>
                                                    <label for="financial_password_confirmation" class="required">Confirm
                                                        Transaction Password</label>
                                                </div>
                                                <span class="input-group-text cursor-pointer"
                                                      id="financial_old_password"><i
                                                        class="mdi mdi-eye-off-outline"></i></span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="text-center">
                                        <button type="submit" name="" class="btn btn-primary">
                                            <i class="uil uil-message me-1"></i> Submit
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            @endif
        </div>
    </div>
@endsection
@include('admin.layouts.filepond')

@push('page-javascript')
    <script type="text/javascript">
        $("#basic-datepicker").flatpickr({
            maxDate: new Date(),
            dateFormat: "d-m-Y",
            defaultDate: ["{{ old('dob', $member->user->dob ? $member->user->dob->format('d-m-Y') : '') }}"],
        });

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
