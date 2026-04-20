<div class="container-fluid py-2">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="mb-0 fw-bold" style="color: #0f172a;">Personal Action Items</h4>
            <p class="text-muted mb-0" style="font-size: 0.8125rem;">Tasks specifically assigned to your profile</p>
        </div>
        <div class="d-flex gap-2">
            <div class="bg-white border rounded px-3 py-2 d-flex align-items-center shadow-sm">
                <span class="text-muted small me-2">Personal Efficiency:</span>
                <span class="fw-bold text-success">84%</span>
            </div>
        </div>
    </div>

    <!-- Filters Row -->
    <div class="card border-0 mb-4" style="background: #fff; border: 1px solid #e2e8f0 !important; border-radius: 8px;">
        <div class="card-body p-3 d-flex flex-wrap gap-2 align-items-center">
            <div class="input-group input-group-sm" style="width: 240px;">
                <span class="input-group-text bg-white border-end-0 text-muted"><i class="bi bi-search"></i></span>
                <input wire:model.live.debounce.500ms="search" type="text" class="form-control border-start-0" placeholder="Search my tasks...">
            </div>
            <select wire:model.live="status" class="form-select form-select-sm" style="width: 140px;">
                <option value="">All Status</option>
                <option>Pending</option>
                <option>In Progress</option>
                <option>Completed</option>
            </select>
            <select wire:model.live="priority" class="form-select form-select-sm" style="width: 140px;">
                <option value="">All Priorities</option>
                <option>Urgent</option>
                <option>High</option>
                <option>Medium</option>
                <option>Low</option>
            </select>
            <div class="ms-auto" wire:loading.remove wire:target="search, status, priority">
                <span class="text-muted" style="font-size: 0.75rem;">Showing {{ $tasks->total() }} matches</span>
            </div>
            <div class="ms-auto" wire:loading wire:target="search, status, priority">
                <span class="spinner-border spinner-border-sm text-primary" role="status" style="width: 0.8rem; height: 0.8rem;"></span>
                <span class="text-muted ms-1" style="font-size: 0.75rem;">Updating...</span>
            </div>
        </div>
    </div>

    <!-- Reusable Task List Component -->
    <livewire:partials.task-list :tasks="$tasks->items()" scope="my" />

    <div class="mt-4">
        {{ $tasks->links() }}
    </div>
</div>
