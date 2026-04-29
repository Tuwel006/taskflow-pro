{{-- Agent Sidebar --}}
<style>
    #sidebar {
        min-height: 100vh;
        background: #ffffff;
        display: flex;
        flex-direction: column;
        border-right: 1px solid #e0f2fe;
        position: relative;
        z-index: 100;
        flex-shrink: 0;
        transition: width 0.3s cubic-bezier(0.4, 0, 0.2, 1), transform 0.3s ease;
        overflow-x: hidden;
    }

    @media (max-width: 768px) {
        #sidebar {
            position: fixed;
            left: 0;
            top: 0;
            height: 100vh;
            width: 260px !important;
            transform: translateX(-100%);
            z-index: 1050;
            box-shadow: 15px 0 30px rgba(0,0,0,0.1);
        }
        #sidebar.mobile-open {
            transform: translateX(0);
        }
        .sidebar-overlay {
            position: fixed;
            inset: 0;
            background: rgba(15, 23, 42, 0.5);
            backdrop-filter: blur(4px);
            z-index: 1040;
        }
    }

    /* Brand / Logo */
    .sidebar-brand {
        padding: 1.25rem 1rem;
        border-bottom: 1px solid #f1f5f9;
        display: flex;
        align-items: center;
        gap: 0.5rem;
        white-space: nowrap;
    }

    .sidebar-brand .brand-icon {
        width: 32px;
        height: 32px;
        background: #0ea5e9;
        border-radius: 6px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1rem;
        color: #fff;
        flex-shrink: 0;
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
        white-space: nowrap;
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
        white-space: nowrap;
        position: relative;
    }

    .sidebar-nav .nav-link .nav-icon {
        width: 20px;
        height: 20px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.1rem;
        opacity: 0.7;
        flex-shrink: 0;
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
        padding: 0.65rem 0.75rem;
        background: #fdfdfd;
        border-top: 1px solid #f1f5f9;
        overflow: hidden;
    }

    .user-compact {
        display: flex;
        align-items: center;
        gap: 0.6rem;
        white-space: nowrap;
    }

    .user-info-sm {
        line-height: 1;
        overflow: hidden;
    }

    .user-name-sm {
        font-size: 0.75rem;
        font-weight: 600;
        color: #0f172a;
        white-space: nowrap;
        text-overflow: ellipsis;
        overflow: hidden;
    }

    .user-role-sm {
        font-size: 0.62rem;
        font-weight: 500;
        color: #64748b;
        margin-top: 1px;
    }

    .collapse-toggle {
        position: absolute;
        right: -12px;
        top: 22px;
        width: 24px;
        height: 24px;
        background: #fff;
        border: 1px solid #e2e8f0;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        font-size: 0.7rem;
        color: #64748b;
        box-shadow: 0 2px 4px rgba(0,0,0,0.05);
        z-index: 101;
        transition: transform 0.3s;
    }
    
    @media (max-width: 768px) {
        .collapse-toggle { display: none; }
    }

    .collapse-toggle:hover {
        background: #f8fafc;
        color: #0ea5e9;
    }

    .collapsed-nav-label {
        height: 1px;
        background: #f1f5f9;
        margin: 1.5rem 0.75rem 0.5rem;
    }
    /* Custom Tooltip for Collapsed State */
    .sidebar-nav .nav-link .tooltip-text {
        position: absolute;
        left: 100%;
        margin-left: 10px;
        background: #1e293b;
        color: #fff;
        padding: 0.4rem 0.75rem;
        border-radius: 6px;
        font-size: 0.75rem;
        font-weight: 600;
        white-space: nowrap;
        opacity: 0;
        visibility: hidden;
        transition: all 0.2s ease;
        z-index: 1000;
        pointer-events: none;
        box-shadow: 0 4px 12px rgba(0,0,0,0.1);
    }

    .sidebar-nav .nav-link .tooltip-text::before {
        content: '';
        position: absolute;
        left: -4px;
        top: 50%;
        transform: translateY(-50%);
        border-width: 4px 4px 4px 0;
        border-style: solid;
        border-color: transparent #1e293b transparent transparent;
    }

    /* Only show tooltip when collapsed and hovering icon */
    #sidebar.is-collapsed .nav-link:hover .tooltip-text {
        opacity: 1;
        visibility: visible;
        margin-left: 15px;
    }
</style>

{{-- Backdrop --}}
<div class="sidebar-overlay" x-show="mobileSidebarOpen" @click="mobileSidebarOpen = false" x-cloak></div>

