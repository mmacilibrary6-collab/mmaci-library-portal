@extends('layouts.app')

@section('title', 'Administrator Login')

@section('content')

<section class="login-section">

    <div class="container">

        <div class="row justify-content-center align-items-center login-row">

            <div class="col-lg-4 col-md-6 col-sm-8 col-11">

                <div class="login-card">

                    <div class="text-center mb-3">

                        <img src="{{ asset('images/logomml.webp') }}"
                             class="login-logo"
                             alt="MMACI Logo">

                        <h2 class="mt-3 mb-1">
                            Administrator Login
                        </h2>

                        <p class="text-muted mb-0">
                            MMACI Library Services Office
                        </p>

                    </div>

                    <form method="POST"
                          action="{{ route('login.submit') }}">

                        @csrf

                        <div class="mb-3">

                            <label class="form-label">
                                Email Address
                            </label>

                            <input type="email"
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

                            <div class="text-end mt-2">

                                <a href="{{ route('password.request') }}"
                                   class="forgot-password-link">

                                    Forgot password?

                                </a>

                            </div>

                        </div>

                        <div class="mb-3">

                            <label class="form-label">
                                Password
                            </label>

                            <div class="password-wrapper">

                                <input type="password"
                                       id="password"
                                       name="password"
                                       class="form-control @error('password') is-invalid @enderror"
                                       placeholder="Enter your password"
                                       required>

                                <button type="button"
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

                        <button class="btn btn-warning w-100 login-btn">

                            <i class="bi bi-box-arrow-in-right me-2"></i>

                            Login

                        </button>

                    </form>

                    <div class="text-center mt-3">

                        <a href="{{ route('home') }}"
                           class="back-home">

                            <i class="bi bi-arrow-left me-1"></i>

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

    background:#fff;
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
        margin-bottom:0.5rem;

    }

    .form-label{

        font-weight:600;
        color:#26384D;

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
        color:#6c757d;
        padding:0;

    }

    .login-btn{

        height:46px;
        border-radius:45px;
        font-size:.98rem;
        font-weight:700;

    }

    .forgot-password-link{

        color:#0B2E59;
        text-decoration:none;
        font-size:.9rem;
        font-weight:600;

    }

    .forgot-password-link:hover{

        color:#F4B400;

    }

    .back-home{

        color:#0B2E59;
        text-decoration:none;
        font-weight:600;
        font-size:.95rem;

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

        .login-btn{

            height:44px;

        }

    }

</style>

<script>

document.getElementById('togglePassword').addEventListener('click', function(){

    const password = document.getElementById('password');
    const icon = this.querySelector('i');

    if(password.type === 'password'){

        password.type = 'text';
        icon.className = 'bi bi-eye-slash';

    }else{

        password.type = 'password';
        icon.className = 'bi bi-eye';

    }

});

</script>

@endsection
