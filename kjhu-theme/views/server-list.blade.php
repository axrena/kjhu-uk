{{-- Kjhu Theme - Server List Page --}}
{{-- Dark Purple Gradient Design --}}

@extends('kjhu::layouts.user')

@section('title', 'My Servers')

@section('page-title', 'My Servers')

@section('content')
<div class="servers-page">
    <!-- Page Header -->
    <div class="page-header">
        <div class="header-left">
            <h1 class="page-title">
                <i class="fas fa-server"></i>
                My Servers
            </h1>
            <p class="page-subtitle">Manage and monitor your game servers</p>
        </div>
        <div class="header-right">
            <a href="{{ route('index') }}" class="btn btn-primary">
                <i class="fas fa-plus"></i>
                Create Server
            </a>
        </div>
    </div>
    
    <!-- Filters -->
    <div class="filters-bar">
        <div class="search-box">
            <i class="fas fa-search"></i>
            <input 
                type="text" 
                id="serverSearch" 
                placeholder="Search servers by name or node..." 
                class="form-control"
            >
        </div>
        
        <div class="filter-group">
            <select class="form-select" id="statusFilter">
                <option value="">All Status</option>
                <option value="online">Online</option>
                <option value="offline">Offline</option>
                <option value="starting">Starting</option>
                <option value="stopping">Stopping</option>
            </select>
            
            <select class="form-select" id="sortBy">
                <option value="name">Sort by Name</option>
                <option value="status">Sort by Status</option>
                <option value="node">Sort by Node</option>
                <option value="created">Sort by Created</option>
            </select>
        </div>
        
        <div class="view-toggle">
            <button class="view-btn active" data-view="grid">
                <i class="fas fa-th-large"></i>
            </button>
            <button class="view-btn" data-view="list">
                <i class="fas fa-list"></i>
            </button>
        </div>
    </div>
    
    <!-- Servers Grid -->
    <div class="servers-container" id="serversContainer">
        @forelse($servers as $server)
            <div class="server-card" data-status="{{ $server->status }}" data-name="{{ strtolower($server->name) }}">
                <!-- Card Header -->
                <div class="server-card-header">
                    <div class="server-info">
                        <div class="server-icon">
                            <i class="fas fa-cube"></i>
                        </div>
                        <div class="server-details">
                            <h3 class="server-name">{{ $server->name }}</h3>
                            <span class="server-node">{{ $server->node->name }}</span>
                        </div>
                    </div>
                    <div class="server-status">
                        <span class="status-indicator status-{{ $server->status }}">
                            <span class="status-dot"></span>
                            {{ ucfirst($server->status) }}
                        </span>
                    </div>
                </div>
                
                <!-- Description -->
                @if($server->description)
                    <div class="server-description">
                        <p>{{ Str::limit($server->description, 100) }}</p>
                    </div>
                @endif
                
                <!-- Quick Stats -->
                <div class="server-quick-stats">
                    <div class="quick-stat">
                        <i class="fas fa-microchip"></i>
                        <span>{{ $server->cpu }}%</span>
                    </div>
                    <div class="quick-stat">
                        <i class="fas fa-memory"></i>
                        <span>{{ $server->ram }}MB</span>
                    </div>
                    <div class="quick-stat">
                        <i class="fas fa-hdd"></i>
                        <span>{{ $server->disk }}MB</span>
                    </div>
                </div>
                
                <!-- Resource Usage -->
                <div class="server-resources">
                    <div class="resource-item">
                        <div class="resource-header">
                            <span>CPU</span>
                        </div>
                        <div class="resource-bar">
                            <div class="resource-fill cpu-fill" style="width: {{ $server->cpu }}%"></div>
                        </div>
                    </div>
                    <div class="resource-item">
                        <div class="resource-header">
                            <span>RAM</span>
                        </div>
                        <div class="resource-bar">
                            <div class="resource-fill ram-fill" style="width: {{ ($server->memory_usage / $server->ram) * 100 }}%"></div>
                        </div>
                    </div>
                    <div class="resource-item">
                        <div class="resource-header">
                            <span>Disk</span>
                        </div>
                        <div class="resource-bar">
                            <div class="resource-fill disk-fill" style="width: {{ ($server->disk_usage / $server->disk) * 100 }}%"></div>
                        </div>
                    </div>
                </div>
                
                <!-- Actions -->
                <div class="server-actions">
                    @if($server->status === 'offline')
                        <button class="btn btn-success btn-sm btn-action" data-action="start" data-server="{{ $server->uuid }}">
                            <i class="fas fa-play"></i>
                            <span>Start</span>
                        </button>
                    @elseif($server->status === 'running')
                        <button class="btn btn-warning btn-sm btn-action" data-action="restart" data-server="{{ $server->uuid }}">
                            <i class="fas fa-redo"></i>
                        </button>
                        <button class="btn btn-danger btn-sm btn-action" data-action="stop" data-server="{{ $server->uuid }}">
                            <i class="fas fa-stop"></i>
                        </button>
                    @else
                        <button class="btn btn-secondary btn-sm btn-action" disabled>
                            <i class="fas fa-spinner fa-spin"></i>
                        </button>
                    @endif
                    
                    <a href="{{ route('server.show', $server->uuidShort) }}" class="btn btn-primary btn-sm btn-action">
                        <i class="fas fa-terminal"></i>
                        <span>Console</span>
                    </a>
                    
                    <div class="dropdown">
                        <button class="btn btn-secondary btn-sm btn-icon dropdown-toggle" data-bs-toggle="dropdown">
                            <i class="fas fa-ellipsis-v"></i>
                        </button>
                        <div class="dropdown-menu dropdown-menu-end">
                            <a class="dropdown-item" href="{{ route('server.show', $server->uuidShort) }}">
                                <i class="fas fa-terminal me-2"></i> Console
                            </a>
                            <a class="dropdown-item" href="{{ route('server.files', $server->uuidShort) }}">
                                <i class="fas fa-folder me-2"></i> Files
                            </a>
                            <a class="dropdown-item" href="{{ route('server.databases', $server->uuidShort) }}">
                                <i class="fas fa-database me-2"></i> Databases
                            </a>
                            <a class="dropdown-item" href="{{ route('server.schedules', $server->uuidShort) }}">
                                <i class="fas fa-clock me-2"></i> Schedules
                            </a>
                            <a class="dropdown-item" href="{{ route('server.backups', $server->uuidShort) }}">
                                <i class="fas fa-download me-2"></i> Backups
                            </a>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item" href="{{ route('server.settings', $server->uuidShort) }}">
                                <i class="fas fa-cog me-2"></i> Settings
                            </a>
                        </div>
                    </div>
                </div>
                
                <!-- Footer -->
                <div class="server-footer">
                    <span class="server-created">
                        <i class="fas fa-calendar"></i>
                        {{ $server->created_at->diffForHumans() }}
                    </span>
                    <span class="server-identifier">
                        {{ $server->identifier }}
                    </span>
                </div>
            </div>
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
    
    <!-- Pagination -->
    @if($servers->hasPages())
        <div class="pagination-wrapper">
            {{ $servers->links() }}
        </div>
    @endif
