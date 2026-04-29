<div class="container-fluid py-2">
    <x-page-header
        title="Create Task Status"
        subtitle="Add a new task status to the system"
        :breadcrumbItems="[['label' => 'Task Statuses', 'url' => '/task-statuses'], ['label' => 'Create']]"
    >
        <x-slot name="actions">
            <a href="/task-statuses" wire:navigate class="btn btn-sm btn-outline-secondary px-3 shadow-sm d-flex align-items-center" style="font-weight: 600; border-radius: 6px;">
                <i class="bi bi-arrow-left me-2"></i> Back to List
            </a>
        </x-slot>
    </x-page-header>

    <div class="card border-0 shadow-sm" style="background: #fff; border: 1px solid #e2e8f0 !important; border-radius: 10px;">
        <div class="card-body p-4">
            <form wire:submit.prevent="store">
                <div class="row g-4">
                    <!-- Column 1: Status Details -->
                    <div class="col-md-8">
                        <h6 class="fw-bold mb-3" style="font-size: 0.875rem; color: #1e293b; border-left: 3px solid #3b82f6; padding-left: 10px;">Status Information</h6>

                        <div class="mb-3">
                            <label class="form-label fw-semibold" style="font-size: 0.75rem; color: #64748b;">Status Name</label>
                            <input type="text" wire:model.blur="name" name="name" class="form-control" placeholder="e.g. To Do, In Progress, Done" style="font-size: 0.8125rem; border-radius: 6px;">
                            @error('name') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-semibold" style="font-size: 0.75rem; color: #64748b;">Color</label>
                            <div class="input-group">
                                <input type="color" wire:model.blur="color" name="color" class="form-control form-control-color" style="width: 60px; border-radius: 6px 0 0 6px;">
                                <input type="text" wire:model.blur="color" name="color_text" class="form-control" placeholder="#64748b" style="font-size: 0.8125rem; border-radius: 0 6px 6px 0;">
                            </div>
                            @error('color') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>
                    </div>

                    <!-- Column 2: Preview -->
                    <div class="col-md-4">
                        <h6 class="fw-bold mb-3" style="font-size: 0.875rem; color: #1e293b; border-left: 3px solid #3b82f6; padding-left: 10px;">Preview</h6>

                        <div class="p-3 rounded" style="background: #f8fafc; border: 1px solid #e2e8f0;">
                            <div class="d-flex align-items-center gap-2 mb-2">
                                <div class="rounded-circle" style="width: 16px; height: 16px; background-color: {{ $color }};"></div>
                                <span class="fw-semibold" style="font-size: 0.875rem; color: #1e293b;">{{ $name ?: 'Status Name' }}</span>
                            </div>
                        </div>
                    </div>
                </div>

                <hr class="my-4" style="border-color: #e2e8f0;">

                <div class="d-flex justify-content-end gap-2">
                    <button type="reset" class="btn btn-link text-decoration-none text-muted" style="font-size: 0.8125rem; font-weight: 600;">Reset Form</button>
                    <button type="submit" class="btn btn-primary px-5" style="font-size: 0.875rem; font-weight: 600; border-radius: 6px; background: #3b82f6;">
                        Create Status
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>