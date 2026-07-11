{{-- Kjhu Theme - Login Page --}}
{{-- Dark Purple Gradient Design for Pterodactyl Panel --}}

<!DOCTYPE html>
<html lang="{{ site_locale() }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="robots" content="noindex, nofollow">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    
    <title>Login | {{ config('app.name', 'Pterodactyl') }}</title>
    
    <!-- Favicon -->
    <link rel="icon" type="image/png" href="{{ asset('kjhu-theme/images/favicon.png') }}">
    
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- Theme CSS -->
    <link rel="stylesheet" href="{{ asset('kjhu-theme/css/main.css') }}">
    <link rel="stylesheet" href="{{ asset('kjhu-theme/css/login.css') }}">
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="login-page kjhu-login-page">
    <!-- Background Effects -->
    <div class="login-background">
        <div class="gradient-orb login-orb-1"></div>
        <div class="gradient-orb login-orb-2"></div>
        <div class="gradient-orb login-orb-3"></div>
    </div>
    
    <!-- Login Card -->
    <div class="login-container">
        <div class="login-card">
            <!-- Logo -->
            <div class="login-header">
                <div class="login-logo">
                    <img src="{{ asset('kjhu-theme/images/logo.png') }}" alt="{{ config('app.name') }}">
                </div>
                <h1 class="login-title">Welcome Back</h1>
                <p class="login-subtitle">Sign in to continue to your dashboard</p>
            </div>
            
            <!-- Session Status -->
            @if (session('status'))
                <div class="alert alert-success mb-4">
                    {{ session('status') }}
                </div>
            @endif
            
            <!-- Login Form -->
            <form method="POST" action="{{ route('auth.login') }}" class="login-form">
                @csrf
                
                <!-- Email -->
                <div class="form-group">
                    <label for="email" class="form-label">Email Address</label>
                    <div class="input-wrapper">
                        <i class="input-icon fas fa-envelope"></i>
                        <input 
                            type="email" 
                            name="email" 
                            id="email" 
                            class="form-control @error('email') is-invalid @enderror" 
                            value="{{ old('email') }}"
                            placeholder="Enter your email"
                            required 
                            autofocus
                        >
                    </div>
                    @error('email')
                        <span class="error-message">{{ $message }}</span>
                    @enderror
                </div>
                
                <!-- Password -->
                <div class="form-group">
                    <label for="password" class="form-label">Password</label>
                    <div class="input-wrapper">
                        <i class="input-icon fas fa-lock"></i>
                        <input 
                            type="password" 
                            name="password" 
                            id="password" 
                            class="form-control @error('password') is-invalid @enderror"
                            placeholder="Enter your password"
                            required
                        >
                        <button type="button" class="password-toggle" id="togglePassword">
                            <i class="fas fa-eye"></i>
                        </button>
                    </div>
                    @error('password')
                        <span class="error-message">{{ $message }}</span>
                    @enderror
                </div>
                
                <!-- Remember Me -->
                <div class="form-options">
                    <label class="checkbox-wrapper">
                        <input type="checkbox" name="remember" id="remember">
                        <span class="checkmark"></span>
                        <span class="checkbox-label">Remember me</span>
                    </label>
                    <a href="{{ route('auth.forgot-password') }}" class="forgot-link">
                        Forgot password?
                    </a>
                </div>
                
                <!-- Submit -->
                <button type="submit" class="btn btn-primary btn-login">
                    <span class="btn-text">Sign In</span>
                    <span class="btn-loader"><i class="fas fa-spinner fa-spin"></i></span>
                </button>
            </form>
            
            <!-- Footer -->
            <div class="login-footer">
                <p class="login-copyright">
                    &copy; {{ date('Y') }} {{ config('app.name') }}. All rights reserved.
                </p>
                <p class="theme-credit">
                    Powered by <a href="#" class="text-gradient">Kjhu Theme</a>
                </p>
            </div>
        </div>
        
        <!-- Features Card -->
        <div class="login-features">
            <div class="feature-item">
                <i class="fas fa-shield-alt"></i>
                <span>Secure Login</span>
            </div>
            <div class="feature-item">
                <i class="fas fa-bolt"></i>
                <span>Fast Performance</span>
            </div>
            <div class="feature-item">
                <i class="fas fa-palette"></i>
                <span>Modern Design</span>
            </div>
        </div>
    </div>
    
    <!-- Scripts -->
    <script>
        // Password toggle
        document.getElementById('togglePassword')?.addEventListener('click', function() {
            const password = document.getElementById('password');
            const icon = this.querySelector('i');
            
            if (password.type === 'password') {
                password.type = 'text';
                icon.classList.remove('fa-eye');
                icon.classList.add('fa-eye-slash');
            } else {
                password.type = 'password';
                icon.classList.remove('fa-eye-slash');
                icon.classList.add('fa-eye');
            }
        });
        
        // Form submission loading state
        document.querySelector('.login-form')?.addEventListener('submit', function() {
            const btn = this.querySelector('.btn-login');
            btn.classList.add('loading');
            btn.disabled = true;
        });
    </script>
</body>
</html>
