<div class="container-fluid py-2">
    <x-page-header 
        :title="'Edit Project: ' . $name" 
        subtitle="Update project parameters and visibility settings"
        :breadcrumbItems="[['label' => 'Projects', 'url' => '/projects'], ['label' => 'Edit']]"
    >
        <x-slot name="actions">
            <a href="/projects" wire:navigate class="btn btn-sm btn-outline-secondary px-3 shadow-sm d-flex align-items-center" style="font-weight: 600; border-radius: 6px;">
                <i class="bi bi-arrow-left me-2"></i> Back to List
            </a>
        </x-slot>
    </x-page-header>

    <div class="card border-0 shadow-sm" style="background: #fff; border: 1px solid #e2e8f0 !important; border-radius: 10px;">
        <div class="card-body p-4">
            <form wire:submit="update">
                <div class="row g-4">
                    {{-- Identity Section --}}
                    <div class="col-md-6">
                        <h6 class="fw-bold mb-3" style="font-size: 0.875rem; color: #1e293b; border-left: 3px solid #3b82f6; padding-left: 10px;">Project Identity</h6>
                        
                        <div class="mb-3">
                            <label class="form-label fw-semibold" style="font-size: 0.75rem; color: #64748b;">Project Name</label>
                            <input type="text" wire:model="name" class="form-control @error('name') is-invalid @enderror" 
                                style="font-size: 0.8125rem; border-radius: 6px;">
                            @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-semibold" style="font-size: 0.75rem; color: #64748b;">Prefix (Key)</label>
                            <input type="text" wire:model="prefix" class="form-control @error('prefix') is-invalid @enderror" 
                                style="font-size: 0.8125rem; border-radius: 6px; text-transform: uppercase;">
                            <div class="form-text" style="font-size: 0.65rem;">Unique key used for task referencing.</div>
                            @error('prefix') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                    </div>

                    {{-- Description Section --}}
                    <div class="col-md-6">
                        <h6 class="fw-bold mb-3" style="font-size: 0.875rem; color: #1e293b; border-left: 3px solid #3b82f6; padding-left: 10px;">Configurations</h6>
                        
                        <div class="mb-3">
                            <label class="form-label fw-semibold" style="font-size: 0.75rem; color: #64748b;">Description</label>
                            <textarea wire:model="description" class="form-control @error('description') is-invalid @enderror" rows="4" 
                                style="font-size: 0.8125rem; border-radius: 6px;"></textarea>
                            @error('description') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <div class="p-3 rounded" style="background: #f8fafc; border: 1px solid #e2e8f0;">
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" role="switch" id="is_active" wire:model="is_active">
                                <label class="form-check-label fw-bold ms-2" for="is_active" style="font-size: 0.8125rem; color: #334155;">Project Active</label>
                            </div>
                            <div class="mt-1" style="font-size: 0.68rem; color: #94a3b8; padding-left: 2.2rem;">
                                Toggling this will hide/show the project across the platform.
                            </div>
                        </div>
                    </div>
                </div>

                <hr class="my-4" style="border-color: #e2e8f0;">

                <div class="d-flex justify-content-end gap-2">
                    <button type="submit" class="btn btn-primary px-5 shadow-sm d-flex align-items-center gap-2" 
                        style="font-size: 0.875rem; font-weight: 600; border-radius: 6px; background: #0ea5e9; border: none;">
                        <i class="bi bi-save"></i> Save Changes
                        <div wire:loading wire:target="update" class="spinner-border spinner-border-sm"></div>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
