<div class="container-fluid py-2">
    <x-page-header
        title="Create Workflow Stage"
        subtitle="Add a new stage to project workflow"
        :breadcrumbItems="[['label' => 'Workflow Stages', 'url' => '/stages'], ['label' => 'Create']]"
    >
        <x-slot name="actions">
            <a href="/workflows" wire:navigate class="btn btn-sm btn-outline-secondary px-3 shadow-sm d-flex align-items-center" style="font-weight: 600; border-radius: 6px;">
                <i class="bi bi-arrow-left me-2"></i> Back to List
            </a>
        </x-slot>
    </x-page-header>

    <div class="card border-0 shadow-sm" style="background: #fff; border: 1px solid #e2e8f0 !important; border-radius: 10px;">
        <div class="card-body p-4">
            <form wire:submit.prevent="store">
                <div class="row g-4">
                    <!-- Column 1: Stage Details -->
                    <div class="col-md-8">
                        <h6 class="fw-bold mb-3" style="font-size: 0.875rem; color: #1e293b; border-left: 3px solid #3b82f6; padding-left: 10px;">Stage Configuration</h6>

                        <div class="mb-3">
                            <label class="form-label fw-semibold" style="font-size: 0.75rem; color: #64748b;">Project <span class="text-danger">*</span></label>
                            <select wire:model.blur="project_id" name="project_id" class="form-select" style="font-size: 0.8125rem; border-radius: 6px;">
                                <option value="">-- Select Project --</option>
                                @foreach ($projects as $project)
                                    <option value="{{ $project->id }}">{{ $project->name }}</option>
                                @endforeach
                            </select>
                            @error('project_id') <span class="text-danger small">{{ $message }}</span> @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-semibold" style="font-size: 0.75rem; color: #64748b;">Status <span class="text-danger">*</span></label>
                            <select wire:model.blur="status_id" name="status_id" class="form-select" style="font-size: 0.8125rem; border-radius: 6px;">
                                <option value="">-- Select Status --</option>
                                @foreach ($statuses as $status)
                                    <option value="{{ $status->id }}">{{ $status->name }}</option>
                                @endforeach
                            </select>
                            @error('status_id') <span class="text-danger small">{{ $message }}</span> @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-semibold" style="font-size: 0.75rem; color: #64748b;">Position <span class="text-danger">*</span></label>
                            <input type="number" wire:model.blur="position" name="position" class="form-control" placeholder="0" min="0" style="font-size: 0.8125rem; border-radius: 6px;">
                            @error('position') <span class="text-danger small">{{ $message }}</span> @enderror
                            <div class="mt-1" style="font-size: 0.68rem; color: #94a3b8;">
                                Lower numbers appear first in the workflow.
                            </div>
                        </div>
                    </div>

                    <!-- Column 2: Preview -->
                    <div class="col-md-4">
                        <h6 class="fw-bold mb-3" style="font-size: 0.875rem; color: #1e293b; border-left: 3px solid #3b82f6; padding-left: 10px;">Preview</h6>

                        <div class="p-3 rounded" style="background: #f8fafc; border: 1px solid #e2e8f0;">
                            <div class="mb-2">
                                <small class="text-muted">Position</small>
                                <div class="fw-bold text-dark" style="font-size: 0.9rem;">{{ $position ?? '0' }}</div>
                            </div>
                            <div class="mb-2">
                                <small class="text-muted">Status</small>
                                <div class="d-flex align-items-center gap-2">
                                    @if ($status_id)
                                        @php
                                            $status = $statuses->find($status_id);
                                        @endphp
                                        <div class="rounded-circle" style="width: 12px; height: 12px; background-color: {{ $status->color }};"></div>
                                        <span class="fw-bold text-dark" style="font-size: 0.875rem;">{{ $status->name }}</span>
                                    @else
                                        <span class="text-muted">Not selected</span>
                                    @endif
                                </div>
                            </div>
                            <div>
                                <small class="text-muted">Project</small>
                                <div class="fw-bold text-dark" style="font-size: 0.875rem;">
                                    @if ($project_id)
                                        {{ $projects->find($project_id)->name }}
                                    @else
                                        Not selected
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <hr class="my-4" style="border-color: #e2e8f0;">

                <div class="d-flex justify-content-end gap-2">
                    <button type="reset" class="btn btn-link text-decoration-none text-muted" style="font-size: 0.8125rem; font-weight: 600;">Reset Form</button>
                    <button type="submit" class="btn btn-primary px-5" style="font-size: 0.875rem; font-weight: 600; border-radius: 6px; background: #3b82f6;">
                        Create Stage
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
