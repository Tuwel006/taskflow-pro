<div class="container-fluid py-2">
    <x-page-header 
        title="Edit System User" 
        subtitle="Modify existing identity and access configuration"
        :breadcrumbItems="[['label' => 'Team', 'url' => '/users'], ['label' => 'Edit']]"
    >
        <x-slot name="actions">
            <a href="/users" wire:navigate class="btn btn-sm btn-outline-secondary px-3 shadow-sm d-flex align-items-center" style="font-weight: 600; border-radius: 6px;">
                <i class="bi bi-arrow-left me-2"></i> Back to List
            </a>
        </x-slot>
    </x-page-header>

    <div class="card border-0 shadow-sm" style="background: #fff; border: 1px solid #e2e8f0 !important; border-radius: 10px;">
        <div class="card-body p-4">
            <form wire:submit.prevent="update">
                <div class="row g-4">
                    <!-- Column 1: Basic Info -->
                    <div class="col-md-6">
                        <h6 class="fw-bold mb-3" style="font-size: 0.875rem; color: #1e293b; border-left: 3px solid #3b82f6; padding-left: 10px;">Identity & Contact</h6>
                        
                        <div class="mb-3">
                            <label class="form-label fw-semibold" style="font-size: 0.75rem; color: #64748b;">Full Name</label>
                            <input type="text" wire:model.blur="name" name="name" class="form-control" placeholder="John Doe" style="font-size: 0.8125rem; border-radius: 6px;">
                            @error('name') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-semibold" style="font-size: 0.75rem; color: #64748b;">Email Address</label>
                            <input type="email" wire:model.blur="email" name="email" class="form-control" placeholder="john@example.com" style="font-size: 0.8125rem; border-radius: 6px;">
                            @error('email') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-semibold" style="font-size: 0.75rem; color: #64748b;">Phone Number</label>
                            <input type="text" wire:model.blur="phone" name="phone" class="form-control" placeholder="+1 (555) 000-0000" style="font-size: 0.8125rem; border-radius: 6px;">
                            @error('phone') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-semibold" style="font-size: 0.75rem; color: #64748b;">Mailing Address</label>
                            <textarea class="form-control" rows="2" wire:model.blur="address" name="address" placeholder="Enter street, city, state..." style="font-size: 0.8125rem; border-radius: 6px;"></textarea>
                            @error('address') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>
                    </div>

                    <!-- Column 2: System Attributes -->
                    <div class="col-md-6">
                        <h6 class="fw-bold mb-3" style="font-size: 0.875rem; color: #1e293b; border-left: 3px solid #3b82f6; padding-left: 10px;">System Configuration</h6>

                        <div class="row g-3">
                            <div class="col-sm-6">
                                <div class="mb-3">
                                    <label class="form-label fw-semibold" style="font-size: 0.75rem; color: #64748b;">System Role</label>
                                    <input type="text" wire:model.blur="role" name="role" class="form-control" placeholder="e.g. admin, manager, user" style="font-size: 0.8125rem; border-radius: 6px;">
                                    @error('role') <span class="text-danger">{{ $message }}</span> @enderror
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="mb-3">
                                    <label class="form-label fw-semibold" style="font-size: 0.75rem; color: #64748b;">User Type</label>
                                    <select class="form-select" style="font-size: 0.8125rem; border-radius: 6px;" wire:model.blur="type" name="type">
                                        <option value="0">0 (Default)</option>
                                        <option value="1">1 (Agent)</option>
                                        <option value="2">2 (Client)</option>
                                    </select>
                                    @error('type') <span class="text-danger">{{ $message }}</span> @enderror
                                </div>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-semibold" style="font-size: 0.75rem; color: #64748b;">Password (`password`)</label>
                            <div class="input-group">
                                <input type="password" wire:model.blur="password" name="password" class="form-control" placeholder="••••••••" style="font-size: 0.8125rem; border-radius: 6px 0 0 6px;">
                                <button class="btn btn-outline-secondary" type="button" style="border-radius: 0 6px 6px 0;"><i class="bi bi-eye"></i></button>
                            </div>
                            @error('password') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-semibold" style="font-size: 0.75rem; color: #64748b;">Avatar</label>
                            <input type="text" wire:model.blur="avatar" name="avatar" class="form-control" placeholder="https://path-to-image.jpg" style="font-size: 0.8125rem; border-radius: 6px;">
                            @error('avatar') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>

                        <div class="p-3 rounded" style="background: #f8fafc; border: 1px solid #e2e8f0;">
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" wire:model.blur="is_active" name="is_active" id="isActiveSwitch" checked>
                                <label class="form-check-label fw-bold ms-2" for="isActiveSwitch" style="font-size: 0.8125rem; color: #334155;">Account Active</label>
                                @error('is_active') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>
                            <div class="mt-1" style="font-size: 0.68rem; color: #94a3b8; padding-left: 2.2rem;">
                                If disabled, the user will be blocked from system authentication.
                            </div>
                        </div>
                    </div>
                </div>

                <hr class="my-4" style="border-color: #e2e8f0;">

                <div class="d-flex justify-content-end gap-2">
                    <button type="submit" class="btn btn-primary px-5" style="font-size: 0.875rem; font-weight: 600; border-radius: 6px; background: #3b82f6;">
                        Update User
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>