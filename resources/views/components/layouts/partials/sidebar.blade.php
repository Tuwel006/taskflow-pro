{{-- Sidebar --}}
<style>
    #sidebar {
        width: 240px;
        min-height: 100vh;
        background: #ffffff;
        display: flex;
        flex-direction: column;
        border-right: 1px solid #e0f2fe;
        /* Soft cyan border */
        position: relative;
        z-index: 100;
        flex-shrink: 0;
    }

    /* Brand / Logo */
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
        background: #0ea5e9;
        /* Sky Blue */
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

    /* Nav section label */
    .nav-label {
        font-size: 0.65rem;
        font-weight: 700;
        letter-spacing: 0.05em;
        text-transform: uppercase;
        color: #94a3b8;
        padding: 1.5rem 1rem 0.5rem;
    }

    /* Nav links */
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
        color: #0ea5e9;
        background: #f0f9ff;
    }

    .sidebar-nav .nav-link.active {
        color: #0369a1;
        background: #e0f2fe;
        font-weight: 600;
    }

    .sidebar-nav .nav-link.active .nav-icon {
        color: #0ea5e9;
        opacity: 1;
    }

    /* Badge */
    .nav-badge {
        margin-left: auto;
        font-size: 0.7rem;
        padding: 0.1rem 0.4rem;
        border-radius: 5px;
        background: #f1f5f9;
        color: #475569;
        font-weight: 600;
    }

    /* Bottom footer */
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

    .user-avatar-sm {
        width: 28px;
        height: 28px;
        border-radius: 6px;
        background: #e0f2fe;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 0.75rem;
        color: #0ea5e9;
        font-weight: 700;
        border: 1px solid #bae6fd;
    }

    .user-info-sm {
        line-height: 1.2;
        overflow: hidden;
    }

    .user-name-sm {
        font-size: 0.75rem;
        font-weight: 600;
        color: #1e293b;
        white-space: nowrap;
        text-overflow: ellipsis;
        overflow: hidden;
    }

    .user-role-sm {
        font-size: 0.65rem;
        color: #94a3b8;
    }
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
        <a href="/projects" wire:navigate class="nav-link">
            <span class="nav-icon"><i class="bi bi-folder2"></i></span>
            Projects
        </a>
    </nav>

    <div class="nav-label">Organization</div>
    <nav class="sidebar-nav">
        <a href="/users" wire:navigate class="nav-link {{ request()->is('users*') ? 'active' : '' }}">
            <span class="nav-icon"><i class="bi bi-people"></i></span>
            Users
        </a>
        <a href="#" wire:navigate class="nav-link">
            <span class="nav-icon"><i class="bi bi-calendar4-event"></i></span>
            Schedule
        </a>
        <a href="/task-statuses" wire:navigate class="nav-link {{ request()->is('task-statuses*') ? 'active' : '' }}">
            <span class="nav-icon"><i class="bi bi-list-check"></i></span>
            Task Statuses
        </a>
        <a href="/workflows" wire:navigate class="nav-link {{ request()->is('workflows*') ? 'active' : '' }}">
            <span class="nav-icon"><i class="bi bi-diagram-3"></i></span>
            Workflows
        </a>
        <a href="/tasks" wire:navigate class="nav-link {{ request()->is('tasks*') ? 'active' : '' }}">
            <span class="nav-icon"><i class="bi bi-grid-1x2"></i></span>
            Tasks
            @php
                $projectTaskCount = \App\Models\Task::whereHas('statusRecord', function ($q) {
                    $q->where('name', '!=', 'Completed');
                })->count();
            @endphp
            @if ($projectTaskCount > 0)
                <span class="nav-badge">{{ str_pad($projectTaskCount, 2, '0', STR_PAD_LEFT) }}</span>
            @endif
        </a>
        <a href="/task-types" wire:navigate class="nav-link {{ request()->is('task-types*') ? 'active' : '' }}">
            <span class="nav-icon"><i class="bi bi-grid-1x2"></i></span>
            Task Types
        </a>
    </nav>

    <div class="sidebar-footer">
        <div class="user-compact">
            <x-user-avatar :user="auth()->user()" size="28px" fontsize="0.75rem" />
            <div class="user-info-sm text-truncate">
                <div class="user-name-sm">{{ auth()->user()->name ?? 'Administrator' }}</div>
                <div class="user-role-sm">Standard Account</div>
            </div>
        </div>
    </div>
</div>
