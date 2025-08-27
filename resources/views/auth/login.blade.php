@extends('layouts.master2')

@section('title')
    Login to Invoices System
@stop

@section('css')
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Custom CSS for Login Page -->
    <style>
        body {
            background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .login-container {
            max-width: 400px;
            margin: auto;
            padding: 2rem;
            background: #ffffff;
            border-radius: 15px;
            box-shadow: 0 8px 30px rgba(0, 0, 0, 0.1);
        }
        .logo-container {
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 2rem;
        }
        .logo-container img {
            height: 50px;
            margin-right: 10px;
        }
        .main-logo1 {
            font-size: 2rem;
            font-weight: 700;
            color: #1e3a8a;
        }
        .btn-main-primary {
            background-color: #1e3a8a;
            border-color: #1e3a8a;
            transition: all 0.3s ease;
        }
        .btn-main-primary:hover {
            background-color: #1e40af;
            border-color: #1e40af;
        }
        .form-control:focus {
            border-color: #1e3a8a;
            box-shadow: 0 0 0 0.2rem rgba(30, 58, 138, 0.25);
        }
        .invalid-feedback {
            font-size: 0.875rem;
        }
        @media (max-width: 576px) {
            .login-container {
                margin: 1rem;
                padding: 1.5rem;
            }
        }
    </style>
@stop

@section('content')
{{-- <div class="row"> --}}
<div class="container mt-5">
    {{-- <div class="container"> --}}
        <div class="login-container">
            <div class="logo-container">
                <a href="{{ url('/') }}">
                    <img src="{{ asset('assets/img/brand/favicon.png') }}" class="sign-favicon" alt="logo">
                </a>
                <h1 class="main-logo1">Invoices system </h1>
            </div>
            <div class="text-center mb-4">
                <h2 class="fw-bold">تسجيل دخول</h2>
                <p class="text-muted">Sign in to your account</p>
            </div>
            <form method="POST" action="{{ route('login') }}">
                @csrf
                <div class="mb-3">
                    <label for="email" class="form-label">الايميل</label>
                    <input id="email" type="email" class="form-control @error('email') is-invalid @enderror"
                           name="email" value="{{ old('email') }}" required autofocus>
                    @error('email')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="password" class="form-label">الرقم السري</label>
                    <input id="password" type="password" class="form-control @error('password') is-invalid @enderror"
                           name="password" required>
                    @error('password')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                <div class="mb-3 form-check">
                    <input class="form-check-input" type="checkbox" name="remember" id="remember"
                           {{ old('remember') ? 'checked' : '' }}>
                    <label class="form-check-label" for="remember">
                        {{ __('Remember Me') }}
                    </label>
                </div>

                <button type="submit" class="btn btn-main-primary btn-block w-100">
                    {{ __('Login') }}
                </button>
            </form>
            <div class="text-center mt-3">
                <a href="{{ route('password.request') }}" class="text-muted">Forgot Password?</a>
            </div>
        </div>
    </div>
@stop

@section('js')
    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
@stop