<div id="sidebar" 
     x-data="{ collapsed: localStorage.getItem('sidebar-collapsed') === 'true' }"
     x-init="$watch('collapsed', value => localStorage.setItem('sidebar-collapsed', value))"
     :style="collapsed ? 'width: 72px' : 'width: 240px'"
     :class="{ 'is-collapsed': collapsed, 'mobile-open': mobileSidebarOpen }">
    
    <div class="collapse-toggle" @click="collapsed = !collapsed" :style="collapsed ? 'transform: rotate(180deg)' : ''">
        <i class="bi bi-chevron-left"></i>
    </div>

    <div class="sidebar-brand">
        <div class="brand-icon">
            <i class="bi bi-stack"></i>
        </div>
        <span class="brand-text" x-show="!collapsed" x-transition>Taskflow Pro</span>
    </div>

    <template x-if="!collapsed">
        <div class="nav-label">Management</div>
    </template>
    <template x-if="collapsed">
        <div class="collapsed-nav-label"></div>
    </template>

    <nav class="sidebar-nav">
        <a href="/dashboard" wire:navigate class="nav-link {{ request()->is('dashboard') ? 'active' : '' }}">
            <span class="nav-icon"><i class="bi bi-speedometer2"></i></span>
            <span x-show="!collapsed" x-transition>Overview</span>
            <span class="tooltip-text">Overview</span>
        </a>
        
        <a href="/projects" wire:navigate class="nav-link {{ request()->is('projects*') ? 'active' : '' }}">
            <span class="nav-icon"><i class="bi bi-folder2"></i></span>
            <span x-show="!collapsed" x-transition>Projects</span>
            <span class="tooltip-text">Projects</span>
        </a>
    </nav>

    <template x-if="!collapsed">
        <div class="nav-label">Organization</div>
    </template>
    <template x-if="collapsed">
        <div class="collapsed-nav-label"></div>
    </template>

    <nav class="sidebar-nav">
        <a href="/users" wire:navigate class="nav-link {{ request()->is('users*') ? 'active' : '' }}">
            <span class="nav-icon"><i class="bi bi-people"></i></span>
            <span x-show="!collapsed" x-transition>Users</span>
            <span class="tooltip-text">Users</span>
        </a>
        <a href="/clients" wire:navigate class="nav-link {{ request()->is('clients*') ? 'active' : '' }}">
            <span class="nav-icon"><i class="bi bi-building"></i></span>
            <span x-show="!collapsed" x-transition>Clients</span>
            <span class="tooltip-text">Clients</span>
        </a>
        <a href="#" wire:navigate class="nav-link">
            <span class="nav-icon"><i class="bi bi-calendar4-event"></i></span>
            <span x-show="!collapsed" x-transition>Schedule</span>
            <span class="tooltip-text">Schedule</span>
        </a>
        <a href="/task-statuses" wire:navigate class="nav-link {{ request()->is('task-statuses*') ? 'active' : '' }}">
            <span class="nav-icon"><i class="bi bi-list-check"></i></span>
            <span x-show="!collapsed" x-transition>Task Statuses</span>
            <span class="tooltip-text">Task Statuses</span>
        </a>
        <a href="/workflows" wire:navigate class="nav-link {{ request()->is('workflows*') ? 'active' : '' }}">
            <span class="nav-icon"><i class="bi bi-diagram-3"></i></span>
            <span x-show="!collapsed" x-transition>Workflows</span>
            <span class="tooltip-text">Workflows</span>
        </a>
        <a href="/tasks" wire:navigate class="nav-link {{ request()->is('tasks*') ? 'active' : '' }}">
            <span class="nav-icon"><i class="bi bi-grid-1x2"></i></span>
            <span x-show="!collapsed" x-transition>Tasks</span>
            <span class="tooltip-text">Tasks</span>
            @php
                $projectTaskCount = \App\Models\Task::whereHas('statusRecord', function ($q) {
                    $q->where('name', '!=', 'Completed');
                })->count();
            @endphp
            @if ($projectTaskCount > 0)
                <span class="nav-badge" x-show="!collapsed">{{ str_pad($projectTaskCount, 2, '0', STR_PAD_LEFT) }}</span>
            @endif
        </a>
        <a href="/task-types" wire:navigate class="nav-link {{ request()->is('task-types*') ? 'active' : '' }}">
            <span class="nav-icon"><i class="bi bi-grid-1x2"></i></span>
            <span x-show="!collapsed" x-transition>Task Types</span>
            <span class="tooltip-text">Task Types</span>
        </a>
    </nav>

    <div class="sidebar-footer">
        <div class="user-compact">
            <x-user-avatar :user="auth()->user()" size="28px" fontsize="0.75rem" />
            <div class="user-info-sm text-truncate" x-show="!collapsed" x-transition>
                <div class="user-name-sm">{{ auth()->user()->name ?? 'Administrator' }}</div>
                <div class="user-role-sm">Standard Account</div>
            </div>
        </div>
    </div>
</div>
