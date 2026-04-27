<div class="container-fluid py-2">
    <x-page-header title="Task Types" subtitle="Manage the types of tasks in your system" :breadcrumbItems="[['label' => 'Settings', 'url' => '#'], ['label' => 'Task Types']]">
        <x-slot name="actions">
            <button wire:click="create"
                class="btn btn-dark btn-sm rounded-pill px-3 py-2 shadow-sm d-flex align-items-center gap-2"
                style="font-weight: 500;">
                <i class="bi bi-plus-circle"></i> Create New Type
            </button>
        </x-slot>
    </x-page-header>

    @if (session()->has('message'))
        <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm rounded-3" role="alert">
            <i class="bi bi-check-circle-fill me-2"></i>
            {{ session('message') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <x-data-table :items="$taskTypes" emptyText="No task types found." emptyIcon="bi-folder2-open">
        <x-slot name="columns">
            <x-table.th>Icon</x-table.th>
            <x-table.th>Name</x-table.th>
            <x-table.th>Description</x-table.th>
            <x-table.th>Status</x-table.th>
            <x-table.th align="end">Actions</x-table.th>
        </x-slot>

        @foreach ($taskTypes as $type)
            <x-table.row wire:key="task-type-{{ $type->id }}">
                <x-table.td>
                    <div class="bg-light rounded-3 d-flex align-items-center justify-content-center"
                        style="width: 36px; height: 36px;">
                        <i class="bi {{ $type->icon ?? 'bi-tag-fill' }} text-primary"></i>
                    </div>
                </x-table.td>
                <x-table.td>
                    <span class="fw-medium text-dark">{{ $type->name }}</span>
                </x-table.td>
                <x-table.td>
                    <span class="text-muted small">{{ Str::limit($type->description, 60) ?: 'No description' }}</span>
                </x-table.td>
                <x-table.td>
                    @if ($type->is_active)
                        <span
                            class="badge bg-success-subtle text-success border border-success-subtle px-2 py-1 rounded-pill"
                            style="font-size: 0.7rem;">Active</span>
                    @else
                        <span class="badge bg-light text-muted border border-light-subtle px-2 py-1 rounded-pill"
                            style="font-size: 0.7rem;">Inactive</span>
                    @endif
                </x-table.td>
                <x-table.td align="end">
                    <div class="dropdown">
                        <button class="btn btn-sm btn-light border-0 rounded-circle" data-bs-toggle="dropdown"
                            style="width: 30px; height: 30px; padding: 0;">
                            <i class="bi bi-three-dots"></i>
                        </button>
                        <ul class="dropdown-menu dropdown-menu-end shadow-sm border-0 rounded-3 p-1">
                            <li><button type="button" class="dropdown-item py-2 rounded-2"
                                    wire:click="edit({{ $type->id }})"><i class="bi bi-pencil me-2 text-muted"></i>
                                    Edit</button></li>
                            <li>
                                <hr class="dropdown-divider my-1">
                            </li>
                            <li><button class="dropdown-item py-2 rounded-2 text-danger"
                                    wire:click="delete({{ $type->id }})"
                                    wire:confirm="Are you sure you want to delete this task type?"><i
                                        class="bi bi-trash me-2"></i> Delete</button></li>
                        </ul>
                    </div>
                </x-table.td>
            </x-table.row>
        @endforeach
    </x-data-table>

    {{-- Create Modal --}}
    <x-modal title="{{ $taskTypeId ? 'Edit Task Type' : 'Create Task Type' }}" size="lg">
        <form wire:submit="store">
            <div class="mb-3">
                <label class="form-label fw-bold small text-dark opacity-75">Name</label>
                <input type="text" wire:model="name"
                    class="form-control rounded-3 @error('name') is-invalid @enderror"
                    placeholder="e.g. Technical Support, Sales Call">
                @error('name')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label class="form-label fw-bold small text-dark opacity-75">Icon Class</label>
                <div class="input-group">
                    <span class="input-group-text bg-light text-muted border-end-0 rounded-start-3"><i
                            class="bi {{ $icon ?: 'bi-tag' }}"></i></span>
                    <input type="text" wire:model.live="icon" class="form-control border-start-0 rounded-end-3"
                        placeholder="bi-bug-fill">
                </div>
                <div class="mt-1">
                    <small class="text-muted" style="font-size: 0.725rem;">Use <a href="https://icons.getbootstrap.com/"
                            target="_blank" class="text-primary text-decoration-none">Bootstrap Icons</a>
                        classes.</small>
                </div>
            </div>

            <div class="mb-3">
                <label class="form-label fw-bold small text-dark opacity-75">Description</label>
                <textarea wire:model="description" class="form-control rounded-3" rows="3"
                    placeholder="Explain what this task type covers..."></textarea>
            </div>

            <div class="mb-4">
                <div class="form-check form-switch p-2 ps-5 border rounded-3 bg-light-subtle d-inline-block w-100">
                    <input class="form-check-input ms-n4 mt-1" type="checkbox" wire:model="is_active"
                        id="isActiveSwitch">
                    <label class="form-check-label fw-medium text-dark ms-2 mt-1" for="isActiveSwitch"
                        style="font-size: 0.85rem;">Active Status</label>
                    <small class="d-block text-muted" style="font-size: 0.7rem;">Inactive types won't appear in task
                        creation.</small>
                </div>
            </div>

            <div class="d-flex justify-content-end gap-2 pt-2">
                <button type="button" @click="open = false"
                    class="btn btn-light px-4 rounded-pill border fw-semibold small">Cancel</button>
                <button type="submit" class="btn btn-dark px-4 rounded-pill shadow-sm fw-semibold small"
                    wire:loading.attr="disabled">
                    <span wire:loading wire:target="store" class="spinner-border spinner-border-sm me-1"></span>
                    {{ $taskTypeId ? 'Update Type' : 'Create Type' }}
                </button>
            </div>
        </form>
    </x-modal>

    <style>
        .btn-icon {
            padding: 0.25rem 0.5rem;
            color: #64748b;
        }

        .btn-icon:hover {
            color: #0f172a;
            background: #f1f5f9;
        }

        .table-hover tbody tr:hover {
            background-color: #f8fafc !important;
        }

        .pagination {
            margin-bottom: 0;
            gap: 4px;
        }

        .page-link {
            border-radius: 8px !important;
            font-size: 0.8rem;
            color: #64748b;
            border: 1px solid #e2e8f0;
        }

        .page-item.active .page-link {
            background-color: #0f172a;
            border-color: #0f172a;
        }
    </style>
</div>
