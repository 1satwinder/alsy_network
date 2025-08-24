<!DOCTYPE html>

<html lang="en" class="light-style  customizer-hide" dir="ltr" data-theme="theme-default"
      data-assets-path="assets/" data-template="horizontal-menu-template">
<head>
    <title>Member Reset Password | {{ settings('company_name') }}</title>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
    <meta content="{{ settings('company_name') }}" name="description"/>
    <meta content="{{ settings('company_name') }}" name="author"/>
    <link rel="shortcut icon"
          href="{{ settings()->getFileUrl('favicon', asset(env('FAVICON', '/images/favicon.png'))) }}">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    @yield('import-css')
    <link rel="stylesheet" type="text/css"
          href="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/8.11.8/sweetalert2.min.css"/>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/Ladda/1.0.6/ladda-themeless.min.css">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/icons.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/core-dark.css') }}"
          class="template-customizer-core-css"/>
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/theme-default-dark.css') }}"
          class="template-customizer-theme-css"/>
    <link rel="stylesheet" href="{{ asset('assets/css/perfect-scrollbar.css') }}"/>
    <link rel="stylesheet" href="{{ asset('assets/css/node-waves.css') }}"/>
    <link rel="stylesheet" href="{{ asset('assets/css/typeahead.css') }}"/>
    <link rel="stylesheet" href="{{ asset('assets/css/page-auth.css') }}"/>
    <script src="{{ asset('assets/js/helpers.js') }}"></script>
    <script src="{{ asset('assets/js/config.js') }}"></script>
    <style>
        :root {
            --primary: {{ settings('primary_color') }};
            --primary-hover: {{ settings('primary_color_hover') }};
        }
    </style>
    @yield('page-css')
</head>
<body>
<div class="position-relative">
    <div class="authentication-wrapper authentication-basic container-p-y">
        <div class="authentication-inner py-4">
            <div class="card p-2">
                <div class="app-brand justify-content-center mt-5">
                    <a href="{{ env('APP_URL') }}" class="brand-logo app-brand-link gap-2">
                        <img src="{{ settings()->getFileUrl('logo', asset(env('LOGO', '/images/logo.png'))) }}"
                             alt="Logo" title="Logo">
                    </a>
                </div>
                <div class="card-body mt-2">
                    <h4 class="mb-2 fw-semibold">Reset Password?</h4>
                    <p class="mb-5">Please enter your Member ID and Mobile Number. We will send you an OTP to reset your
                        password.</p>

                    <form id="formAuthentication" class="mb-3" action="{{ route('member.forgot-password.store') }}"
                          method="POST" onsubmit="submit.disabled = true; return true;">
                        @csrf
                        <div class="form-group mb-3">
                            <div class="form-floating form-floating-outline">
                                <input id="code" class="form-control" type="text" placeholder="Enter Member ID"
                                       name="member_code" value="{{ old('member_code') }}" autocomplete="off" required>
                                <label for="code" class="required">Member ID</label>
                            </div>
                            @foreach($errors->get('member_code') as $error)
                                <div class="text-danger font-weight-bold">{{ $error }}</div>
                            @endforeach
                        </div>
                        <div class="form-group mb-3">
                            <div class="input-group input-group-merge">
                                <div class="form-floating form-floating-outline">
                                    <input id="mobile" class="form-control mobile" type="number"
                                           placeholder="Enter Mobile Number"
                                           name="mobile" value="{{ old('mobile') }}" min="6000000000"
                                           max="9999999999"
                                           onkeydown="return max_length(this,event,10)" autocomplete="off"
                                           required>
                                    <label for="mobile" class="required">Mobile Number</label>
                                </div>
                                @if (settings('sms_enabled'))
                                    <span class="input-group-text otpButton">
                                        <button type="button" class="btn btn-sm btn-primary sendOtp"
                                                id="sendOtp">
                                            Get OTP
                                        </button>
                                    </span>
                                    <span class="input-group-text otpTimerDiv">
                                        <button type="button" class="btn btn-sm btn-primary otpTimer">
                                        Timer
                                        </button>
                                    </span>
                                @endif
                            </div>
                            @foreach($errors->get('mobile') as $error)
                                <div class="text-danger">{{ $error }}</div>
                            @endforeach
                        </div>
                        @if (settings('sms_enabled'))
                            <div class="form-group mb-3">
                                <div class="form-floating form-floating-outline">
                                    <input id="otp" class="form-control" type="number"
                                           placeholder="Enter OTP"
                                           name="otp" value="{{ old('otp') }}" min="100000" max="999999"
                                           onkeydown="return max_length(this,event,6)" autocomplete="off"
                                           required>
                                    <label for="otp" class="required">OTP</label>
                                </div>
                                @foreach($errors->get('otp') as $error)
                                    <div class="text-danger">{{ $error }}</div>
                                @endforeach
                            </div>
                        @endif
                        <div class="mb-3">
                            <button class="btn btn-primary d-grid w-100" type="submit" name="submit">
                                Reset Password
                            </button>
                        </div>
                    </form>

                    <div class="divider my-4">
                        <div class="divider-text">or</div>
                    </div>

                    <p class="text-center">
                        <span>Back to </span>
                        <a href="{{ route('member.login.create') }}">
                            <span>Log In</span>
                        </a>
                    </p>
                </div>
            </div>
            <img alt="mask"
                 src="{{ settings()->getFileUrl('member_background', asset('images/auth-basic-login-mask-light.png')) }}"
                 class="authentication-image d-none d-lg-block">
        </div>
    </div>
