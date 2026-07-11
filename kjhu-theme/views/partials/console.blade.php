{{-- Kjhu Theme - Server Console Component --}}
{{-- Dark Purple Gradient Design --}}

@props([
    'server' => null,
    'identifier' => '',
    'status' => 'offline'
])

<div class="console-wrapper">
    <!-- Console Header -->
    <div class="console-header">
        <div class="console-info">
            <span class="console-title">
                <i class="fas fa-terminal"></i>
                Console
            </span>
            <span class="console-status status-{{ $status }}">
                <span class="status-dot"></span>
                {{ ucfirst($status) }}
            </span>
        </div>
        <div class="console-actions">
            <button class="btn btn-sm btn-secondary" id="scrollToBottom" title="Scroll to bottom">
                <i class="fas fa-arrow-down"></i>
            </button>
            <button class="btn btn-sm btn-secondary" id="clearConsole" title="Clear console">
                <i class="fas fa-trash"></i>
            </button>
            <button class="btn btn-sm btn-secondary" id="toggleAutoScroll" title="Toggle auto-scroll">
                <i class="fas fa-arrows-alt-v"></i>
            </button>
        </div>
    </div>
    
    <!-- Console Output -->
    <div class="console-output" id="consoleOutput">
        <div class="console-line system">
            <span class="timestamp">[{{ date('H:i:s') }}]</span>
            <span class="message">Console output initialized. Waiting for server...</span>
        </div>
    </div>
    
    <!-- Console Input -->
    <div class="console-input-wrapper">
        <input 
            type="text" 
            class="console-input" 
            id="consoleCommand"
            placeholder="Enter command..."
            autocomplete="off"
        >
        <button class="btn btn-primary btn-sm" id="sendCommand">
            <i class="fas fa-paper-plane"></i>
        </button>
    </div>
</div>

<style>
    .console-wrapper {
        background: var(--kjhu-bg-darker);
        border: 1px solid var(--kjhu-border);
        border-radius: var(--kjhu-radius);
        overflow: hidden;
        font-family: 'JetBrains Mono', 'Fira Code', monospace;
    }
    
    .console-header {
        background: var(--kjhu-bg-card);
        border-bottom: 1px solid var(--kjhu-border);
        padding: 12px 16px;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }
    
    .console-info {
        display: flex;
        align-items: center;
        gap: 16px;
    }
    
    .console-title {
        color: var(--kjhu-text-primary);
        font-weight: 600;
        display: flex;
        align-items: center;
        gap: 8px;
    }
    
    .console-title i {
        color: var(--kjhu-primary);
    }
    
    .console-status {
        display: flex;
        align-items: center;
        gap: 6px;
        font-size: 12px;
        padding: 4px 10px;
        border-radius: 20px;
        background: var(--kjhu-bg-card-hover);
    }
    
    .console-status .status-dot {
        width: 8px;
        height: 8px;
        border-radius: 50%;
        background: var(--kjhu-text-muted);
    }
    
    .console-status.status-online .status-dot {
        background: var(--kjhu-success);
        box-shadow: 0 0 8px var(--kjhu-success);
    }
    
    .console-status.status-offline .status-dot {
        background: var(--kjhu-danger);
    }
    
    .console-status.status-starting .status-dot,
    .console-status.status-stopping .status-dot {
        background: var(--kjhu-warning);
        animation: pulse 1s ease-in-out infinite;
    }
    
    @keyframes pulse {
        0%, 100% { opacity: 1; }
        50% { opacity: 0.5; }
    }
    
    .console-actions {
        display: flex;
        gap: 8px;
    }
    
    .console-actions .btn {
        padding: 6px 10px;
    }
    
    .console-output {
        height: 400px;
        overflow-y: auto;
        padding: 16px;
        font-size: 13px;
        line-height: 1.6;
        scroll-behavior: smooth;
    }
    
    .console-line {
        display: flex;
        gap: 12px;
        margin-bottom: 4px;
        color: var(--kjhu-text-secondary);
    }
    
    .console-line .timestamp {
        color: var(--kjhu-text-muted);
        flex-shrink: 0;
    }
    
    .console-line.system {
        color: var(--kjhu-info);
    }
    
    .console-line.command {
        color: var(--kjhu-primary);
    }
    
    .console-line.command::before {
        content: '>';
        color: var(--kjhu-success);
        margin-right: 4px;
    }
    
    .console-line.error {
        color: var(--kjhu-danger);
    }
    
    .console-line.success {
        color: var(--kjhu-success);
    }
    
    .console-line.warning {
        color: var(--kjhu-warning);
    }
    
    .console-input-wrapper {
        display: flex;
        gap: 8px;
        padding: 12px 16px;
        background: var(--kjhu-bg-card);
        border-top: 1px solid var(--kjhu-border);
    }
    
    .console-input {
        flex: 1;
        background: var(--kjhu-bg-darker);
        border: 1px solid var(--kjhu-border);
        border-radius: var(--kjhu-radius-sm);
        padding: 10px 14px;
        color: var(--kjhu-text-primary);
        font-family: 'JetBrains Mono', 'Fira Code', monospace;
        font-size: 13px;
    }
    
    .console-input:focus {
        outline: none;
        border-color: var(--kjhu-primary);
        box-shadow: 0 0 0 3px var(--kjhu-primary-glow);
    }
    
    .console-input::placeholder {
        color: var(--kjhu-text-muted);
    }
    
    /* Scrollbar */
    .console-output::-webkit-scrollbar {
        width: 6px;
    }
    
    .console-output::-webkit-scrollbar-track {
        background: transparent;
    }
    
    .console-output::-webkit-scrollbar-thumb {
        background: var(--kjhu-border);
        border-radius: 3px;
    }
