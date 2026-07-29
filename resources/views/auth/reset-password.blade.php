@extends('layouts.app')

@section('title', 'Reset Password')

@section('content')

<section class="login-section">

    <div class="container">

        <div class="row justify-content-center align-items-center min-vh-100">

            <div class="col-lg-5 col-md-8">

                <div class="login-card">

                    <div class="text-center mb-4">

                        <img
                            src="{{ asset('images/logomml.png') }}"
                            class="login-logo"
                            alt="MMACI Logo">

                        <h2 class="mt-4 mb-2">
                            Reset Password
                        </h2>

                        <p class="text-muted">
                            Choose a new password for your administrator account.
                        </p>

                    </div>

                    <form method="POST"
                          action="{{ route('password.update') }}">

                        @csrf

                        <input type="hidden" name="token" value="{{ $token }}">

                        <div class="mb-4">

                            <label class="form-label">

                                Email Address

                            </label>

                            <input
                                type="email"
                                name="email"
                                class="form-control @error('email') is-invalid @enderror"
                                placeholder="Enter your email"
                                value="{{ old('email', $email) }}"
                                required>

                            @error('email')

                                <div class="invalid-feedback">

                                    {{ $message }}

                                </div>

                            @enderror

                        </div>

                        <div class="mb-4">

                            <label class="form-label">

                                New Password

                            </label>

                            <input
                                type="password"
                                name="password"
                                class="form-control @error('password') is-invalid @enderror"
                                placeholder="Enter your new password"
                                required>

                            @error('password')

                                <div class="invalid-feedback d-block">

                                    {{ $message }}

                                </div>

                            @enderror

                        </div>

                        <div class="mb-4">

                            <label class="form-label">

                                Confirm Password

                            </label>

                            <input
                                type="password"
                                name="password_confirmation"
                                class="form-control"
                                placeholder="Confirm your new password"
                                required>

                        </div>

                        <button class="btn btn-warning w-100 py-3 fw-bold rounded-pill">

                            <i class="bi bi-shield-lock me-2"></i>

                            Reset Password

                        </button>

                    </form>

                    <div class="text-center mt-4">

                        <a href="{{ route('login') }}"
                           class="back-home">

                            <i class="bi bi-arrow-left"></i>

                            Back to Login

                        </a>

                    </div>

                </div>

            </div>

        </div>

    </div>

</section>

<style>

.login-section{

    min-height:100vh;

    display:flex;

    align-items:center;

    background:
        linear-gradient(
            135deg,
            rgba(11,46,89,.92),
            rgba(24,75,140,.90)
        ),
        url("{{ asset('images/library-login-bg.jpg') }}");

    background-size:cover;

    background-position:center;

}

.login-card{

    background:white;

    border-radius:25px;

    padding:45px;

    box-shadow:0 25px 70px rgba(0,0,0,.20);

}

.login-logo{

    width:90px;

    height:90px;

    object-fit:contain;

}

.login-card h2{

    color:#0B2E59;

    font-weight:800;

}

.form-control{

    height:55px;

    border-radius:12px;

    border:1px solid #d8dce3;

}

.form-control:focus{

    border-color:#F4B400;

    box-shadow:0 0 0 .2rem rgba(244,180,0,.15);

}

.back-home{

    color:#0B2E59;

    text-decoration:none;

    font-weight:600;

}

.back-home:hover{

    color:#F4B400;

}

</style>

@endsection
