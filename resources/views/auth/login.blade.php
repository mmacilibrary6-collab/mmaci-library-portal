@extends('layouts.app')

@section('title', 'Administrator Login')

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
                            Administrator Login
                        </h2>

                        <p class="text-muted">
                            MMACI Library Services Office
                        </p>

                    </div>

                    @if(session('error'))

                        <div class="alert alert-danger">

                            {{ session('error') }}

                        </div>

                    @endif

                    @if(session('status'))

                        <div class="alert alert-success">

                            {{ session('status') }}

                        </div>

                    @endif

                    <form method="POST"
                          action="{{ route('login.submit') }}">

                        @csrf

                        <div class="mb-4">

                            <label class="form-label">

                                Email Address

                            </label>

                            <input
                                type="email"
                                name="email"
                                class="form-control @error('email') is-invalid @enderror"
                                placeholder="Enter your email"
                                value="{{ old('email') }}"
                                required>

                            @error('email')

                                <div class="invalid-feedback">

                                    {{ $message }}

                                </div>

                            @enderror

                            <div class="d-flex justify-content-end mt-2">

                                <a href="{{ route('password.request') }}"
                                   class="forgot-password-link">

                                    Forgot password?

                                </a>

                            </div>

                        </div>

                        <div class="mb-4">

                            <label class="form-label">

                                Password

                            </label>

                            <div class="password-wrapper">

                                <input
                                    type="password"
                                    id="password"
                                    name="password"
                                    class="form-control @error('password') is-invalid @enderror"
                                    placeholder="Enter your password"
                                    required>

                                <button
                                    type="button"
                                    id="togglePassword">

                                    <i class="bi bi-eye"></i>

                                </button>

                            </div>

                            @error('password')

                                <div class="invalid-feedback d-block">

                                    {{ $message }}

                                </div>

                            @enderror

                        </div>

                        <button
                            class="btn btn-warning w-100 py-3 fw-bold rounded-pill">

                            <i class="bi bi-box-arrow-in-right me-2"></i>

                            Login

                        </button>

                    </form>

                    <div class="text-center mt-4">

                        <a href="{{ route('home') }}"
                           class="back-home">

                            <i class="bi bi-arrow-left"></i>

                            Back to Website

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

.password-wrapper{

    position:relative;

}

.password-wrapper button{

    position:absolute;

    top:50%;

    right:15px;

    transform:translateY(-50%);

    border:none;

    background:none;

    color:#666;

}

.back-home{

    color:#0B2E59;

    text-decoration:none;

    font-weight:600;

}

.back-home:hover{

    color:#F4B400;

}

.forgot-password-link{

    color:#0B2E59;

    font-size:.95rem;

    font-weight:600;

    text-decoration:none;

}

.forgot-password-link:hover{

    color:#F4B400;

}

</style>

<script>

document.getElementById('togglePassword').addEventListener('click', function(){

    const password=document.getElementById('password');

    const icon=this.querySelector('i');

    if(password.type==='password'){

        password.type='text';

        icon.className='bi bi-eye-slash';

    }else{

        password.type='password';

        icon.className='bi bi-eye';

    }

});

</script>

@endsection