</div>
<script src="{{ asset('assets/js/jquery.js') }}"></script>
<script src="{{ asset('assets/js/popper.js') }}"></script>
<script src="{{ asset('assets/js/bootstrap.js') }}"></script>
<script src="{{ asset('assets/js/perfect-scrollbar.js') }}"></script>
<script src="{{ asset('assets/js/node-waves.js') }}"></script>
<script src="{{ asset('assets/js/hammer.js') }}"></script>
<script src="{{ asset('assets/js/i18n.js') }}"></script>
<script src="{{ asset('assets/js/typeahead.js') }}"></script>
<script src="{{ asset('assets/js/menu.js') }}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/8.11.8/sweetalert2.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/Ladda/1.0.6/spin.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/Ladda/1.0.6/ladda.min.js"></script>
<script src="{{ asset('assets/js/main.js') }}"></script>
<script src="{{ asset('assets/js/scripts.js') }}"></script>
@if(Session::has('success'))
    <script>
        Swal.fire('Yay!!!', '{{ Session::get('success') }}', 'success')
    </script>
@endif
@if(Session::has('success-export'))
    <script>
        Swal.fire({
            icon: 'success',
            title: 'Yay!!!',
            text: '{{ Session::get('success-export') }}',
            footer: '<a href="{{ route('member.exports.index') }}" class="text-primary">Go To Exports</a>'
        });
    </script>
@endif
@if(Session::has('error'))
    <script>
        Swal.fire('Oops!!!', '{{ Session::get('error') }}', 'error')
    </script>
@endif

