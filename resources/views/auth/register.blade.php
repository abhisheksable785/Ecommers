@extends('layout.log')

@section('title', 'Register')

@section('content')



<div class="login-container">
    <!-- Left side: Register form -->
    <div class="login-left">
        <div class="login-form">
            <h3 class="text-center mb-4">Register</h3>

            @if ($errors->any())
                <div class="alert alert-danger">{{ $errors->first() }}</div>
            @endif

            <form method="POST" action="{{ route('register') }}">
                @csrf
                <div class="mb-3">
                    <label>Name</label>
                    <input type="text" name="name" class="form-control" placeholder="Enter name" required value="{{ old('name') }}" />
                </div>

                <div class="mb-3">
                    <label>Email address</label>
                    <input type="email" name="email" class="form-control" placeholder="Enter email" required value="{{ old('email') }}" />
                </div>

                <div class="mb-3">
                    <label>Password</label>
                    <input type="password" name="password" class="form-control" placeholder="Enter password" required />
                </div>

                <div class="mb-3">
                    <label>Confirm Password</label>
                    <input type="password" name="password_confirmation" class="form-control" placeholder="Confirm password" required />
                </div>

                <button type="submit" class="btn btn-dark w-100">Register</button>
            </form>

            <div class="text-center mt-3">
                <small>Already have an account? <a href="{{ route('login') }}">Sign in here</a></small>
            </div>
        </div>
    </div>

    <!-- Right side: Image and promo text -->
    <div class="login-right">
        <div class="image-wrapper">
            <img src="{{ asset('img/hoodie.jpg') }}" alt="Product Image" class="blurred-image" />
            <div class="promo-text">Join the<br>style revolution</div>
            <div class="footer-text">Start your brand with BMT Fashion</div>
        </div>
    </div>
</div>

@endsection
