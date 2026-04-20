<div>
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="mb-0 fw-bold" style="color: #0f172a;">Create New Task</h4>
            <p class="text-muted mb-0" style="font-size: 0.8125rem;">Assign and track new action items</p>
        </div>
        <a href="/tasks" wire:navigate class="btn btn-outline-secondary px-3" style="font-size: 0.8125rem; font-weight: 600; border-radius: 6px;">
            <i class="bi bi-arrow-left me-1"></i> Back
        </a>
    </div>

    <div class="card border-0 shadow-sm" style="border-radius: 12px; border: 1px solid #e2e8f0 !important; background: #ffffff;">
        <div class="card-body p-4 p-md-5">
            <form wire:submit.prevent="store">
                
                <!-- Task Title -->
                <div class="mb-3">
                    <label class="form-label fw-semibold text-muted" style="font-size: 0.75rem;">TASK TITLE</label>
                    <input type="text" wire:model="title" class="form-control" placeholder="e.g., Finalize Q3 Report" style="font-size: 0.875rem; border-radius: 8px; border: 1px solid #e2e8f0;">
                    @error('title') <div class="text-danger mt-1" style="font-size: 0.75rem;">{{ $message }}</div> @enderror
                </div>

                <!-- Description -->
                <div class="mb-3">
                    <label class="form-label fw-semibold text-muted" style="font-size: 0.75rem;">DESCRIPTION</label>
                    <textarea wire:model="description" class="form-control" rows="3" placeholder="Provide detailed context..." style="font-size: 0.875rem; border-radius: 8px; border: 1px solid #e2e8f0;"></textarea>
                    @error('description') <div class="text-danger mt-1" style="font-size: 0.75rem;">{{ $message }}</div> @enderror
                </div>

                <!-- Priority & Due Date Row -->
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-semibold text-muted" style="font-size: 0.75rem;">PRIORITY</label>
                        <select wire:model="priority" class="form-select" style="font-size: 0.875rem; border-radius: 8px; border: 1px solid #e2e8f0;">
                            <option value="Low">Low</option>
                            <option value="Medium">Medium</option>
                            <option value="High">High</option>
                            <option value="Urgent">Urgent</option>
                        </select>
                        @error('priority') <div class="text-danger mt-1" style="font-size: 0.75rem;">{{ $message }}</div> @enderror
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-semibold text-muted" style="font-size: 0.75rem;">DUE DATE</label>
                        <input type="date" wire:model="due_date" class="form-control" style="font-size: 0.875rem; border-radius: 8px; border: 1px solid #e2e8f0;">
                        @error('due_date') <div class="text-danger mt-1" style="font-size: 0.75rem;">{{ $message }}</div> @enderror
                    </div>
                </div>

                <!-- Assigned To -->
                <div class="mb-4">
                    <label class="form-label fw-semibold text-muted" style="font-size: 0.75rem;">ASSIGN TO</label>
                    <select wire:model="assigned_to" class="form-select" style="font-size: 0.875rem; border-radius: 8px; border: 1px solid #e2e8f0;">
                        <option value="">Select User...</option>
                        @foreach($users as $user)
                            <option value="{{ $user->id }}">{{ $user->name }} ({{ $user->role }})</option>
                        @endforeach
                    </select>
                    @error('assigned_to') <div class="text-danger mt-1" style="font-size: 0.75rem;">{{ $message }}</div> @enderror
                </div>

                <!-- Submit Button -->
                <button type="submit" class="btn btn-primary w-100 py-2 fw-bold position-relative shadow-sm" 
                        style="border-radius: 8px; background: #0f172a; border: none; font-size: 0.875rem;">
                    <span wire:loading.remove wire:target="store">Create Task</span>
                    <span wire:loading wire:target="store">
                        <span class="spinner-border spinner-border-sm me-2" role="status"></span> Creating...
                    </span>
                    <i class="bi bi-check-circle ms-2" wire:loading.remove wire:target="store"></i>
                </button>
            </form>

            @if (session()->has('message'))
                <div class="alert alert-success border-0 mt-4 d-flex align-items-center" role="alert" style="font-size: 0.8125rem; border-radius: 8px;">
                    <i class="bi bi-check-circle-fill me-2"></i>
                    <div>{{ session('message') }}</div>
                </div>
            @endif
        </div>
    </div>
</div>
