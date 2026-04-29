{{-- Client Dedicated Sidebar --}}
<style>
    #sidebar {
        width: 240px;
        min-height: 100vh;
        background: #ffffff;
        display: flex;
        flex-direction: column;
        border-right: 1px solid #e0f2fe;
        position: relative;
        z-index: 100;
        flex-shrink: 0;
    }

    .sidebar-brand {
        padding: 1.25rem 1rem;
        border-bottom: 1px solid #f1f5f9;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .sidebar-brand .brand-icon {
        width: 32px;
        height: 32px;
        background: #10b981; /* Emerald for Client Portal */
        border-radius: 6px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1rem;
        color: #fff;
    }

    .sidebar-brand .brand-text {
        font-size: 0.95rem;
        font-weight: 700;
        color: #0f172a;
        letter-spacing: -0.01em;
    }

    .nav-label {
        font-size: 0.65rem;
        font-weight: 700;
        letter-spacing: 0.05em;
        text-transform: uppercase;
        color: #94a3b8;
        padding: 1.5rem 1rem 0.5rem;
    }

    .sidebar-nav .nav-link {
        display: flex;
        align-items: center;
        gap: 0.75rem;
        padding: 0.5rem 0.75rem;
        margin: 0.125rem 0.5rem;
        border-radius: 8px;
        color: #64748b;
        font-size: 0.8125rem;
        font-weight: 500;
        transition: all 0.2s ease;
        text-decoration: none;
    }

    .sidebar-nav .nav-link .nav-icon {
        width: 20px;
        height: 20px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.1rem;
        opacity: 0.7;
    }

    .sidebar-nav .nav-link:hover {
        color: #10b981;
        background: #f0fdf4;
    }

    .sidebar-nav .nav-link.active {
        color: #065f46;
        background: #d1fae5;
        font-weight: 600;
    }

    .sidebar-nav .nav-link.active .nav-icon {
        color: #10b981;
        opacity: 1;
    }

    .sidebar-footer {
        margin-top: auto;
        padding: 1rem;
        background: #f8fafc;
        border-top: 1px solid #f1f5f9;
    }

    .user-compact {
        display: flex;
        align-items: center;
        gap: 0.6rem;
    }
</style>

<div id="sidebar">
    <div class="sidebar-brand">
        <div class="brand-icon">
            <i class="bi bi-shield-lock-fill"></i>
        </div>
        <span class="brand-text">Stakeholder Portal</span>
    </div>

    <div class="nav-label">Main View</div>
    <nav class="sidebar-nav">
        <a href="/client/dashboard" wire:navigate class="nav-link {{ request()->is('client/dashboard') ? 'active' : '' }}">
            <span class="nav-icon"><i class="bi bi-grid-1x2"></i></span>
            Overview
        </a>
    </nav>

    <div class="nav-label">Engagement</div>
    <nav class="sidebar-nav">
        <a href="/client/projects" wire:navigate class="nav-link {{ request()->is('client/projects*') ? 'active' : '' }}">
            <span class="nav-icon"><i class="bi bi-folder2"></i></span>
            Projects
        </a>
        <a href="#" wire:navigate class="nav-link">
            <span class="nav-icon"><i class="bi bi-calendar4-event"></i></span>
            Schedule
        </a>
        <a href="/client/tasks" wire:navigate class="nav-link {{ request()->is('client/tasks*') ? 'active' : '' }}">
            <span class="nav-icon"><i class="bi bi-list-check"></i></span>
            Tasks
        </a>
    </nav>

    <div class="sidebar-footer">
        <div class="user-compact">
            <x-user-avatar :user="auth()->user()" size="28px" />
            <div class="user-info-sm text-truncate">
                <div class="user-name-sm">{{ auth()->user()->name }}</div>
                <div class="user-role-sm">Client Account</div>
            </div>
        </div>
    </div>
</div>
