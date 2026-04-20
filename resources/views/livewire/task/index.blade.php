<div class="container-fluid py-2">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="mb-0 fw-bold" style="color: #0f172a;">Task Registry</h4>
            <p class="text-muted mb-0" style="font-size: 0.8125rem;">Manage and track organization-wide action items</p>
        </div>
        <a href="/tasks/create" wire:navigate class="btn btn-primary px-3" style="font-size: 0.8125rem; font-weight: 600; border-radius: 6px;">
            <i class="bi bi-plus-lg me-1"></i> New Task
        </a>
    </div>

    <!-- Filters Row -->
    <div class="card border-0 mb-4" style="background: #fff; border: 1px solid #e2e8f0 !important; border-radius: 8px;">
        <div class="card-body p-3 d-flex flex-wrap gap-2 align-items-center">
            <div class="input-group input-group-sm" style="width: 240px;">
                <span class="input-group-text bg-white border-end-0 text-muted"><i class="bi bi-search"></i></span>
                <input type="text" class="form-control border-start-0" placeholder="Filter tasks...">
            </div>
            <select class="form-select form-select-sm" style="width: 140px;">
                <option>All Status</option>
                <option>Pending</option>
                <option>In Progress</option>
                <option>Completed</option>
            </select>
            <select class="form-select form-select-sm" style="width: 140px;">
                <option>All Priorities</option>
                <option>Urgent</option>
                <option>High</option>
                <option>Standard</option>
            </select>
            <div class="ms-auto">
                <span class="text-muted" style="font-size: 0.75rem;">Showing 0 records</span>
            </div>
        </div>
    </div>

    <livewire:partials.task-list scope="all" />
</div>