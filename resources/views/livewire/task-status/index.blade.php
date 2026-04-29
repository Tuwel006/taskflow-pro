<div>
    <x-page-header title="Task Statuses" subtitle="Manage task statuses" :breadcrumbItems="[['label' => 'Task Statuses', 'url' => '/task-statuses'], ['label' => 'List']]">
        <x-slot name="actions">
            <a href="/task-statuses/create" wire:navigate class="btn btn-primary px-3 shadow-sm d-flex align-items-center"
                style="font-size: 0.8125rem; font-weight: 600; border-radius: 6px; background: #0f172a; border: none;">
                <i class="bi bi-plus me-2"></i> Add Status
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

    <x-data-table :items="$taskStatuses" emptyIcon="bi-list-check" emptyText="No task status records found matching your criteria.">
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
                            class="form-control border-start-0" placeholder="Search by name...">
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
                </div>
            </div>
        </x-slot>

        <x-slot name="columns">
            <x-table.th>No</x-table.th>
            <x-table.th>Name</x-table.th>
            <x-table.th>Color</x-table.th>
            <x-table.th align="end"></x-table.th>
        </x-slot>

        @foreach ($taskStatuses as $status)
            <x-table.row wire:key="status-{{ $status->id }}">
                <x-table.td>
                    <div class="d-flex align-items-center gap-3">
                        <div>
                            <div class="fw-bold text-dark" style="font-size: 0.875rem;">{{ $status->id }}</div>
                        </div>
                    </div>
                </x-table.td>
                <x-table.td>
                    <div class="d-flex align-items-center gap-3">
                        <div>
                            <div class="fw-bold text-dark" style="font-size: 0.875rem;">{{ $status->name }}</div>
                        </div>
                    </div>
                </x-table.td>

                <x-table.td>
                    <div class="d-flex align-items-center gap-2">
                        <div class="rounded-circle" style="width: 16px; height: 16px; background-color: {{ $status->color }};"></div>
                        <span class="text-muted small">{{ $status->color }}</span>
                    </div>
                </x-table.td>

                <x-table.td align="end">
                    <div class="d-flex justify-content-end gap-2">
                        <a href="/task-statuses/{{ $status->id }}/edit" wire:navigate
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