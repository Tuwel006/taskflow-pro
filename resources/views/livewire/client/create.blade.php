<div class="container-fluid py-2">
    <x-page-header 
        title="Onboard New Client" 
        subtitle="Register an external stakeholder into the system ecosystem"
        :breadcrumbItems="[['label' => 'Project', 'url' => '/clients'], ['label' => 'Create']]"
    >
        <x-slot name="actions">
            <a href="/clients" wire:navigate class="btn btn-sm btn-outline-secondary px-3 shadow-sm d-flex align-items-center" style="font-weight: 600; border-radius: 6px;">
                <i class="bi bi-arrow-left me-2"></i> Back to List
            </a>
        </x-slot>
    </x-page-header>

    <div class="card border-0 shadow-sm" style="background: #fff; border: 1px solid #e2e8f0 !important; border-radius: 10px;">
        <div class="card-body p-4">
            <form wire:submit.prevent="store">
                <div class="row g-4">
                    <div class="col-md-6">
                        <h6 class="fw-bold mb-3" style="font-size: 0.875rem; color: #1e293b; border-left: 3px solid #10b981; padding-left: 10px;">Profile & Contact</h6>
                        <div class="mb-3">
                            <label class="form-label fw-semibold" style="font-size: 0.75rem; color: #64748b;">Client Name / Entity</label>
                            <input type="text" wire:model.blur="name" class="form-control" placeholder="Acme Corp / John Doe" style="font-size: 0.8125rem; border-radius: 6px;">
                            @error('name') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-semibold" style="font-size: 0.75rem; color: #64748b;">Business Email</label>
                            <input type="email" wire:model.blur="email" class="form-control" placeholder="contact@acme.com" style="font-size: 0.8125rem; border-radius: 6px;">
                            @error('email') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-semibold" style="font-size: 0.75rem; color: #64748b;">Primary Phone</label>
                            <input type="text" wire:model.blur="phone" class="form-control" placeholder="+1 (555) 000-0000" style="font-size: 0.8125rem; border-radius: 6px;">
                            @error('phone') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-semibold" style="font-size: 0.75rem; color: #64748b;">Mailing Address</label>
                            <textarea class="form-control" rows="2" wire:model.blur="address" placeholder="Corporate headquarters address..." style="font-size: 0.8125rem; border-radius: 6px;"></textarea>
                            @error('address') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <h6 class="fw-bold mb-3" style="font-size: 0.875rem; color: #1e293b; border-left: 3px solid #10b981; padding-left: 10px;">Security & Access</h6>
                        <div class="mb-3">
                            <label class="form-label fw-semibold" style="font-size: 0.75rem; color: #64748b;">Stakeholder Role</label>
                            <input type="text" wire:model.blur="role" class="form-control" style="font-size: 0.8125rem; border-radius: 6px;">
                            @error('role') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-semibold" style="font-size: 0.75rem; color: #64748b;">Initial Password</label>
                            <input type="password" wire:model.blur="password" class="form-control" placeholder="••••••••" style="font-size: 0.8125rem; border-radius: 6px;">
                            @error('password') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-semibold" style="font-size: 0.75rem; color: #64748b;">Client Logo / Avatar URL</label>
                            <input type="text" wire:model.blur="avatar" class="form-control" placeholder="https://path-to-logo.png" style="font-size: 0.8125rem; border-radius: 6px;">
                            @error('avatar') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>
                        <div class="p-3 rounded" style="background: #f8fafc; border: 1px solid #e2e8f0;">
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" wire:model.blur="is_active" id="isActiveSwitch" checked>
                                <label class="form-check-label fw-bold ms-2" for="isActiveSwitch" style="font-size: 0.8125rem; color: #334155;">Account Active</label>
                                @error('is_active') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>
                        </div>
                    </div>
                </div>
                <hr class="my-4" style="border-color: #e2e8f0;">
                <div class="d-flex justify-content-end gap-2">
                    <button type="submit" class="btn btn-primary px-5" style="font-size: 0.875rem; font-weight: 600; border-radius: 6px; background: #10b981; border: none;">
                        Save Client
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
