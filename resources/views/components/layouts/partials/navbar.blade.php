{{-- Navbar --}}
<style>
    #main-navbar {
        background: #ffffff;
        border-bottom: 1px solid #f1f5f9;
        padding: 0.5rem 1.25rem;
        display: flex;
        align-items: center;
        justify-content: space-between;
        min-height: 56px;
        flex-shrink: 0;
    }

    .navbar-title {
        font-size: 0.8125rem;
        font-weight: 700;
        color: #0f172a;
        margin: 0;
        text-transform: uppercase;
        letter-spacing: 0.025em;
    }

    /* Professional Search */
    .nav-search-group {
        position: relative;
        max-width: 280px;
        width: 100%;
    }
    .nav-search-input {
        width: 100%;
        height: 34px;
        background: #f8fafc;
        border: 1px solid #e2e8f0;
        border-radius: 8px;
        padding: 0 0.75rem 0 2.25rem;
        font-size: 0.8125rem;
        color: #1e293b;
        transition: all 0.2s;
    }
    .nav-search-input:focus {
        background: #fff;
        border-color: #0ea5e9;
        outline: none;
        box-shadow: 0 0 0 3px rgba(14, 165, 233, 0.1);
    }
    .nav-search-icon {
        position: absolute;
        left: 0.75rem;
        top: 50%;
        transform: translateY(-50%);
        color: #94a3b8;
        font-size: 0.875rem;
    }

    /* Action items */
    .nav-actions {
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }
    .nav-btn-icon {
        width: 34px;
        height: 34px;
        display: flex;
        align-items: center;
        justify-content: center;
        border: 1px solid #e2e8f0;
        border-radius: 6px;
        color: #64748b;
        background: #fff;
        text-decoration: none;
        transition: all 0.15s;
    }
    .nav-btn-icon:hover {
        background: #f8fafc;
        color: #0f172a;
        border-color: #cbd5e1;
    }

    /* User Profile Compact */
    .nav-user-dropdown {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        padding: 0.25rem 0.5rem;
        border: 1px solid transparent;
        border-radius: 6px;
        cursor: pointer;
        transition: all 0.15s;
    }
    .nav-user-dropdown:hover {
        background: #f8fafc;
        border-color: #e2e8f0;
    }
    .nav-user-img {
        width: 28px;
        height: 28px;
        border-radius: 4px;
        background: #e2e8f0;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 0.75rem;
        font-weight: 600;
        color: #475569;
    }
    .nav-user-meta {
        line-height: 1;
    }
    .nav-user-name {
        font-size: 0.8125rem;
        font-weight: 600;
        color: #1e293b;
    }
</style>

<nav id="main-navbar">
    <div class="d-flex align-items-center gap-2 gap-md-3">
        {{-- Mobile Toggle --}}
        <button class="nav-btn-icon d-md-none border-0" @click="mobileSidebarOpen = true">
            <i class="bi bi-list fs-4"></i>
        </button>

        <h1 class="navbar-title">
            @if(request()->is('dashboard') || request()->is('client/dashboard'))
                Overview
            @elseif(request()->is('tasks*') || request()->is('client/tasks*'))
                Tasks Console
            @elseif(request()->is('projects*') || request()->is('client/projects*'))
                Projects
            @else
                Application
            @endif
        </h1>
        
        <div class="nav-search-group d-none d-lg-block">
            <i class="bi bi-search nav-search-icon"></i>
            <input type="text" class="nav-search-input" placeholder="Quick search...">
        </div>
    </div>

    <div class="nav-actions">
        <livewire:partials.notification-dropdown />
        
        <livewire:partials.user-dropdown />
    </div>
</nav>