{{-- Navbar --}}
<style>
    #main-navbar {
        background: #ffffff;
        border-bottom: 1px solid #e2e8f0;
        padding: 0.5rem 1.25rem;
        display: flex;
        align-items: center;
        justify-content: space-between;
        min-height: 56px;
        flex-shrink: 0;
    }

    .navbar-title {
        font-size: 0.875rem;
        font-weight: 600;
        color: #0f172a;
        margin: 0;
    }

    /* Professional Search */
    .nav-search-group {
        position: relative;
        max-width: 320px;
        width: 100%;
    }
    .nav-search-input {
        width: 100%;
        height: 34px;
        background: #f1f5f9;
        border: 1px solid #e2e8f0;
        border-radius: 6px;
        padding: 0 0.75rem 0 2.25rem;
        font-size: 0.8125rem;
        color: #334155;
        transition: all 0.15s;
    }
    .nav-search-input:focus {
        background: #fff;
        border-color: #3b82f6;
        outline: none;
        box-shadow: 0 0 0 2px rgba(59, 130, 246, 0.1);
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
    <div class="d-flex align-items-center gap-3">
        <h1 class="navbar-title">
            @if(request()->is('dashboard'))
                Overview
            @elseif(request()->is('tasks*'))
                Tasks Console
            @else
                Application
            @endif
        </h1>
        
        <div class="nav-search-group d-none d-md-block">
            <i class="bi bi-search nav-search-icon"></i>
            <input type="text" class="nav-search-input" placeholder="Quick search...">
        </div>
    </div>

    <div class="nav-actions">
        <a href="#" class="nav-btn-icon" title="Notifications">
            <i class="bi bi-bell"></i>
        </a>
        
        <div class="dropdown">
            <div class="nav-user-dropdown" data-bs-toggle="dropdown">
                <div class="nav-user-img">
                    {{ strtoupper(substr(auth()->user()->name ?? 'U', 0, 1)) }}
                </div>
                <div class="nav-user-meta d-none d-sm-block">
                    <span class="nav-user-name">{{ auth()->user()->name ?? 'Administrator' }}</span>
                </div>
                <i class="bi bi-chevron-down ms-1" style="font-size: 0.7rem; color: #94a3b8;"></i>
            </div>
            <ul class="dropdown-menu dropdown-menu-end" style="font-size: 0.8125rem; border-radius: 8px; border: 1px solid #e2e8f0; box-shadow: 0 4px 6px -1px rgba(0,0,0,0.1);">
                <li><a class="dropdown-item" href="#"><i class="bi bi-person me-2"></i> Settings</a></li>
                <li><a class="dropdown-item" href="#"><i class="bi bi-shield-lock me-2"></i> Security</a></li>
                <li><hr class="dropdown-divider"></li>
                <li><a class="dropdown-item text-danger" href="#"><i class="bi bi-box-arrow-right me-2"></i> Sign Out</a></li>
            </ul>
        </div>
    </div>
</nav>