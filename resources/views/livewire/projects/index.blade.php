<div>
    <x-page-header title="Projects" subtitle="Manage your projects" :breadcrumbItems="[['label' => 'Projects', 'url' => '/projects'], ['label' => 'List']]">
        <x-slot name="actions">
            <a href="/projects/create" wire:navigate class="btn btn-primary px-3 shadow-sm d-flex align-items-center"
                style="font-size: 0.8125rem; font-weight: 600; border-radius: 6px; background: #0f172a; border: none;">
                <i class="bi bi-plus me-2"></i> Add Project
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

    <x-data-table :items="$projects" emptyIcon="bi-people" emptyText="No project records found matching your criteria.">
        <x-slot name="header">
            <div class="row g-2 align-items-center">
                <div class="col-md-4">
                    <div class="input-group input-group-sm">
                        <span class="input-group-text bg-white border-end-0 text-muted">
                            <i class="bi bi-search" wire:loading.remove wire:target="search"></i>
                            <div class="spinner-border spinner-border-sm text-primary" role="status" wire:loading
                                wire:target="search"></div>
                        </span>
                        <input wire:model.live.debounce.500ms="search" type="text" style="border: none"
                            class="form-control no-border-input" placeholder="Search by name...">
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
                    <select wire:model.live="status" class="form-select form-select-sm" style="width: 130px;">
                        <option value="2">All Status</option>
                        <option value="1">Active</option>
                        <option value="0">Inactive</option>
                    </select>
                </div>
            </div>
        </x-slot>

        <x-slot name="columns">
            <x-table.th>No</x-table.th>
            <x-table.th>Project Name</x-table.th>
            <x-table.th>Prefix</x-table.th>
            <x-table.th>Description</x-table.th>
            <x-table.th>Status</x-table.th>
            <x-table.th align="end"></x-table.th>
        </x-slot>

        @foreach ($projects as $project)
            <x-table.row wire:key="project-{{ $project->id }}">
                <x-table.td>
                    <span class="text-muted fw-semibold" style="font-size: 0.8125rem;">#{{ $project->id }}</span>
                </x-table.td>
                <x-table.td>
                    <div class="fw-bold text-dark" style="font-size: 0.8125rem;">{{ $project->name }}</div>
                </x-table.td>

                <x-table.td>
                    <span class="badge bg-light text-primary border" style="font-size: 0.75rem; font-family: monospace;">{{ $project->prefix }}</span>
                </x-table.td>

                <x-table.td>
                    <div class="text-muted text-truncate" style="font-size: 0.75rem; max-width: 250px;" title="{{ $project->description }}">
                        {{ $project->description ?? 'No description provided.' }}
                    </div>
                </x-table.td>

                <x-table.td>
                    @if ($project->is_active)
                        <span class="badge" style="font-size: 0.65rem; background: #ecfdf5; color: #059669; border: 1px solid #d1fae5;">
                            Active
                        </span>
                    @else
                        <span class="badge" style="font-size: 0.65rem; background: #f1f5f9; color: #64748b; border: 1px solid #e2e8f0;">
                            Inactive
                        </span>
                    @endif
                </x-table.td>

                <x-table.td align="end">
                    <div class="d-flex justify-content-end gap-2">
                        <a href="/projects/{{ $project->id }}/edit" wire:navigate
                            class="btn btn-sm btn-outline-secondary border-0" style="font-size: 0.75rem;"
                            title="Edit">
                            <i class="bi bi-pencil"></i>
                        </a>
                        <button wire:click="delete({{ $project->id }})" 
                            wire:confirm="Are you sure you want to delete this project? This action cannot be undone."
                            class="btn btn-sm btn-outline-danger border-0" style="font-size: 0.75rem;" title="Delete">
                            <i class="bi bi-trash"></i>
                        </button>
                        <button class="btn btn-sm btn-outline-secondary border-0" style="font-size: 0.75rem;"
                            title="More">
                            <i class="bi bi-three-dots-vertical"></i>
                        </button>
                    </div>
                </x-table.td>
            </x-table.row>
        @endforeach
    </x-data-table>
</div>
