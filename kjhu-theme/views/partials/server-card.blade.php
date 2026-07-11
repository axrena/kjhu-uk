{{-- Kjhu Theme - Server Card Component --}}
{{-- Dark Purple Gradient Design --}}

@props([
    'server' => null,
    'name' => 'Unknown Server',
    'description' => '',
    'status' => 'offline',
    'uuid' => '',
    'identifier' => '',
    'node' => 'Unknown Node',
    'ram' => 0,
    'disk' => 0,
    'cpu' => 0,
    'image' => null
])

<div class="server-card" data-status="{{ $status }}">
    <!-- Header -->
    <div class="server-card-header">
        <div class="server-info">
            <div class="server-icon">
                @if($image)
                    <img src="{{ $image }}" alt="{{ $name }}">
                @else
                    <i class="fas fa-cube"></i>
                @endif
            </div>
            <div class="server-details">
                <h3 class="server-name">{{ $name }}</h3>
                <span class="server-node">{{ $node }}</span>
            </div>
        </div>
        <div class="server-status">
            <span class="status-indicator status-{{ $status }}">
                <span class="status-dot"></span>
                {{ ucfirst($status) }}
            </span>
        </div>
    </div>
    
    <!-- Description -->
    @if($description)
        <div class="server-description">
            <p>{{ Str::limit($description, 80) }}</p>
        </div>
    @endif
    
    <!-- Resources -->
    <div class="server-resources">
        <!-- CPU -->
        <div class="resource-item">
            <div class="resource-header">
                <i class="fas fa-microchip"></i>
                <span>CPU</span>
            </div>
            <div class="resource-bar">
                <div class="resource-fill cpu-fill" style="width: 0%"></div>
            </div>
            <span class="resource-value">{{ $cpu }}%</span>
        </div>
        
        <!-- RAM -->
        <div class="resource-item">
            <div class="resource-header">
                <i class="fas fa-memory"></i>
                <span>RAM</span>
            </div>
            <div class="resource-bar">
                <div class="resource-fill ram-fill" style="width: 0%"></div>
            </div>
            <span class="resource-value">{{ $ram }} MB</span>
        </div>
        
        <!-- Disk -->
        <div class="resource-item">
            <div class="resource-header">
                <i class="fas fa-hdd"></i>
                <span>Disk</span>
            </div>
            <div class="resource-bar">
                <div class="resource-fill disk-fill" style="width: 0%"></div>
            </div>
            <span class="resource-value">{{ $disk }} MB</span>
        </div>
    </div>
    
    <!-- Actions -->
    <div class="server-actions">
        @if($status === 'offline')
            <button class="btn btn-success btn-sm btn-action" data-action="start">
                <i class="fas fa-play"></i>
                <span>Start</span>
            </button>
        @elseif($status === 'running')
            <button class="btn btn-warning btn-sm btn-action" data-action="restart">
                <i class="fas fa-redo"></i>
                <span>Restart</span>
            </button>
            <button class="btn btn-danger btn-sm btn-action" data-action="stop">
                <i class="fas fa-stop"></i>
                <span>Stop</span>
            </button>
        @elseif($status === 'starting')
            <button class="btn btn-secondary btn-sm btn-action" disabled>
                <i class="fas fa-spinner fa-spin"></i>
                <span>Starting...</span>
            </button>
        @elseif($status === 'stopping')
            <button class="btn btn-secondary btn-sm btn-action" disabled>
                <i class="fas fa-spinner fa-spin"></i>
                <span>Stopping...</span>
            </button>
        @endif
        
        <a href="{{ route('server.show', $identifier ?? $uuid) }}" class="btn btn-primary btn-sm btn-action">
            <i class="fas fa-terminal"></i>
            <span>Console</span>
        </a>
        
        <div class="dropdown">
            <button class="btn btn-secondary btn-sm btn-icon dropdown-toggle" data-bs-toggle="dropdown">
                <i class="fas fa-ellipsis-v"></i>
            </button>
            <div class="dropdown-menu dropdown-menu-end">
                <a class="dropdown-item" href="{{ route('server.settings', $identifier ?? $uuid) }}">
                    <i class="fas fa-cog me-2"></i> Settings
                </a>
                <a class="dropdown-item" href="{{ route('server.files', $identifier ?? $uuid) }}">
                    <i class="fas fa-folder me-2"></i> Files
                </a>
                <a class="dropdown-item" href="{{ route('server.databases', $identifier ?? $uuid) }}">
                    <i class="fas fa-database me-2"></i> Databases
                </a>
                <a class="dropdown-item" href="{{ route('server.schedules', $identifier ?? $uuid) }}">
                    <i class="fas fa-clock me-2"></i> Schedules
                </a>
                <div class="dropdown-divider"></div>
                <a class="dropdown-item text-danger" href="#">
                    <i class="fas fa-trash me-2"></i> Delete
                </a>
            </div>
        </div>
    </div>
</div>
