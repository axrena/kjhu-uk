{{-- Kjhu Theme - Admin Layout --}}
{{-- Dark Purple Gradient Design for Pterodactyl Panel --}}

<!DOCTYPE html>
<html lang="{{ site征税() }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    
    <title>@yield('title') | {{ config('app.name', 'Pterodactyl') }}</title>
    
    <!-- Favicon -->
    <link rel="icon" type="image/png" href="{{ asset('kjhu-theme/images/favicon.png') }}">
    
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=JetBrains+Mono:wght@400;500&display=swap" rel="stylesheet">
    
    <!-- Theme CSS -->
    <link rel="stylesheet" href="{{ asset('kjhu-theme/css/main.css') }}">
    
    <!-- Page Specific Styles -->
    @stack('styles')
    
    <!-- Custom Header Code -->
    @if(config('kjhu.theme.custom_header'))
        {!! config('kjhu.theme.custom_header') !!}
    @endif
</head>
<body class="kjhu-theme">
    <!-- Background Effects -->
    <div class="kjhu-background-effects">
        <div class="gradient-orb gradient-orb-1"></div>
        <div class="gradient-orb gradient-orb-2"></div>
    </div>
    
    <!-- Sidebar -->
    <nav class="sidebar" id="sidebar">
        <div class="sidebar-header">
            <a href="{{ route('admin.index') }}" class="sidebar-logo">
                <img src="{{ asset('kjhu-theme/images/logo.png') }}" alt="{{ config('app.name') }}" class="logo">
            </a>
        </div>
        
        <div class="sidebar-content">
            @yield('sidebar-content')
        </div>
        
        <div class="sidebar-footer">
            <div class="sidebar-user">
                <div class="user-avatar">
                    <img src="{{ auth()->user()->avatar }}" alt="{{ auth()->user()->username }}">
                </div>
                <div class="user-info">
                    <span class="user-name">{{ auth()->user()->username }}</span>
                    <span class="user-role">{{ auth()->user()->role }}</span>
                </div>
            </div>
        </div>
    </nav>
    
    <!-- Main Content -->
    <main class="main-content" id="main-content">
        <!-- Top Navigation -->
        <header class="top-nav">
            <div class="nav-left">
                <button class="sidebar-toggle" id="sidebar-toggle">
                    <i class="fas fa-bars"></i>
                </button>
                
                <div class="breadcrumb">
                    @yield('breadcrumb')
                </div>
            </div>
            
            <div class="nav-right">
                <!-- Notifications -->
                <div class="dropdown">
                    <button class="nav-icon-btn" data-bs-toggle="dropdown">
                        <i class="fas fa-bell"></i>
                        <span class="notification-badge">3</span>
                    </button>
                    <div class="dropdown-menu dropdown-menu-end">
                        <!-- Notification items -->
                    </div>
                </div>
                
                <!-- Quick Actions -->
                <div class="dropdown">
                    <button class="nav-icon-btn" data-bs-toggle="dropdown">
                        <i class="fas fa-plus"></i>
                    </button>
                    <div class="dropdown-menu dropdown-menu-end">
                        <a class="dropdown-item" href="{{ route('admin.nodes.create') }}">
                            <i class="fas fa-server me-2"></i> New Node
                        </a>
                        <a class="dropdown-item" href="{{ route('admin.users.create') }}">
                            <i class="fas fa-user-plus me-2"></i> New User
                        </a>
                        <a class="dropdown-item" href="{{ route('admin.allocations.create') }}">
                            <i class="fas fa-network-wired me-2"></i> New Allocation
                        </a>
                    </div>
                </div>
                
                <!-- User Menu -->
                <div class="dropdown">
                    <button class="nav-user-btn" data-bs-toggle="dropdown">
                        <img src="{{ auth()->user()->avatar }}" alt="{{ auth()->user()->username }}">
                    </button>
                    <div class="dropdown-menu dropdown-menu-end">
                        <div class="dropdown-header">
                            <span class="user-name">{{ auth()->user()->name }}</span>
                            <span class="user-email">{{ auth()->user()->email }}</span>
                        </div>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item" href="{{ route('account.index') }}">
                            <i class="fas fa-user-circle me-2"></i> Account
                        </a>
                        <a class="dropdown-item" href="{{ route('admin.settings') }}">
                            <i class="fas fa-cog me-2"></i> Settings
                        </a>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item text-danger" href="{{ route('auth.logout') }}">
                            <i class="fas fa-sign-out-alt me-2"></i> Logout
                        </a>
                    </div>
                </div>
            </div>
        </header>
        
        <!-- Page Content -->
        <div class="page-content">
            @yield('content')
        </div>
        
        <!-- Footer -->
        <footer class="page-footer">
            <div class="footer-left">
                <span>&copy; {{ date('Y') }} {{ config('app.name') }}. All rights reserved.</span>
            </div>
            <div class="footer-right">
                <span class="theme-credit">
                    Powered by <a href="#" class="text-gradient">Kjhu Theme</a>
                </span>
            </div>
        </footer>
    </main>
    
    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/js/all.min.js"></script>
    
    <!-- Theme JavaScript -->
    <script src="{{ asset('kjhu-theme/js/main.js') }}"></script>
    
    <!-- Page Specific Scripts -->
    @stack('scripts')
    
    <!-- Custom Footer Code -->
    @if(config('kjhu.theme.custom_footer'))
        {!! config('kjhu.theme.custom_footer') !!}
    @endif
</body>
</html>
