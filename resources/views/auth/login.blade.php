@extends('layout.log')

@section('title', 'Login')

@section('content')



<div class="login-container">
    <!-- Left side: Login form -->
    <div class="login-left">
        <div class="login-form">
            <h3 class="text-center mb-4">Login</h3>

           @if (session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
@endif

@if ($errors->any())
    <div class="alert alert-danger">
        {{ $errors->first() }}
    </div>
@endif


            <form  action="{{ route('login') }}" method="POST">
                @csrf
                <div class="mb-3">
                    <label>Email address</label>
                    <input type="email" name="email" class="form-control" placeholder="Enter email" required value="{{ old('email') }}" />
                </div>
                <div class="mb-3">
                    <label>Password</label>
                    <input type="password" name="password" class="form-control" placeholder="Enter password" required />
                </div>
                <div class="mb-3 text-end">
                    <a href="reset-pass">Forgot password?</a>
                </div>
                <button type="submit" class="btn btn-dark w-100">Sign in</button>
            </form>

            <div class="text-center mt-3">
                <small>New user? <a href="{{ route('register') }}">Create new account</a></small>
            </div>
        </div>
    </div>

    <!-- Right side: Image and promo text -->
    <!-- Right side: Image and promo text -->
    <div class="login-right">
        <div class="image-wrapper">
            <img src="{{ asset('img/hoodie.jpg') }}" alt="Product Image" class="blurred-image" />
            <div class="promo-text">Build your<br>fashion brand</div>
            <div class="footer-text">AES-256 Grey Stone Hoodie<br>Made with BMT Fashion</div>
        </div>
    </div>
    
</div>


@endsection
