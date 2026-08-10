@extends('layouts.app')

@section('title', 'Reset Password')

@section('content')

<section class="login-section">

    <div class="container">

        <div class="row justify-content-center align-items-center login-row">

            <div class="col-lg-4 col-md-6 col-sm-8 col-11">

                <div class="login-card">

                    <div class="text-center mb-4">

                        <img
                            src="{{ asset('images/logomml.webp') }}"
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

.login-row{

    min-height:calc(100vh - 80px);
    display:flex;
    align-items:center;
    justify-content:center;

}

.login-card{

    background:white;

    border-radius:20px;

    padding:24px;

    max-width:380px;
    width:100%;
    margin:auto;
    box-shadow:0 16px 40px rgba(0,0,0,.12);

}

.login-logo{

    width:56px;

    height:56px;

    object-fit:contain;

}

.login-card h2{

    color:#0B2E59;

    font-size:1.75rem;
    font-weight:800;
    margin-bottom:.5rem;

}

.form-control{

    height:44px;

    border-radius:12px;

    border:1px solid #d8dce3;
    padding:0 14px;
    font-size:.92rem;

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

@media (max-width:768px){

    .login-card{

        padding:20px;
        border-radius:16px;
        max-width:100%;

    }

    .login-card h2{

        font-size:1.6rem;

    }

    .login-logo{

        width:52px;
        height:52px;

    }

    .login-row{

        min-height:auto;
        padding:18px 0;

    }

    .form-control{

        height:42px;

    }

    .btn{

        min-height:44px;

    }

}

</style>

@endsection
