{{-- Kjhu Theme - User Dashboard --}}
{{-- Dark Purple Gradient Design --}}

@extends('kjhu::layouts.user')

@section('title', 'Dashboard')

@section('page-title', 'Dashboard')

@section('content')
<div class="dashboard">
    <!-- Stats Overview -->
    <div class="dashboard-stats">
        <div class="stat-card">
            <div class="stat-icon">
                <i class="fas fa-server"></i>
            </div>
            <div class="stat-content">
                <span class="stat-value">{{ $stats['total_servers'] ?? 0 }}</span>
                <span class="stat-label">Total Servers</span>
            </div>
        </div>
        
        <div class="stat-card">
            <div class="stat-icon online">
                <i class="fas fa-check-circle"></i>
            </div>
            <div class="stat-content">
                <span class="stat-value">{{ $stats['online_servers'] ?? 0 }}</span>
                <span class="stat-label">Online</span>
            </div>
        </div>
        
        <div class="stat-card">
            <div class="stat-icon offline">
                <i class="fas fa-times-circle"></i>
            </div>
            <div class="stat-content">
                <span class="stat-value">{{ $stats['offline_servers'] ?? 0 }}</span>
                <span class="stat-label">Offline</span>
            </div>
        </div>
        
        <div class="stat-card">
            <div class="stat-icon resources">
                <i class="fas fa-chart-pie"></i>
            </div>
            <div class="stat-content">
                <span class="stat-value">{{ $stats['total_ram'] ?? 0 }} MB</span>
                <span class="stat-label">Total RAM</span>
            </div>
        </div>
    </div>
    
    <!-- Quick Actions -->
    <div class="quick-actions">
        <h2 class="section-title">
            <i class="fas fa-bolt"></i>
            Quick Actions
        </h2>
        <div class="actions-grid">
            <a href="{{ route('index') }}" class="action-card">
                <div class="action-icon">
                    <i class="fas fa-plus"></i>
                </div>
                <span class="action-label">Create Server</span>
            </a>
            <a href="{{ route('account.index') }}" class="action-card">
                <div class="action-icon">
                    <i class="fas fa-user-cog"></i>
                </div>
                <span class="action-label">Account</span>
            </a>
            <a href="{{ route('account.api') }}" class="action-card">
                <div class="action-icon">
                    <i class="fas fa-key"></i>
                </div>
                <span class="action-label">API Keys</span>
            </a>
            <a href="{{ route('index') }}" class="action-card">
                <div class="action-icon">
                    <i class="fas fa-headset"></i>
                </div>
                <span class="action-label">Support</span>
            </a>
        </div>
    </div>
    
    <!-- Servers List -->
    <div class="servers-section">
        <div class="section-header">
            <h2 class="section-title">
                <i class="fas fa-server"></i>
                Your Servers
            </h2>
            <div class="section-actions">
                <div class="search-box">
                    <i class="fas fa-search"></i>
                    <input type="text" placeholder="Search servers..." class="form-control">
                </div>
                <div class="filter-dropdown">
                    <select class="form-select">
                        <option value="">All Status</option>
                        <option value="online">Online</option>
                        <option value="offline">Offline</option>
                    </select>
                </div>
            </div>
        </div>
        
        <div class="servers-grid">
            @forelse($servers ?? [] as $server)
                @include('kjhu::partials.server-card', ['server' => $server])
            @empty
                <div class="empty-state">
                    <div class="empty-icon">
                        <i class="fas fa-server"></i>
                    </div>
                    <h3>No Servers Found</h3>
                    <p>You don't have any servers yet. Create your first server to get started!</p>
                    <a href="{{ route('index') }}" class="btn btn-primary">
                        <i class="fas fa-plus me-2"></i>
                        Create Server
                    </a>
                </div>
            @endforelse
        </div>
    </div>
    
    <!-- Recent Activity -->
    <div class="activity-section">
        <h2 class="section-title">
            <i class="fas fa-history"></i>
            Recent Activity
        </h2>
        <div class="activity-list">
            @forelse($activities ?? [] as $activity)
                <div class="activity-item">
                    <div class="activity-icon">
                        <i class="fas {{ $activity['icon'] ?? 'fa-circle' }}"></i>
                    </div>
                    <div class="activity-content">
                        <p class="activity-message">{{ $activity['message'] }}</p>
                        <span class="activity-time">{{ $activity['time'] ?? 'Just now' }}</span>
                    </div>
                </div>
            @empty
                <div class="empty-activity">
                    <p>No recent activity</p>
                </div>
            @endforelse
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
    .dashboard {
        padding: 24px;
    }
    
    /* Stats Grid */
    .dashboard-stats {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(240px, 1fr));
        gap: 20px;
        margin-bottom: 32px;
    }
    
    .stat-card {
        background: var(--kjhu-bg-card);
        border: 1px solid var(--kjhu-border);
        border-radius: var(--kjhu-radius);
        padding: 24px;
        display: flex;
        align-items: center;
        gap: 16px;
        transition: all 0.3s ease;
    }
    
    .stat-card:hover {
        border-color: var(--kjhu-primary);
        transform: translateY(-2px);
        box-shadow: var(--kjhu-glow);
    }
    
    .stat-icon {
        width: 56px;
        height: 56px;
        background: var(--kjhu-gradient);
        border-radius: var(--kjhu-radius-sm);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 24px;
        color: white;
    }
    
    .stat-icon.online {
        background: linear-gradient(135deg, var(--kjhu-success), #059669);
    }
    
    .stat-icon.offline {
        background: linear-gradient(135deg, var(--kjhu-danger), #DC2626);
    }
    
    .stat-icon.resources {
        background: linear-gradient(135deg, var(--kjhu-info), #2563EB);
    }
    
    .stat-value {
        display: block;
        font-size: 28px;
        font-weight: 700;
        color: var(--kjhu-text-primary);
    }
    
    .stat-label {
        font-size: 14px;
        color: var(--kjhu-text-muted);
    }
    
    /* Quick Actions */
    .quick-actions {
        margin-bottom: 32px;
    }
    
    .section-title {
        font-size: 20px;
        font-weight: 600;
        color: var(--kjhu-text-primary);
        margin-bottom: 20px;
        display: flex;
        align-items: center;
        gap: 12px;
    }
    
    .section-title i {
        color: var(--kjhu-primary);
    }
    
    .actions-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(150px, 1fr));
        gap: 16px;
    }
    
    .action-card {
        background: var(--kjhu-bg-card);
        border: 1px solid var(--kjhu-border);
        border-radius: var(--kjhu-radius);
        padding: 24px;
        text-align: center;
        text-decoration: none;
        transition: all 0.3s ease;
    }
    
    .action-card:hover {
        border-color: var(--kjhu-primary);
        transform: translateY(-4px);
        box-shadow: var(--kjhu-glow);
    }
    
    .action-icon {
        width: 48px;
        height: 48px;
        background: var(--kjhu-gradient);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 12px;
        font-size: 20px;
        color: white;
    }
    
    .action-label {
        color: var(--kjhu-text-primary);
        font-weight: 500;
    }
    
    /* Servers Section */
    .servers-section {
        margin-bottom: 32px;
    }
    
    .section-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 20px;
        flex-wrap: wrap;
        gap: 16px;
    }
    
    .section-actions {
        display: flex;
        gap: 12px;
    }
    
    .search-box {
        position: relative;
    }
    
    .search-box i {
        position: absolute;
        left: 12px;
        top: 50%;
        transform: translateY(-50%);
        color: var(--kjhu-text-muted);
    }
    
    .search-box .form-control {
        padding-left: 40px;
        width: 250px;
    }
    
    .servers-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(350px, 1fr));
        gap: 20px;
    }
    
    /* Empty State */
    .empty-state {
        grid-column: 1 / -1;
        text-align: center;
        padding: 60px 20px;
        background: var(--kjhu-bg-card);
        border: 1px dashed var(--kjhu-border);
        border-radius: var(--kjhu-radius);
    }
    
    .empty-icon {
        width: 80px;
        height: 80px;
        background: var(--kjhu-bg-card-hover);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 24px;
        font-size: 32px;
        color: var(--kjhu-text-muted);
    }
    
    .empty-state h3 {
        color: var(--kjhu-text-primary);
        margin-bottom: 8px;
    }
    
    .empty-state p {
        color: var(--kjhu-text-muted);
        margin-bottom: 24px;
    }
    
    /* Activity Section */
    .activity-section {
        background: var(--kjhu-bg-card);
        border: 1px solid var(--kjhu-border);
        border-radius: var(--kjhu-radius);
        padding: 24px;
    }
    
    .activity-list {
        display: flex;
        flex-direction: column;
        gap: 16px;
    }
    
    .activity-item {
        display: flex;
        align-items: center;
        gap: 16px;
        padding: 16px;
        background: var(--kjhu-bg-card-hover);
        border-radius: var(--kjhu-radius-sm);
    }
    
    .activity-icon {
        width: 40px;
        height: 40px;
        background: var(--kjhu-gradient);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-size: 14px;
    }
    
    .activity-message {
        color: var(--kjhu-text-primary);
        margin: 0;
    }
    
    .activity-time {
        font-size: 12px;
        color: var(--kjhu-text-muted);
    }
    
    .empty-activity {
        text-align: center;
        padding: 40px;
        color: var(--kjhu-text-muted);
    }
    
    /* Responsive */
    @media (max-width: 768px) {
        .dashboard {
            padding: 16px;
        }
        
        .section-header {
            flex-direction: column;
            align-items: flex-start;
        }
        
        .section-actions {
            width: 100%;
        }
        
        .search-box {
            width: 100%;
        }
        
        .search-box .form-control {
            width: 100%;
        }
        
        .servers-grid {
            grid-template-columns: 1fr;
        }
    }
</style>
@endpush
