@extends('layout.log')

@section('title', 'Login')

@section('content')
<div class="login-container">
    <!-- Left side: Login form -->
    <div class="login-left">
        <div class="login-form">
            <h3 class="text-center mb-4">Login</h3>

            @if (session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            <form method="POST" action="{{ route('login') }}">
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

            <!-- Social Login Buttons -->
            <div class="social-login mt-4">
                <div class="divider mb-3">
                    <span class="divider-text">OR CONTINUE WITH</span>
                </div>
                
                <div class="d-flex justify-content-center gap-3">
                    <!-- Google -->
   <a href="{{ url('/auth/google') }}" class="google-signin-btn">
    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" class="google-icon">
        <path fill="#4285F4" d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z"/>
        <path fill="#34A853" d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z"/>
        <path fill="#FBBC05" d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.07H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.93l2.85-2.22.81-.62z"/>
        <path fill="#EA4335" d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.07l3.66 2.84c.87-2.6 3.3-4.53 6.16-4.53z"/>
    </svg>
    <span>Sign in with Google</span>
</a>

<style>
    .google-signin-btn {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        background-color: #000000FF;
        color: #FFFFFFFF;
        border: 1px solid #000000FF;
        border-radius: 25px;
        padding: 10px 16px;
        font-size: 14px;
        font-weight: 500;
        font-family: 'Roboto', sans-serif;
        cursor: pointer;
        text-decoration: none;
        transition: background-color 0.3s, box-shadow 0.3s;
        box-shadow: 0 1px 2px 0 rgba(0,0,0,0.1);
    }
    
    .google-signin-btn:hover {
        background-color: #f8f9fa;
        color: #000;
        box-shadow: 0 1px 3px 0 rgba(0,0,0,0.2);
    }
    
    .google-icon {
        width: 18px;
        height: 18px;
        margin-right: 12px;
    }
</style>
                    
                    <!-- Facebook -->
                    {{-- <a href="{{ url('/auth/facebook') }}" class="social-btn facebook">
                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-facebook">
                            <path d="M18 2h-3a5 5 0 0 0-5 5v3H7v4h3v8h4v-8h3l1-4h-4V7a1 1 0 0 1 1-1h3z"></path>
                        </svg>
                    </a> --}}
                    
                    <!-- Twitter -->
                    {{-- <a href="{{ url('/auth/twitter') }}" class="social-btn twitter">
                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-twitter">
                            <path d="M23 3a10.9 10.9 0 0 1-3.14 1.53 4.48 4.48 0 0 0-7.86 3v1A10.66 10.66 0 0 1 3 4s-4 9 5 13a11.64 11.64 0 0 1-7 2c9 5 20 0 20-11.5a4.5 4.5 0 0 0-.08-.83A7.72 7.72 0 0 0 23 3z"></path>
                        </svg>
                    </a> --}}
                </div>
            </div>

            <div class="text-center mt-3">
                <small>New user? <a href="{{ route('register') }}">Create new account</a></small>
            </div>
        </div>
    </div>

    <!-- Right side: Image and promo text -->
    <div class="login-right">
        <div class="image-wrapper">
            <img src="{{ asset('img/hoodie.jpg') }}" alt="Product Image" class="blurred-image" />
            <div class="promo-text">Build your<br>fashion brand</div>
            <div class="footer-text">AES-256 Grey Stone Hoodie<br>Made with BMT Fashion</div>
        </div>
    </div>
</div>

<style>
    /* Social Login Styles */
    .social-login {
        text-align: center;
    }
    
    .divider {
        display: flex;
        align-items: center;
        margin: 20px 0;
    }
    
    .divider::before, .divider::after {
        content: "";
        flex: 1;
        border-bottom: 1px solid #ddd;
    }
    
    .divider-text {
        padding: 0 10px;
        color: #6c757d;
        font-size: 14px;
    }
    
    .social-btn {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        width: 40px;
        height: 40px;
        border-radius: 50%;
        text-decoration: none;
        transition: all 0.3s ease;
    }
    
    .social-btn:hover {
        transform: translateY(-2px);
    }
    
    .social-btn.google {
        background-color: #fff;
        border: 1px solid #ddd;
        color: #db4437;
    }
    
    .social-btn.facebook {
        background-color: #1877f2;
        color: white;
    }
    
    .social-btn.twitter {
        background-color: #1da1f2;
        color: white;
    }
</style>
@endsection