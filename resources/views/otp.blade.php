@php
$configData = Helper::applClasses();
@endphp
@extends('layouts.fullLayoutMaster')

@section('title', 'Login Page')

@section('page-style')
{{-- Page Css files --}}
<link rel="stylesheet" href="{{ asset(mix('css/base/plugins/forms/form-validation.css')) }}">
<link rel="stylesheet" href="{{ asset(mix('css/base/pages/page-auth.css')) }}">
@endsection

@section('content')
<div class="auth-wrapper auth-v2">
    <div class="auth-inner row m-0">
        <!-- Brand logo-->
        <a class="brand-logo" style="padding-left:30px;" href="javascript:void(0);">

            <img src="{{ asset('images/logo/Mojaplus-logo_Primary-Logo.png') }}" alt="MojaPass" style="width: 200px; height: 60px;">



        </a>
        <!-- /Brand logo-->

        <!-- Left Text-->
        <div class="d-none d-lg-flex col-lg-8 align-items-center p-5">
            <div class="w-100 d-lg-flex align-items-center justify-content-center px-5">

                       <img class="img-fluid" src="{{ asset('images/pages/login-v2-dark.svg') }}" alt="Login V2" />

            </div>
        </div>
        <!-- /Left Text-->
        <!-- Login-->
        <!-- Login-->
        <div class="d-flex col-lg-4 align-items-center auth-bg px-2 p-lg-5">
            <div class="col-12 col-sm-8 col-md-6 col-lg-12 px-xl-2 mx-auto">
                <h2 class="card-title font-weight-bold mb-1">Welcome to Moja<b>Pass</b>! 👋</h2>
                <p class="card-text mb-2">Enter the OTP Sent to your Email and Phone number</p>
                @if ($errors->has('otp'))
                <span class="help-block">
                    <strong class="text-danger">{{ $errors->first('otp') }}</strong>
                </span>
                @endif
                <form class="auth-login-form mt-2" action="{{ route('otp.login') }}" method="POST">
                    @csrf
                    <div class="form-group">
                        <label class="form-label" for="email">OTP</label>
                        <input class="form-control" id="otp" type="text" name="otp" placeholder="****" aria-describedby="login-email" autofocus="" tabindex="1" />
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <button type="submit" class="btn btn-primary btn-block" tabindex="4">Verify</button>
                        </div>
{{--                        <div class="col-md-6">--}}
{{--                            <button id="resendButton" type="button" class="btn btn-primary btn-block" tabindex="4" disabled>Resend</button>--}}
{{--                        </div>--}}
                        <div class="col-md-6">
                            <a href="{{route('login')}}" id="resendButton" type="button" class="btn btn-primary btn-block" tabindex="4">Resend</a>
                        </div>
                    </div>
                </form>

                <div class="col-md-6 mt-5 " style="margin-left: 80%">
                    <a href="/" id="resendButton" type="reset" tabindex="4" >Back to Login</a>
                </div>
            </div>
        </div>
    </div>

</div>
<script>
    var counter = 60;
    var resendButton = $('#resendButton');

    function updateCounter() {
        if (counter > 0) {
            counter--;
            resendButton.text('Resend (' + counter + 's)');
            setTimeout(updateCounter, 1000);
        } else {
            resendButton.text('Resend');
            resendButton.prop('disabled', false);
        }
    }

    resendButton.click(function() {
        resendButton.prop('disabled', true);
        counter = 60;
        updateCounter();
        // Add your resend logic here if needed
    });
</script>

{{--<script>--}}
{{--    // Countdown timer in seconds--}}
{{--    var countdownSeconds = 60;--}}

{{--    function startTimer() {--}}
{{--        var button = document.getElementById('resendButton');--}}

{{--        // Disable the button initially--}}
{{--        button.disabled = true;--}}

{{--        var interval = setInterval(function() {--}}
{{--            // Update the button text with the remaining seconds--}}
{{--            button.innerHTML  = 'Resend (' + countdownSeconds + 's)';--}}

{{--            if (countdownSeconds === 0) {--}}
{{--                // Enable the button after the countdown--}}
{{--                button.disabled = false;--}}
{{--                button.innerHTML  = 'Resend';--}}
{{--                clearInterval(interval);--}}
{{--            }--}}

{{--            countdownSeconds--;--}}
{{--        }, 1000);--}}
{{--    }--}}

{{--    // Start the timer when the page loads--}}
{{--    window.onload = startTimer;--}}
{{--</script>--}}

@endsection

@section('vendor-script')
<script src="{{ asset(mix('vendors/js/forms/validation/jquery.validate.min.js')) }}"></script>
@endsection

@section('page-script')
<script src="{{ asset(mix('js/scripts/pages/page-auth-login.js')) }}"></script>
@endsection

