<div>
    <x-dropdown align="right" width="80">
        <x-slot name="trigger">
            <button class="nav-btn-icon position-relative" title="Notifications">
                <i class="bi bi-bell"></i>
                @if($unreadCount > 0)
                    <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger shadow-sm" style="font-size: 0.6rem; padding: 0.25em 0.4em;">
                        {{ $unreadCount > 9 ? '9+' : $unreadCount }}
                    </span>
                @endif
            </button>
        </x-slot>

        <x-slot name="content">
            <div class="px-3 py-2 border-bottom d-flex justify-content-between align-items-center bg-light">
                <h6 class="mb-0 fw-bold" style="font-size: 0.8125rem; color: #0f172a;">Notifications</h6>
                @if($unreadCount > 0)
                    <button wire:click="markAllAsRead" class="btn btn-link p-0 text-decoration-none" style="font-size: 0.7rem; font-weight: 600; color: #3b82f6;">
                        Clear All
                    </button>
                @endif
            </div>

            <div style="max-height: 350px; overflow-y: auto;">
                @forelse($notifications as $notification)
                    <div class="px-3 py-3 border-bottom dropdown-item-custom transition-all" 
                         wire:click="markAsRead('{{ $notification->id }}')" 
                         style="cursor: pointer; border-left: 3px solid {{ $notification->read_at ? 'transparent' : '#3b82f6' }}; background: {{ $notification->read_at ? '#fff' : '#f8fafc' }};">
                        <div class="d-flex gap-3">
                            <div class="flex-shrink-0 mt-1">
                                @php
                                    $priority = $notification->data['task_priority'] ?? 'Medium';
                                    $iconColor = match($priority) {
                                        'Urgent' => '#ef4444',
                                        'High' => '#f59e0b',
                                        'Medium' => '#3b82f6',
                                        'Low' => '#10b981',
                                        default => '#64748b'
                                    };
                                @endphp
                                <div class="rounded-circle d-flex align-items-center justify-content-center shadow-sm" style="width: 32px; height: 32px; background: {{ $iconColor }}15; color: {{ $iconColor }};">
                                    <i class="bi bi-clipboard-check" style="font-size: 0.9rem;"></i>
                                </div>
                            </div>
                            <div class="flex-grow-1">
                                <div class="d-flex justify-content-between align-items-center mb-1">
                                    <span class="fw-bold text-dark text-truncate" style="font-size: 0.8125rem; max-width: 140px;">
                                        {{ $notification->data['task_title'] ?? 'New Task' }}
                                    </span>
                                    <small class="text-muted" style="font-size: 0.65rem;">{{ $notification->created_at->diffForHumans(null, true, true) }}</small>
                                </div>
                                <p class="mb-0 text-muted text-truncate-2" style="font-size: 0.75rem; line-height: 1.3;">
                                    Assigned to you with <strong>{{ $notification->data['task_priority'] }}</strong> priority.
                                </p>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="px-3 py-5 text-center">
                        <i class="bi bi-bell-slash mb-2 d-block text-muted opacity-25" style="font-size: 2rem;"></i>
                        <p class="text-muted mb-0" style="font-size: 0.8125rem;">No new notifications</p>
                    </div>
                @endforelse
            </div>

            @if($notifications->isNotEmpty())
                <div class="px-3 py-2 text-center bg-light border-top">
                    <a href="#" class="text-decoration-none fw-bold" style="font-size: 0.75rem; color: #475569;">Show All Activities</a>
                </div>
            @endif
        </x-slot>
    </x-dropdown>

    <style>
        .dropdown-item-custom:hover {
            background-color: #f1f5f9 !important;
        }
        .text-truncate-2 {
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }
    </style>
</div>
