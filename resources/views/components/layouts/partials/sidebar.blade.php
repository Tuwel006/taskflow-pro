{{-- Sidebar --}}
<style>
    #sidebar {
        width: 240px;
        min-height: 100vh;
        background: #1e293b; /* Slate 800 */
        display: flex;
        flex-direction: column;
        border-right: 1px solid rgba(255,255,255,0.05);
        position: relative;
        z-index: 100;
        flex-shrink: 0;
    }

    /* Brand / Logo */
    .sidebar-brand {
        padding: 1.25rem 1rem;
        border-bottom: 1px solid rgba(255,255,255,0.05);
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }
    .sidebar-brand .brand-icon {
        width: 32px;
        height: 32px;
        background: #3b82f6; /* Blue 500 */
        border-radius: 6px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1rem;
        color: #fff;
    }
    .sidebar-brand .brand-text {
        font-size: 0.95rem;
        font-weight: 600;
        color: #f8fafc;
        letter-spacing: -0.01em;
    }

    /* Nav section label */
    .nav-label {
        font-size: 0.65rem;
        font-weight: 600;
        letter-spacing: 0.05em;
        text-transform: uppercase;
        color: #64748b; /* Slate 500 */
        padding: 1.5rem 1rem 0.5rem;
    }

    /* Nav links */
    .sidebar-nav .nav-link {
        display: flex;
        align-items: center;
        gap: 0.75rem;
        padding: 0.5rem 0.75rem;
        margin: 0.125rem 0.5rem;
        border-radius: 6px;
        color: #94a3b8; /* Slate 400 */
        font-size: 0.8125rem;
        font-weight: 500;
        transition: all 0.15s ease;
        text-decoration: none;
    }
    .sidebar-nav .nav-link .nav-icon {
        width: 20px;
        height: 20px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1rem;
        opacity: 0.7;
    }
    .sidebar-nav .nav-link:hover {
        color: #f8fafc;
        background: rgba(255,255,255,0.05);
    }
    .sidebar-nav .nav-link.active {
        color: #fff;
        background: #3b82f6;
    }
    .sidebar-nav .nav-link.active .nav-icon {
        opacity: 1;
    }

    /* Badge */
    .nav-badge {
        margin-left: auto;
        font-size: 0.7rem;
        padding: 0.1rem 0.4rem;
        border-radius: 4px;
        background: rgba(255,255,255,0.1);
        color: #cbd5e1;
    }

    /* Bottom footer */
    .sidebar-footer {
        margin-top: auto;
        padding: 1rem;
        background: rgba(0,0,0,0.1);
    }
    .user-compact {
        display: flex;
        align-items: center;
        gap: 0.6rem;
    }
    .user-avatar-sm {
        width: 28px;
        height: 28px;
        border-radius: 4px;
        background: #64748b;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 0.75rem;
        color: #fff;
        font-weight: 600;
    }
    .user-info-sm {
        line-height: 1.2;
        overflow: hidden;
    }
    .user-name-sm { font-size: 0.75rem; font-weight: 600; color: #f1f5f9; white-space: nowrap; text-overflow: ellipsis; overflow: hidden; }
    .user-role-sm { font-size: 0.65rem; color: #64748b; }
</style>

<div id="sidebar">
    <div class="sidebar-brand">
        <div class="brand-icon">
            <i class="bi bi-stack"></i>
        </div>
        <span class="brand-text">Taskflow Pro</span>
    </div>

    <div class="nav-label">Management</div>
    <nav class="sidebar-nav">
        <a href="/dashboard" wire:navigate class="nav-link {{ request()->is('dashboard') ? 'active' : '' }}">
            <span class="nav-icon"><i class="bi bi-speedometer2"></i></span>
            Overview
        </a>
        <a href="/tasks" wire:navigate class="nav-link {{ request()->is('tasks*') ? 'active' : '' }}">
            <span class="nav-icon"><i class="bi bi-check2-square"></i></span>
            My Tasks
            <span class="nav-badge">08</span>
        </a>
        <a href="#" wire:navigate class="nav-link">
            <span class="nav-icon"><i class="bi bi-folder2"></i></span>
            Projects
        </a>
    </nav>

    <div class="nav-label">Organization</div>
    <nav class="sidebar-nav">
        <a href="/users" wire:navigate class="nav-link">
            <span class="nav-icon"><i class="bi bi-people"></i></span>
            Users
        </a>
        <a href="#" wire:navigate class="nav-link">
            <span class="nav-icon"><i class="bi bi-calendar4-event"></i></span>
            Schedule
        </a>
    </nav>

    <div class="sidebar-footer">
        <div class="user-compact">
            <div class="user-avatar-sm">
                {{ strtoupper(substr(auth()->user()->name ?? 'U', 0, 1)) }}
            </div>
            <div class="user-info-sm text-truncate">
                <div class="user-name-sm">{{ auth()->user()->name ?? 'Administrator' }}</div>
                <div class="user-role-sm">Standard Account</div>
            </div>
        </div>
    </div>
</div>