</style>

@push('scripts')
<script>
(function() {
    const consoleOutput = document.getElementById('consoleOutput');
    const consoleCommand = document.getElementById('consoleCommand');
    const sendCommandBtn = document.getElementById('sendCommand');
    const scrollToBottomBtn = document.getElementById('scrollToBottom');
    const clearConsoleBtn = document.getElementById('clearConsole');
    const toggleAutoScrollBtn = document.getElementById('toggleAutoScroll');
    
    let autoScroll = true;
    
    // Scroll to bottom
    function scrollToBottom() {
        consoleOutput.scrollTop = consoleOutput.scrollHeight;
    }
    
    // Add line to console
    function addLine(message, type = 'normal') {
        const line = document.createElement('div');
        line.className = `console-line ${type}`;
        
        const timestamp = document.createElement('span');
        timestamp.className = 'timestamp';
        timestamp.textContent = `[${new Date().toLocaleTimeString()}]`;
        
        const msg = document.createElement('span');
        msg.className = 'message';
        msg.textContent = message;
        
        line.appendChild(timestamp);
        line.appendChild(msg);
        consoleOutput.appendChild(line);
        
        if (autoScroll) {
            scrollToBottom();
        }
    }
    
    // Send command
    function sendCommand() {
        const command = consoleCommand.value.trim();
        if (!command) return;
        
        addLine(command, 'command');
        consoleCommand.value = '';
        
        // Simulate command sending (replace with actual API call)
        fetch(`/api/servers/{{ $identifier }}/command`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content
            },
            body: JSON.stringify({ command })
        })
        .then(response => {
            if (!response.ok) {
                addLine('Failed to send command', 'error');
            }
        })
        .catch(error => {
            addLine('Error: ' + error.message, 'error');
        });
    }
    
    // Event listeners
    sendCommandBtn?.addEventListener('click', sendCommand);
    
    consoleCommand?.addEventListener('keypress', (e) => {
        if (e.key === 'Enter') {
            sendCommand();
        }
    });
    
    scrollToBottomBtn?.addEventListener('click', scrollToBottom);
    
    clearConsoleBtn?.addEventListener('click', () => {
        consoleOutput.innerHTML = '';
        addLine('Console cleared', 'system');
    });
    
    toggleAutoScrollBtn?.addEventListener('click', () => {
        autoScroll = !autoScroll;
        toggleAutoScrollBtn.classList.toggle('active', autoScroll);
        if (autoScroll) {
            scrollToBottom();
        }
    });
    
    // WebSocket for real-time console (if available)
    // This would connect to the server's console stream
    
})();
</script>
@endpush
