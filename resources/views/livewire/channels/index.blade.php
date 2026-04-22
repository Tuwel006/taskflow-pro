<div>
    <x-page-header title="Teams" subtitle="Manage your teams" :breadcrumbItems="[['label' => 'Teams', 'url' => '/teams'], ['label' => 'List']]">
        <x-slot name="actions">
            <a href="/teams/create" wire:navigate class="btn btn-primary px-3 shadow-sm d-flex align-items-center"
                style="font-size: 0.8125rem; font-weight: 600; border-radius: 6px; background: #0f172a; border: none;">
                <i class="bi bi-plus me-2"></i> Add Team
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

    <x-data-table :items="$channels" emptyIcon="bi-people" emptyText="No channel records found matching your criteria.">
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
            <x-table.th>Name</x-table.th>
            <x-table.th>Prefix</x-table.th>
            <x-table.th>Status</x-table.th>
            <x-table.th align="end"></x-table.th>
        </x-slot>

        @foreach ($channels as $channel)
            <x-table.row wire:key="channel-{{ $channel->id }}">
                <x-table.td>
                    <div class="d-flex align-items-center gap-3">
                        <div>
                            <div class="fw-bold text-dark" style="font-size: 0.875rem;">{{ $channel->id }}</div>
                        </div>
                    </div>
                </x-table.td>
                <x-table.td>
                    <div class="d-flex align-items-center gap-3">
                        <div>
                            <div class="fw-bold text-dark" style="font-size: 0.875rem;">{{ $channel->name }}</div>
                        </div>
                    </div>
                </x-table.td>

                <x-table.td>
                    <div class="d-flex flex-column">
                        <span class="fw-bold text-dark"
                            style="font-size: 0.875rem;">{{ $channel->prefix ?? 'N/A' }}</span>
                    </div>
                </x-table.td>

                <x-table.td>
                    @if ($channel->is_active)
                        <span class="badge bg-success-subtle text-success border border-success-subtle"
                            style="font-size: 0.65rem; font-weight: 600; padding: 0.35em 0.65em;">
                            <i class="bi bi-circle-fill me-1" style="font-size: 0.5rem;"></i> Active
                        </span>
                    @else
                        <span class="badge bg-secondary-subtle text-secondary border border-secondary-subtle"
                            style="font-size: 0.65rem; font-weight: 600; padding: 0.35em 0.65em;">
                            <i class="bi bi-circle-fill me-1" style="font-size: 0.5rem;"></i> Inactive
                        </span>
                    @endif
                </x-table.td>

                <x-table.td align="end">
                    <div class="d-flex justify-content-end gap-2">
                        <a href="/channels/{{ $channel->id }}/edit" wire:navigate
                            class="btn btn-sm btn-outline-secondary border-0" style="font-size: 0.75rem;"
                            title="Edit">
                            <i class="bi bi-pencil"></i>
                        </a>
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
