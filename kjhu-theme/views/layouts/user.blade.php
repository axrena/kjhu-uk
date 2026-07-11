{{-- Kjhu Theme - User Layout --}}
{{-- Dark Purple Gradient Design for Pterodactyl Client Panel --}}

<!DOCTYPE html>
<html lang="{{ site_locale() }}">
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
<body class="kjhu-theme kjhu-user-theme">
    <!-- Background Effects -->
    <div class="kjhu-background-effects">
        <div class="gradient-orb gradient-orb-1"></div>
        <div class="gradient-orb gradient-orb-2"></div>
    </div>
    
    <!-- Sidebar -->
    <nav class="sidebar kjhu-user-sidebar" id="sidebar">
        <div class="sidebar-header">
            <a href="{{ route('index') }}" class="sidebar-logo">
                <img src="{{ asset('kjhu-theme/images/logo.png') }}" alt="{{ config('app.name') }}" class="logo">
            </a>
        </div>
        
        <div class="sidebar-nav">
            <div class="nav-section">
                <span class="nav-header">Main</span>
                <a href="{{ route('index') }}" class="nav-item {{ request()->routeIs('index') ? 'active' : '' }}">
                    <i class="fas fa-home"></i>
                    <span>Dashboard</span>
                </a>
            </div>
            
            <div class="nav-section">
                <span class="nav-header">Servers</span>
                <a href="{{ route('server.index') }}" class="nav-item {{ request()->routeIs('server.index') ? 'active' : '' }}">
                    <i class="fas fa-server"></i>
                    <span>My Servers</span>
                </a>
            </div>
            
            @if(auth()->user()->can('create-subuser'))
            <div class="nav-section">
                <span class="nav-header">Account</span>
                <a href="{{ route('account.index') }}" class="nav-item {{ request()->routeIs('account.index') ? 'active' : '' }}">
                    <i class="fas fa-user"></i>
                    <span>Account</span>
                </a>
                <a href="{{ route('account.security') }}" class="nav-item {{ request()->routeIs('account.security') ? 'active' : '' }}">
                    <i class="fas fa-shield-alt"></i>
                    <span>Security</span>
                </a>
                <a href="{{ route('account.api') }}" class="nav-item {{ request()->routeIs('account.api') ? 'active' : '' }}">
                    <i class="fas fa-key"></i>
                    <span>API</span>
                </a>
            </div>
            @endif
            
            @if(auth()->user()->isAdmin())
            <div class="nav-section">
                <span class="nav-header">Admin</span>
                <a href="{{ route('admin.index') }}" class="nav-item {{ request()->routeIs('admin.index') ? 'active' : '' }}">
                    <i class="fas fa-cog"></i>
                    <span>Admin Control</span>
                </a>
            </div>
            @endif
        </div>
        
        <div class="sidebar-footer">
            <div class="sidebar-user">
                <div class="user-avatar">
                    <img src="{{ auth()->user()->avatar }}" alt="{{ auth()->user()->username }}">
                </div>
                <div class="user-info">
                    <span class="user-name">{{ auth()->user()->username }}</span>
                    <span class="user-email">{{ auth()->user()->email }}</span>
                </div>
            </div>
            <a href="{{ route('auth.logout') }}" class="logout-btn">
                <i class="fas fa-sign-out-alt"></i>
                <span>Logout</span>
            </a>
        </div>
    </nav>
    
    <!-- Main Content -->
    <main class="main-content" id="main-content">
        <!-- Top Navigation -->
        <header class="top-nav kjhu-user-topnav">
            <div class="nav-left">
                <button class="sidebar-toggle" id="sidebar-toggle">
                    <i class="fas fa-bars"></i>
                </button>
                
                <div class="page-title">
                    @yield('page-title', 'Dashboard')
                </div>
            </div>
            
            <div class="nav-right">
                <!-- Quick Create -->
                <a href="{{ route('index') }}" class="btn btn-primary btn-sm">
                    <i class="fas fa-plus me-2"></i>
                    Create Server
                </a>
                
                <!-- Notifications -->
                <div class="dropdown">
                    <button class="nav-icon-btn" data-bs-toggle="dropdown">
                        <i class="fas fa-bell"></i>
                        @if(auth()->user()->unreadNotifications->count() > 0)
                        <span class="notification-badge">{{ auth()->user()->unreadNotifications->count() }}</span>
                        @endif
                    </button>
                    <div class="dropdown-menu dropdown-menu-end notifications-dropdown">
                        <div class="dropdown-header">
                            <span>Notifications</span>
                            <a href="#" class="mark-all-read">Mark all as read</a>
                        </div>
                        <div class="notifications-list">
                            @forelse(auth()->user()->unreadNotifications->take(5) as $notification)
                                <div class="notification-item">
                                    <div class="notification-icon">
                                        <i class="fas fa-bell"></i>
                                    </div>
                                    <div class="notification-content">
                                        <p>{{ $notification->data['message'] ?? 'New notification' }}</p>
                                        <span class="notification-time">{{ $notification->created_at->diffForHumans() }}</span>
                                    </div>
                                </div>
                            @empty
                                <div class="empty-notifications">
                                    <i class="fas fa-bell-slash"></i>
                                    <span>No new notifications</span>
                                </div>
                            @endforelse
                        </div>
                    </div>
                </div>
                
                <!-- User Menu -->
                <div class="dropdown">
                    <button class="nav-user-btn" data-bs-toggle="dropdown">
                        <img src="{{ auth()->user()->avatar }}" alt="{{ auth()->user()->username }}">
                        <span class="user-name">{{ auth()->user()->username }}</span>
                        <i class="fas fa-chevron-down"></i>
                    </button>
                    <div class="dropdown-menu dropdown-menu-end">
                        <a class="dropdown-item" href="{{ route('account.index') }}">
                            <i class="fas fa-user-circle me-2"></i> Account
                        </a>
                        <a class="dropdown-item" href="{{ route('account.security') }}">
                            <i class="fas fa-shield-alt me-2"></i> Security
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
