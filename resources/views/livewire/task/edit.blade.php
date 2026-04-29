<div class="custom-task-modal bg-white rounded-3 shadow-sm border overflow-hidden">
    {{-- Header --}}
    <div class="modal-header px-4 py-3 bg-light border-bottom d-flex justify-content-between align-items-center">
        <div class="d-flex align-items-center gap-3">
            <div class="icon-box bg-primary text-white rounded-circle d-flex align-items-center justify-content-center"
                style="width: 32px; height: 32px;">
                <i class="bi bi-pencil-square" style="font-size: 0.9rem;"></i>
            </div>
            <div>
                <h6 class="mb-0 fw-bold text-dark ls-sm">Edit Task <span class="text-muted opacity-50 ms-1">#{{ $task->display_id }}</span></h6>
                <div class="x-small text-muted mt-1">Modify task details and update status</div>
            </div>
        </div>
        <div class="d-flex align-items-center gap-2 mt-1">
            <span class="badge bg-primary-subtle text-primary border fw-medium px-2 py-1">
                <i class="bi bi-people-fill me-1"></i>
                {{ $task->project->name }}
            </span>
        </div>
    </div>

    {{-- Body --}}
    <form wire:submit.prevent="update" class="modal-body p-4">
        {{-- Title --}}
        <div class="mb-3">
            <label class="form-label text-muted fw-semibold x-small text-uppercase ls-sm mb-1">Task Title <span
                    class="text-danger">*</span></label>
            <input type="text" wire:model="title" class="form-control form-control-sm custom-input"
                placeholder="e.g., Design the new landing page">
            @error('title')
                <span class="text-danger x-small mt-1 d-block">{{ $message }}</span>
            @enderror
        </div>

        {{-- Row 1: Type and Status --}}
        <div class="row g-3 mb-3">
            <div class="col-md-6">
                <label class="form-label text-muted fw-semibold x-small text-uppercase ls-sm mb-1">Task Type</label>
                <div class="position-relative" x-data="{ open: false }">
                    <button type="button" @click="open = !open"
                        class="form-select form-select-sm custom-input d-flex align-items-center gap-2 text-start w-100 shadow-none">
                        @php $selectedType = $taskTypes->firstWhere('id', $task_type_id); @endphp
                        @if ($selectedType)
                            <span style="color: {{ $selectedType->color ?? '#64748b' }};">
                                {!! $selectedType->icon !!}
                            </span>
                            <span>{{ $selectedType->name }}</span>
                        @else
                            <span class="text-muted">Select Type</span>
                        @endif
                    </button>

                    <div x-show="open" 
                        x-transition:enter="transition ease-out duration-100"
                        x-transition:enter-start="opacity-0 transform scale-95"
                        x-transition:enter-end="opacity-100 transform scale-100"
                        @click.away="open = false"
                        class="position-absolute z-3 mt-1 bg-white border rounded shadow w-100 overflow-hidden"
                        style="display: none; top: 100%; min-width: 180px;">
                        @foreach ($taskTypes as $type)
                            <div @click="$wire.set('task_type_id', {{ $type->id }}); open = false"
                                class="px-3 py-2 d-flex align-items-center gap-2 cursor-pointer custom-dropdown-item {{ $task_type_id == $type->id ? 'selected' : '' }}">
                                <span style="color: {{ $type->color ?? '#64748b' }}; width: 18px; text-align: center;">
                                    {!! $type->icon !!}
                                </span>
                                <span class="small">{{ $type->name }}</span>
                                @if ($task_type_id == $type->id)
                                    <i class="bi bi-check2 ms-auto text-primary" style="font-size: 0.8rem;"></i>
                                @endif
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <label class="form-label text-muted fw-semibold x-small text-uppercase ls-sm mb-1">Status (Allowed Transitions)</label>
                <select wire:model="status_id" class="form-select form-select-sm custom-input">
                    @foreach ($statuses as $status)
                        <option value="{{ $status->id }}">{{ $status->name }} @if($status->id == $task->task_status_id) (Current) @endif</option>
                    @endforeach
                </select>
                <div class="x-small text-muted mt-1"><i class="bi bi-info-circle me-1"></i>Only valid workflow paths are shown.</div>
            </div>
        </div>

        {{-- Row 2: Priority and Due Date --}}
        <div class="row g-3 mb-3">
            <div class="col-md-6">
                <label class="form-label text-muted fw-semibold x-small text-uppercase ls-sm mb-1">Priority</label>
                <div class="position-relative" x-data="{ open: false }">
                    <button type="button" @click="open = !open"
                        class="form-select form-select-sm custom-input d-flex align-items-center gap-2 text-start w-100 shadow-none">
                        @php $selectedPriority = collect($priorities)->firstWhere('name', $priority); @endphp
                        @if ($selectedPriority)
                            <span style="color: {{ $selectedPriority['color'] ?? '#64748b' }};">
                                {!! $selectedPriority['icon'] !!}
                            </span>
                            <span>{{ $selectedPriority['name'] }}</span>
                        @else
                            <span class="text-muted">Select Priority</span>
                        @endif
                    </button>

                    <div x-show="open" 
                        x-transition:enter="transition ease-out duration-100"
                        x-transition:enter-start="opacity-0 transform scale-95"
                        x-transition:enter-end="opacity-100 transform scale-100"
                        @click.away="open = false"
                        class="position-absolute z-3 mt-1 bg-white border rounded shadow w-100 overflow-hidden"
                        style="display: none; top: 100%; min-width: 180px;">
                        @foreach ($priorities as $p)
                            <div @click="$wire.set('priority', '{{ $p['name'] }}'); open = false"
                                class="px-3 py-2 d-flex align-items-center gap-2 cursor-pointer custom-dropdown-item {{ $priority == $p['name'] ? 'selected' : '' }}">
                                <span style="color: {{ $p['color'] ?? '#64748b' }}; width: 18px; text-align: center;">
                                    {!! $p['icon'] !!}
                                </span>
                                <span class="small">{{ $p['name'] }}</span>
                                @if ($priority == $p['name'])
                                    <i class="bi bi-check2 ms-auto text-primary" style="font-size: 0.8rem;"></i>
                                @endif
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <label class="form-label text-muted fw-semibold x-small text-uppercase ls-sm mb-1">Due Date</label>
                <div class="position-relative">
                    <input type="date" wire:model="due_date" class="form-control form-control-sm custom-input">
                </div>
            </div>
        </div>

        {{-- Assignee --}}
        <div class="mb-3 border-top pt-3 mt-4">
            <label class="form-label text-muted fw-semibold x-small text-uppercase ls-sm mb-1">Assignee</label>
            <div class="position-relative" x-data="{ open: false }">
                <button type="button" @click="open = !open"
                    class="form-select form-select-sm custom-input d-flex align-items-center gap-2 text-start w-100 shadow-none">
                    @php $assignee = $users->firstWhere('id', $assigned_to); @endphp
                    @if ($assignee)
                        <x-user-avatar :user="$assignee" size="20px" />
                        <span>{{ $assignee->name }}</span>
                    @else
                        <div class="bg-light rounded-circle border d-flex align-items-center justify-content-center text-muted"
                            style="width: 20px; height: 20px; font-size: 0.7rem;">
                            <i class="bi bi-person"></i>
                        </div>
                        <span class="text-muted">Unassigned</span>
                    @endif
                </button>

                <div x-show="open" 
                    x-transition:enter="transition ease-out duration-100"
                    x-transition:enter-start="opacity-0 transform scale-95"
                    x-transition:enter-end="opacity-100 transform scale-100"
                    @click.away="open = false"
                    class="position-absolute z-3 mt-1 bg-white border rounded shadow w-100 overflow-hidden"
                    style="display: none; top: 100%; min-width: 200px;">
                    
                    <div @click="$wire.set('assigned_to', ''); open = false"
                        class="px-3 py-2 d-flex align-items-center gap-2 cursor-pointer custom-dropdown-item {{ !$assigned_to ? 'selected' : '' }}">
                        <div class="bg-light rounded-circle border d-flex align-items-center justify-content-center text-muted"
                            style="width: 20px; height: 20px; font-size: 0.7rem;">
                            <i class="bi bi-person"></i>
                        </div>
                        <span class="small">Unassigned</span>
                    </div>

                    @foreach ($users as $user)
                        <div @click="$wire.set('assigned_to', {{ $user->id }}); open = false"
                            class="px-3 py-2 d-flex align-items-center gap-2 cursor-pointer custom-dropdown-item {{ $assigned_to == $user->id ? 'selected' : '' }}">
                            <x-user-avatar :user="$user" size="20px" />
                            <span class="small">{{ $user->name }}</span>
                            @if ($assigned_to == $user->id)
                                <i class="bi bi-check2 ms-auto text-primary" style="font-size: 0.8rem;"></i>
                            @endif
                        </div>
                    @endforeach
                </div>
            </div>
        </div>

        {{-- Description --}}
        <div class="mb-4">
            <label class="form-label text-muted fw-semibold x-small text-uppercase ls-sm mb-1">Description</label>
            <textarea wire:model="description" class="form-control form-control-sm custom-input" rows="4"
                placeholder="Add more details or context about this task..."></textarea>
            @error('description')
                <span class="text-danger x-small mt-1 d-block">{{ $message }}</span>
            @enderror
        </div>

        {{-- Actions --}}
        <div class="d-flex justify-content-end gap-2 pt-3 border-top mt-2">
            <a href="/tasks" wire:navigate
                class="btn btn-sm btn-light border fw-medium px-3 custom-btn-cancel">Discard Changes</a>
            <button type="submit"
                class="btn btn-sm btn-primary fw-medium px-4 custom-btn-primary d-flex align-items-center gap-2" style="background: #0f172a; border: none;">
                <span wire:loading.remove wire:target="update">
                    <i class="bi bi-check-all"></i> Save Updates
                </span>
                <span wire:loading wire:target="update">
                    <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                    Saving...
                </span>
            </button>
        </div>
    </form>

    <style>
        .custom-task-modal {
            font-family: 'Inter', system-ui, -apple-system, "Segoe UI", Roboto, sans-serif;
            max-width: 800px;
            margin: 0 auto;
        }

        .x-small {
            font-size: 0.7rem;
        }

        .ls-sm {
            letter-spacing: 0.4px;
        }

        .custom-input {
            border-radius: 6px;
            border: 1px solid #e1e5ea;
            background-color: #f7f9fc;
            transition: all 0.2s ease;
            font-size: 0.85rem;
            padding: 0.4rem 0.6rem;
            color: #334155;
        }

        .custom-input:focus {
            background-color: #ffffff;
            border-color: #94a3b8;
            box-shadow: 0 0 0 3px rgba(241, 245, 249, 0.8);
            outline: none;
        }

        .custom-dropdown-item {
            transition: all 0.15s ease;
            user-select: none;
            cursor: pointer;
        }

        .custom-dropdown-item:hover {
            background-color: #f8fafc;
        }

        .custom-dropdown-item.selected {
            background-color: #f1f5f9;
            font-weight: 500;
        }

        .custom-btn-cancel {
            border-radius: 6px;
            text-decoration: none;
            line-height: 1.8;
        }
    </style>
</div>