</div>
@endsection

@push('styles')
<style>
    .servers-page {
        max-width: 1400px;
        margin: 0 auto;
    }
    
    .page-header {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        margin-bottom: 32px;
        flex-wrap: wrap;
        gap: 20px;
    }
    
    .page-title {
        font-size: 28px;
        font-weight: 700;
        color: var(--kjhu-text-primary);
        margin: 0 0 8px 0;
        display: flex;
        align-items: center;
        gap: 12px;
    }
    
    .page-title i {
        color: var(--kjhu-primary);
    }
    
    .page-subtitle {
        color: var(--kjhu-text-muted);
        margin: 0;
    }
    
    /* Filters */
    .filters-bar {
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 16px;
        margin-bottom: 24px;
        flex-wrap: wrap;
    }
    
    .search-box {
        position: relative;
        flex: 1;
        max-width: 400px;
    }
    
    .search-box i {
        position: absolute;
        left: 14px;
        top: 50%;
        transform: translateY(-50%);
        color: var(--kjhu-text-muted);
    }
    
    .search-box .form-control {
        padding-left: 42px;
        width: 100%;
    }
    
    .filter-group {
        display: flex;
        gap: 12px;
    }
    
    .filter-group .form-select {
        min-width: 150px;
    }
    
    .view-toggle {
        display: flex;
        gap: 4px;
        background: var(--kjhu-bg-card);
        border: 1px solid var(--kjhu-border);
        border-radius: var(--kjhu-radius-sm);
        padding: 4px;
    }
    
    .view-btn {
        width: 36px;
        height: 36px;
        background: transparent;
        border: none;
        border-radius: 6px;
        color: var(--kjhu-text-muted);
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: all 0.2s ease;
    }
    
    .view-btn:hover {
        color: var(--kjhu-text-primary);
    }
    
    .view-btn.active {
        background: var(--kjhu-gradient);
        color: white;
    }
    
    /* Servers Container */
    .servers-container {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(380px, 1fr));
        gap: 24px;
    }
    
    .servers-container.list-view {
        grid-template-columns: 1fr;
    }
    
    .servers-container.list-view .server-card {
        display: flex;
        flex-wrap: wrap;
    }
    
    /* Empty State */
    .empty-state {
        grid-column: 1 / -1;
        text-align: center;
        padding: 80px 40px;
        background: var(--kjhu-bg-card);
        border: 1px dashed var(--kjhu-border);
        border-radius: var(--kjhu-radius-lg);
    }
    
    .empty-icon {
        width: 100px;
        height: 100px;
        background: linear-gradient(135deg, var(--kjhu-bg-card-hover), var(--kjhu-bg-sidebar));
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 32px;
        font-size: 40px;
        color: var(--kjhu-text-muted);
    }
    
    .empty-state h3 {
        font-size: 24px;
        color: var(--kjhu-text-primary);
        margin-bottom: 12px;
    }
    
    .empty-state p {
        color: var(--kjhu-text-muted);
        margin-bottom: 32px;
        max-width: 400px;
        margin-left: auto;
        margin-right: auto;
    }
    
    /* Server Quick Stats */
    .server-quick-stats {
        display: flex;
        gap: 16px;
        padding: 12px 16px;
        background: var(--kjhu-bg-darker);
        border-radius: var(--kjhu-radius-sm);
        margin-bottom: 16px;
    }
    
    .quick-stat {
        display: flex;
        align-items: center;
        gap: 6px;
        font-size: 13px;
        color: var(--kjhu-text-secondary);
    }
    
    .quick-stat i {
        color: var(--kjhu-primary);
        width: 14px;
    }
    
    /* Server Footer */
    .server-footer {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding-top: 16px;
        border-top: 1px solid var(--kjhu-border);
        margin-top: 16px;
    }
    
    .server-created {
        display: flex;
        align-items: center;
        gap: 6px;
        font-size: 12px;
        color: var(--kjhu-text-muted);
    }
    
    .server-identifier {
        font-size: 11px;
        color: var(--kjhu-text-muted);
        font-family: monospace;
    }
    
    /* Pagination */
    .pagination-wrapper {
        margin-top: 32px;
        display: flex;
        justify-content: center;
    }
    
    /* Responsive */
    @media (max-width: 768px) {
        .page-header {
            flex-direction: column;
            align-items: stretch;
        }
        
        .header-right {
            width: 100%;
        }
        
        .header-right .btn {
            width: 100%;
        }
        
        .filters-bar {
            flex-direction: column;
            align-items: stretch;
        }
        
        .search-box {
            max-width: none;
        }
        
        .filter-group {
            flex-wrap: wrap;
        }
        
        .servers-container {
            grid-template-columns: 1fr;
        }
    }
