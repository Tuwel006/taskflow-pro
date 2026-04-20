<div class="container-fluid py-2">
    <x-page-header 
        title="User Management" 
        subtitle="Maintain and audit your organization's human capital"
        :breadcrumbItems="[['label' => 'Team', 'url' => '/users'], ['label' => 'Directory']]"
    >
        <x-slot name="actions">
            <a href="/users/create" wire:navigate class="btn btn-primary px-3 shadow-sm d-flex align-items-center" 
               style="font-size: 0.8125rem; font-weight: 600; border-radius: 6px; background: #0f172a; border: none;">
                <i class="bi bi-person-plus me-2"></i> Add User
            </a>
        </x-slot>
    </x-page-header>

    @if (session()->has('message'))
        <div class="alert alert-success border-0 shadow-sm d-flex align-items-center" role="alert" style="background: #ecfdf5; color: #065f46; border-radius: 8px; font-size: 0.8125rem;">
            <i class="bi bi-check-circle-fill me-2"></i>
            <div>{{ session('message') }}</div>
            <button type="button" class="btn-close ms-auto" data-bs-dismiss="alert" aria-label="Close" style="font-size: 0.6rem;"></button>
        </div>
    @endif
    
    @if (session()->has('success'))
        <div class="alert alert-success border-0 shadow-sm d-flex align-items-center" role="alert" style="background: #ecfdf5; color: #065f46; border-radius: 8px; font-size: 0.8125rem;">
            <i class="bi bi-check-circle-fill me-2"></i>
            <div>{{ session('success') }}</div>
            <button type="button" class="btn-close ms-auto" data-bs-dismiss="alert" aria-label="Close" style="font-size: 0.6rem;"></button>
        </div>
    @endif

    <!-- Stats summary -->
    <div class="row g-3 mb-4">
        <div class="col-6 col-md-3">
            <div class="card border-0" style="background: #fff; border: 1px solid #e2e8f0 !important; border-radius: 8px;">
                <div class="card-body p-3">
                    <div class="text-uppercase text-muted fw-bold mb-1" style="font-size: 0.65rem; letter-spacing: 0.05em;">Total Users</div>
                    <div class="h5 fw-bold mb-0">{{$users->total()}}</div>
                </div>
            </div>
        </div>
        <div class="col-6 col-md-3">
            <div class="card border-0" style="background: #fff; border: 1px solid #e2e8f0 !important; border-radius: 8px;">
                <div class="card-body p-3">
                    <div class="text-uppercase text-muted fw-bold mb-1" style="font-size: 0.65rem; letter-spacing: 0.05em;">Active Now</div>
                    <div class="h5 fw-bold mb-0 text-success">{{$users->where('is_active', true)->count()}}</div>
                </div>
            </div>
        </div>
    </div>

    <!-- Filters & Table -->
    <div class="card border-0 shadow-sm" style="background: #fff; border: 1px solid #e2e8f0 !important; border-radius: 8px;">
        <div class="card-header bg-white border-0 py-3">
            <div class="row g-2 align-items-center">
                <div class="col-md-4">
                    <div class="input-group input-group-sm position-relative">
                        <span class="input-group-text bg-white border-end-0 text-muted" wire:loading.remove wire:target="search">
                            <i class="bi bi-search"></i>
                        </span>
                        <span class="input-group-text bg-white border-end-0 text-primary" wire:loading wire:target="search">
                            <div class="spinner-border spinner-border-sm" role="status"></div>
                        </span>
                        <input wire:model.live.debounce.500ms="search" type="text" class="form-control border-start-0" placeholder="Search by name, email or phone...">
                    </div>
                </div>
                <div class="col-md-auto ms-auto d-flex gap-2 align-items-center">
                    <div class="d-flex align-items-center gap-2 me-2">
                        <label class="text-muted mb-0" style="font-size: 0.75rem; white-space: nowrap;">Show</label>
                        <select class="form-select form-select-sm" style="width: 70px;" wire:model.live="itemPerPage">
                            <option value="5">5</option>
                            <option value="10">10</option>
                            <option value="25">25</option>
                            <option value="50">50</option>
                            <option value="100">100</option>
                        </select>
                    </div>
                    <select class="form-select form-select-sm" style="width: 130px;">
                        <option>All Roles</option>
                        <option>Admin</option>
                        <option>Manager</option>
                        <option>User</option>
                    </select>
                    <select class="form-select form-select-sm" style="width: 130px;">
                        <option>All Status</option>
                        <option>Active</option>
                        <option>Inactive</option>
                    </select>
                </div>
            </div>
        </div>
        <div class="card-body p-0 position-relative" style="min-height: 400px;">
            {{-- Global Loading Overlay --}}
            <div wire:loading.flex class="position-absolute w-100 h-100 align-items-center justify-content-center" 
                 style="background: rgba(255,255,255,0.7); z-index: 10; top: 0; left: 0; transition: all 0.3s ease;">
                <div class="text-center">
                    <div class="spinner-border text-primary mb-2" role="status" style="width: 1.5rem; height: 1.5rem;"></div>
                    <div class="text-muted" style="font-size: 0.75rem; font-weight: 500;">Refreshing database...</div>
                </div>
            </div>

            <div class="table-responsive" style="overflow: visible !important;">
                <table class="table align-middle mb-0" style="border-top: 1px solid #f1f5f9;">
                    <thead style="background: #f8fafc;">
                        <tr>
                            <th class="px-4" style="font-size: 0.7rem; font-weight: 600; text-transform: uppercase; color: #64748b;">Member</th>
                            <th style="font-size: 0.7rem; font-weight: 600; text-transform: uppercase; color: #64748b;">Role & Type</th>
                            <th style="font-size: 0.7rem; font-weight: 600; text-transform: uppercase; color: #64748b;">Contact Info</th>
                            <th style="font-size: 0.7rem; font-weight: 600; text-transform: uppercase; color: #64748b;">Status</th>
                            <th class="text-end px-4"></th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($users as $user)
                            <tr>
                                <td class="px-4 py-3">
                                    <div class="d-flex align-items-center gap-3">
                                        @if($user->avatar)
                                            <img src="{{ $user->avatar }}" class="rounded-circle shadow-sm" style="width: 36px; height: 36px; object-fit: cover;">
                                        @else
                                            <div class="rounded-circle d-flex align-items-center justify-content-center fw-bold text-white shadow-sm" 
                                                 style="width: 36px; height: 36px; font-size: 0.8rem; background: #6366f1;">
                                                {{ strtoupper(substr($user->name, 0, 2)) }}
                                            </div>
                                        @endif
                                        <div>
                                            <div class="fw-bold mb-0" style="font-size: 0.8125rem; color: #1e293b;">{{ $user->name }}</div>
                                            <div style="font-size: 0.7rem; color: #94a3b8;">{{ $user->email }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <div style="font-size: 0.8125rem; color: #334155;">{{ ucfirst($user->role) }}</div>
                                    <div style="font-size: 0.7rem; color: #94a3b8;">Type: {{ $user->type->name ?? 'N/A' }}</div>
                                </td>
                                <td>
                                    <div style="font-size: 0.8125rem; color: #334155;">{{ $user->phone ?? 'No phone' }}</div>
                                    <div style="font-size: 0.7rem; color: #94a3b8; max-width: 150px;" class="text-truncate" title="{{ $user->address }}">{{ $user->address ?? 'No address' }}</div>
                                </td>
                                <td>
                                    @if($user->is_active)
                                        <span class="badge" style="font-size: 0.65rem; background: rgba(16, 185, 129, 0.1); color: #059669; border: 1px solid rgba(16, 185, 129, 0.2);">
                                            Active
                                        </span>
                                    @else
                                        <span class="badge" style="font-size: 0.65rem; background: rgba(239, 68, 68, 0.1); color: #dc2626; border: 1px solid rgba(239, 68, 68, 0.2);">
                                            Inactive
                                        </span>
                                    @endif
                                </td>
                                <td class="text-end px-4">
                                    <div class="dropdown">
                                        <button class="btn btn-sm btn-link text-muted p-0" data-bs-toggle="dropdown" data-bs-boundary="viewport"><i class="bi bi-three-dots-vertical"></i></button>
                                        <ul class="dropdown-menu dropdown-menu-end shadow-sm" style="font-size: 0.8125rem;">
                                            <li>
                                                <a class="dropdown-item py-2" href="{{ route('users.edit', $user->id) }}" wire:navigate>
                                                    <i class="bi bi-pencil-square me-2 text-primary"></i> Edit Member
                                                </a>
                                            </li>
                                            <li><hr class="dropdown-divider"></li>
                                            <li>
                                                <button class="dropdown-item py-2 text-danger" 
                                                        wire:click="delete({{ $user->id }})" 
                                                        wire:confirm="Are you sure you want to permanently delete this user record? This action cannot be undone.">
                                                    <i class="bi bi-trash3 me-2"></i> Delete Record
                                                </button>
                                            </li>
                                        </ul>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="py-5 text-center text-muted">
                                    <i class="bi bi-people mb-2 d-block" style="font-size: 2rem; opacity: 0.3;"></i>
                                    <div style="font-size: 0.875rem;">No user records found matching your criteria.</div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        <div class="card-footer bg-white border-0 py-3">
            {{ $users->links() }}
        </div>
    </div>
</div>