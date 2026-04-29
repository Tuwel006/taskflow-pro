<div class="container-fluid py-2">
    <x-page-header title="User Management" subtitle="Maintain and audit your organization's human capital"
        :breadcrumbItems="[['label' => 'Team', 'url' => '/users'], ['label' => 'Directory']]">
        <x-slot name="actions">
            <a href="/users/create" wire:navigate class="btn btn-primary px-3 shadow-sm d-flex align-items-center"
                style="font-size: 0.8125rem; font-weight: 600; border-radius: 6px; background: #0f172a; border: none;">
                <i class="bi bi-person-plus me-2"></i> Add User
            </a>
        </x-slot>
    </x-page-header>

    @if (session()->has('message'))
        <div class="alert alert-success border-0 shadow-sm d-flex align-items-center" role="alert"
            style="background: #ecfdf5; color: #065f46; border-radius: 8px; font-size: 0.8125rem;">
            <i class="bi bi-check-circle-fill me-2"></i>
            <div>{{ session('message') }}</div>
            <button type="button" class="btn-close ms-auto" data-bs-dismiss="alert" aria-label="Close"
                style="font-size: 0.6rem;"></button>
        </div>
    @endif

    @if (session()->has('success'))
        <div class="alert alert-success border-0 shadow-sm d-flex align-items-center" role="alert"
            style="background: #ecfdf5; color: #065f46; border-radius: 8px; font-size: 0.8125rem;">
            <i class="bi bi-check-circle-fill me-2"></i>
            <div>{{ session('success') }}</div>
            <button type="button" class="btn-close ms-auto" data-bs-dismiss="alert" aria-label="Close"
                style="font-size: 0.6rem;"></button>
        </div>
    @endif

    <!-- Stats summary -->
    <div class="row g-3 mb-4">
        <div class="col-6 col-md-3">
            <div class="card border-0"
                style="background: #fff; border: 1px solid #e2e8f0 !important; border-radius: 8px;">
                <div class="card-body p-3">
                    <div class="text-uppercase text-muted fw-bold mb-1"
                        style="font-size: 0.65rem; letter-spacing: 0.05em;">Total Users</div>
                    <div class="h5 fw-bold mb-0">{{ $users->total() }}</div>
                </div>
            </div>
        </div>
        <div class="col-6 col-md-3">
            <div class="card border-0"
                style="background: #fff; border: 1px solid #e2e8f0 !important; border-radius: 8px;">
                <div class="card-body p-3">
                    <div class="text-uppercase text-muted fw-bold mb-1"
                        style="font-size: 0.65rem; letter-spacing: 0.05em;">Active Now</div>
                    <div class="h5 fw-bold mb-0 text-success">{{ $users->where('is_active', true)->count() }}</div>
                </div>
            </div>
        </div>
    </div>

    <!-- Filters & Table -->
    <x-data-table :items="$users" emptyIcon="bi-people" emptyText="No user records found matching your criteria.">
        <x-slot name="header">
            <div class="row g-2 align-items-center">
                <div class="col-md-4">
                    <div class="input-group input-group-sm">
                        <span class="input-group-text bg-white border-end-0 text-muted">
                            <i class="bi bi-search" wire:loading.remove wire:target="search"></i>
                            <div class="spinner-border spinner-border-sm text-primary" role="status" wire:loading
                                wire:target="search"></div>
                        </span>
                        <input wire:model.live.debounce.500ms="search" type="text"
                            class="form-control border-start-0" placeholder="Search by name, email or phone...">
                    </div>
                </div>
                <div class="col-md-auto ms-auto d-flex gap-2 align-items-center">
                    <div class="d-flex align-items-center gap-2 me-2">
                        <label class="text-muted mb-0 small" style="white-space: nowrap;">Show</label>
                        <select class="form-select form-select-sm" style="width: 70px;" wire:model.live="itemPerPage">
                            <option value="5">5</option>
                            <option value="10">10</option>
                            <option value="25">25</option>
                            <option value="50">50</option>
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
        </x-slot>

        <x-slot name="columns">
            <x-table.th>Member</x-table.th>
            <x-table.th>Role & Type</x-table.th>
            <x-table.th>Contact Info</x-table.th>
            <x-table.th>Teams</x-table.th>
            <x-table.th>Status</x-table.th>
            <x-table.th align="end"></x-table.th>
        </x-slot>

        @foreach ($users as $user)
            <x-table.row wire:key="user-{{ $user->id }}">
                <x-table.td>
                    <div class="d-flex align-items-center gap-3">
                        <x-user-avatar :user="$user" size="36px" fontsize="0.8rem" />
                        <div>
                            <div class="fw-bold mb-0" style="font-size: 0.8125rem; color: #1e293b;">{{ $user->name }}
                            </div>
                            <div style="font-size: 0.7rem; color: #94a3b8;">{{ $user->email }}</div>
                        </div>
                    </div>
                </x-table.td>
                <x-table.td>
                    <div style="font-size: 0.8125rem; color: #334155;">{{ ucfirst($user->role) }}</div>
                    <div style="font-size: 0.7rem; color: #94a3b8;">Type: {{ $user->type->name ?? 'N/A' }}</div>
                </x-table.td>
                <x-table.td>
                    <div style="font-size: 0.8125rem; color: #334155;">{{ $user->phone ?? 'No phone' }}</div>
                    <div style="font-size: 0.7rem; color: #94a3b8; max-width: 150px;" class="text-truncate"
                        title="{{ $user->address }}">{{ $user->address ?? 'No address' }}</div>
                </x-table.td>
                <x-table.td>
                    <div class="d-flex flex-wrap gap-1" style="max-width: 180px;">
                        @forelse($user->teams as $team)
                            <span class="badge"
                                style="font-size: 0.65rem; background: #e0f2fe; color: #0369a1; border: 1px solid #bae6fd;">
                                <i class="bi bi-people-fill me-1"></i>{{ $team->name }}
                            </span>
                        @empty
                            <span class="text-muted" style="font-size: 0.7rem;">None</span>
                        @endforelse
                    </div>
                </x-table.td>
                <x-table.td>
                    @if ($user->is_active)
                        <span class="badge"
                            style="font-size: 0.65rem; background: rgba(16, 185, 129, 0.1); color: #059669; border: 1px solid rgba(16, 185, 129, 0.2);">
                            Active
                        </span>
                    @else
                        <span class="badge"
                            style="font-size: 0.65rem; background: rgba(239, 68, 68, 0.1); color: #dc2626; border: 1px solid rgba(239, 68, 68, 0.2);">
                            Inactive
                        </span>
                    @endif
                </x-table.td>
                <x-table.td align="end">
                    <div class="dropdown">
                        <button class="btn btn-sm btn-link text-muted p-0" data-bs-toggle="dropdown"
                            data-bs-boundary="viewport"><i class="bi bi-three-dots-vertical"></i></button>
                        <ul class="dropdown-menu dropdown-menu-end shadow-sm border-0"
                            style="font-size: 0.8125rem; border-radius: 8px;">
                            <li>
                                <a class="dropdown-item py-2" href="{{ route('users.edit', $user->id) }}"
                                    wire:navigate>
                                    <i class="bi bi-pencil-square me-2 text-primary"></i> Edit Member
                                </a>
                            </li>
                            <li>
                                <hr class="dropdown-divider">
                            </li>
                            <li>
                                <button class="dropdown-item py-2 text-danger"
                                    wire:click="delete({{ $user->id }})"
                                    wire:confirm="Are you sure you want to permanently delete this user record? This action cannot be undone.">
                                    <i class="bi bi-trash3 me-2"></i> Delete Record
                                </button>
                            </li>
                        </ul>
                    </div>
                </x-table.td>
            </x-table.row>
        @endforeach
    </x-data-table>

</div>