</style>
@endpush

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Search functionality
    const searchInput = document.getElementById('serverSearch');
    const serverCards = document.querySelectorAll('.server-card');
    
    searchInput?.addEventListener('input', function(e) {
        const searchTerm = e.target.value.toLowerCase();
        
        serverCards.forEach(card => {
            const name = card.dataset.name;
            const node = card.querySelector('.server-node')?.textContent.toLowerCase() || '';
            
            if (name.includes(searchTerm) || node.includes(searchTerm)) {
                card.style.display = '';
            } else {
                card.style.display = 'none';
            }
        });
    });
    
    // Status filter
    const statusFilter = document.getElementById('statusFilter');
    
    statusFilter?.addEventListener('change', function(e) {
        const status = e.target.value;
        
        serverCards.forEach(card => {
            if (!status || card.dataset.status === status) {
                card.style.display = '';
            } else {
                card.style.display = 'none';
            }
        });
    });
    
    // View toggle
    const viewBtns = document.querySelectorAll('.view-btn');
    const container = document.getElementById('serversContainer');
    
    viewBtns.forEach(btn => {
        btn.addEventListener('click', function() {
            viewBtns.forEach(b => b.classList.remove('active'));
            this.classList.add('active');
            
            if (this.dataset.view === 'list') {
                container.classList.add('list-view');
            } else {
                container.classList.remove('list-view');
            }
        });
    });
    
    // Server actions
    document.querySelectorAll('[data-action]').forEach(btn => {
        btn.addEventListener('click', async function() {
            const action = this.dataset.action;
            const serverId = this.dataset.server;
            
            if (!confirm(`Are you sure you want to ${action} this server?`)) {
                return;
            }
            
            try {
                const response = await fetch(`/api/servers/${serverId}/${action}`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content
                    }
                });
                
                if (response.ok) {
                    window.location.reload();
                } else {
                    alert('Failed to perform action');
                }
            } catch (error) {
                alert('Error: ' + error.message);
            }
        });
    });
});
</script>
@endpush