<script>
    let countdown;
    var intervalIDs = [];
    var mobileNumbers = [];
    var isTimerRunning = false;

    $(document).ready(function () {
        clearInterval(countdown);
        $('.sendOtp').click(function () {
            if ($('#mobile').val().trim() == '') {
                Swal.fire('Oops!!!', 'The mobile number is required.', 'error')
            } else if ($('#code').val().trim() == '') {
                Swal.fire('Oops!!!', 'The Member ID is required.', 'error')
            } else {
                preloader();
                getOtp($('#mobile').val().trim(), $('#code').val().trim());
            }
        })

        $('.otpTimerDiv').hide()

        @if($errors->any() || Session::has('error'))
        getOtpTime('{{ old('mobile') }}')
        @endif
    });

    function clearAllInterval() {
        for (var i = 0; i < intervalIDs.length; i++) {
            clearInterval(intervalIDs[i]);
        }
    }

    $('.mobile').keyup(function () {
        clearInterval(countdown)

        if ($(this).val().length >= 10) {
            if (mobileNumbers.includes($(this).val()) && isTimerRunning == false) {
                $('#sendOtp').text('Resend OTP');
            } else {
                $('#sendOtp').text('Get OTP');
            }

            $('.sendOtp').removeClass('waves-effect waves-light')
            getOtpTime($(this).val())
        } else {
            $('#sendOtp').text('Get OTP');
            $('.otpTimer').text('EXPIRED')
            $('.otpTimerDiv').hide()
            $('.otpButton').show()
        }
    })

    function getOtpTime(mobile) {
        $.ajax({
            url: "{{ route('member.get-forgot-password-otp-time') }}",
            method: 'post',
            data: {
                mobile: mobile,
                '_token': "{{ csrf_token()}}",
            },
            beforeSend: function () {
                console.log(1)
                $('#sendOtp').attr('disabled', true);
            },
            success: function (data) {
                if (data.status == true) {
                    otpCreatedAt = data.otpEligibleTime
                    otpTime(data.startTimestamps, data.endTimestamps, data.currentTimestamps);
                } else {
                    $('#sendOtp').attr('disabled', false);
                    $('.otpTimer').text('EXPIRED')
                    $('.otpTimerDiv').hide()
                    $('.otpButton').show()

                    clearInterval(countdown)
                }

                $('#sendOtp').attr('disabled', false);
            },
            error: function (error) {
                $('#sendOtp').attr('disabled', false);
                $('.otpTimer').text('EXPIRED')
                $('.otpTimerDiv').hide()
                $('.otpButton').show()

                clearInterval(countdown)
                clearAllInterval()

                $('#sendOtp').attr('disabled', false);
            }
        });
    }

    function getOtp(mobile, code) {
        $.ajax({
            url: "{{ route('member.send-otp-forgot-password') }}",
            method: 'post',
            data: {
                mobile: mobile,
                code: code,
                '_token': "{{ csrf_token()}}",
            },
            success: function (data) {
                preloaderOff();
                if (data.status == true) {
                    Swal.fire('Yay!!!', data.message, 'success');

                    mobileNumbers.push($('#mobile').val())
                    getOtpTime($('#mobile').val())
                } else {
                    Swal.fire('Oops!!!', data.message, 'error');
                }

                clearAllInterval()
            },
            error: function (error) {
                if (error.status == 422) {
                    if (error.responseJSON.message) {
                        Swal.fire('Oops!!!', error.responseJSON.message, 'error');
                    }
                }

                clearAllInterval()
            }
        });
    }

    function otpTime(startTimestamps, endTimestamps, currentTimestamps) {
        let endTime = new Date(endTimestamps * 1000);
        let currentTime = new Date(currentTimestamps * 1000);

        let timeRemaining = endTime - currentTime;

        if (timeRemaining > 0) {
            isTimerRunning = true

            countdown = setInterval(function () {
                timeRemaining -= 1000; // Subtract 1 second

                if (timeRemaining <= 0) {
                    $('#sendOtp').text('Resend OTP');

                    $('#sendOtp').attr('disabled', false);
                    $('.otpTimer').text('EXPIRED')
                    $('.otpTimerDiv').hide()
                    $('.otpButton').show()

                    isTimerRunning = false
                    clearInterval(countdown)
                    clearAllInterval()
                } else {
                    let minutes = Math.floor((timeRemaining / 1000 / 60) % 60);
                    let seconds = Math.floor((timeRemaining / 1000) % 60);

                    if (seconds >= 0 && seconds <= 9) {
                        seconds = '0' + seconds
                    }

                    $('.otpTimer').text(minutes + ":" + seconds)

                    $('.otpTimerDiv').show()
                    $('.otpButton').hide()

                }
            }, 1000);
        }

        intervalIDs.push(countdown);
    }

    document.addEventListener('visibilitychange', function () {
        if (document.visibilityState === 'visible') {
            console.log('Tab is now active.....');
            getOtpTime($('.mobile').val())
        }
    });
</script>
</body>
</html>
