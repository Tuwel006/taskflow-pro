<div class="dropdown">
    <div class="nav-user-dropdown" data-bs-toggle="dropdown">
        <div class="nav-user-img">
            <x-user-avatar :user="auth()->user()" size="28px" fontsize="0.75rem" />
        </div>
        <div class="nav-user-meta d-none d-sm-block">
            <span class="nav-user-name">{{ auth()->user()->name ?? 'Administrator' }}</span>
        </div>
        <i class="bi bi-chevron-down ms-1" style="font-size: 0.7rem; color: #94a3b8;"></i>
    </div>
    <ul class="dropdown-menu dropdown-menu-end"
        style="font-size: 0.8125rem; border-radius: 8px; border: 1px solid #e2e8f0; box-shadow: 0 4px 6px -1px rgba(0,0,0,0.1);">
        <li><a class="dropdown-item"
                href="{{ auth()->user()->type === \App\UserType::Client ? route('client.profile') : route('profile') }}" wire:navigate><i
                    class="bi bi-person me-2"></i> Settings</a></li>
        <li><a class="dropdown-item" href="#"><i class="bi bi-shield-lock me-2"></i> Security</a></li>
        <li>
            <hr class="dropdown-divider">
        </li>
        <li>
            <button class="dropdown-item text-danger" wire:click="logout">
                <i class="bi bi-box-arrow-right me-2"></i> Sign Out
            </button>
        </li>
    </ul>
</div>
