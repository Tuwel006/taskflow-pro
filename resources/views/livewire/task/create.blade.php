<div class="custom-task-modal bg-white rounded-3 shadow-sm border overflow-hidden">
    {{-- Header --}}
    <div class="modal-header px-4 py-3 bg-light border-bottom d-flex justify-content-between align-items-center">
        <div class="d-flex align-items-center gap-3">
            <div class="icon-box bg-dark text-white rounded-circle d-flex align-items-center justify-content-center"
                style="width: 32px; height: 32px;">
                <i class="bi bi-journal-plus" style="font-size: 0.9rem;"></i>
            </div>
            <div>
                <h6 class="mb-0 fw-bold text-dark ls-sm">Create New Task</h6>
                <div class="x-small text-muted mt-1">Fill in the details below to add a task</div>
            </div>
            {{-- <div>
                <select>{{ $curr_team->name }}</
            </div> --}}
        </div>
        <div class="d-flex align-items-center gap-2 mt-1">
    <span class="badge bg-primary-subtle text-primary border fw-medium px-2 py-1">
        <i class="bi bi-people-fill me-1"></i>
        {{ $curr_team->name }}
    </span>
</div>
        @if ($inModal)
            <button type="button" @click="open = false" class="btn-close shadow-none"
                style="font-size: 0.75rem;"></button>
        @endif
    </div>

    {{-- Body --}}
    <form wire:submit.prevent="store" class="modal-body p-4">
        {{-- Title --}}
        <div class="mb-3">
            <label class="form-label text-muted fw-semibold x-small text-uppercase ls-sm mb-1">Task Title <span
                    class="text-danger">*</span></label>
            <input type="text" wire:model="title" class="form-control form-control-sm custom-input"
                placeholder="e.g., Design the new landing page" autofocus>
            @error('title')
                <span class="text-danger x-small mt-1 d-block">{{ $message }}</span>
            @enderror
        </div>

        {{-- Row 1: Type and Status --}}
        <div class="row g-3 mb-3">
            <div class="col-md-6">
                <label class="form-label text-muted fw-semibold x-small text-uppercase ls-sm mb-1">Task Type</label>
                <select wire:model.live="task_type_id" class="form-select form-select-sm custom-input">
                    @foreach ($taskTypes as $type)
                        <option value="{{ $type->id }}">{{ $type->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-6">
                <label class="form-label text-muted fw-semibold x-small text-uppercase ls-sm mb-1">Status</label>
                <select disabled='true' wire:model="status_id" class="form-select form-select-sm custom-input">
                    @foreach ($statuses as $status)
                        <option value="{{ $status->id }}">{{ $status->name }}</option>
                    @endforeach
                </select>
            </div>
        </div>

        {{-- Row 2: Priority and Due Date --}}
        <div class="row g-3 mb-3">
            <div class="col-md-6">
                <label class="form-label text-muted fw-semibold x-small text-uppercase ls-sm mb-1">Priority</label>
                <select wire:model="priority" class="form-select form-select-sm custom-input">
                    <option value="Low">Low</option>
                    <option value="Medium">Medium</option>
                    <option value="High">High</option>
                    <option value="Urgent">Urgent</option>
                </select>
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
            <div class="d-flex align-items-center gap-2">
                @php $assignee = $users->firstWhere('id', $assigned_to); @endphp
                @if ($assignee)
                    <x-user-avatar :user="$assignee" size="28px" />
                @else
                    <div class="bg-light rounded-circle border d-flex align-items-center justify-content-center text-muted"
                        style="width: 28px; height: 28px;">
                        <i class="bi bi-person"></i>
                    </div>
                @endif
                <select wire:model.live="assigned_to" class="form-select form-select-sm custom-input flex-grow-1">
                    <option value="">Unassigned</option>
                    @foreach ($users as $user)
                        <option value="{{ $user->id }}">{{ $user->name }}</option>
                    @endforeach
                </select>
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
            @if ($inModal)
                <button type="button" @click="open = false"
                    class="btn btn-sm btn-light border fw-medium px-3 custom-btn-cancel">Cancel</button>
            @endif
            <button type="submit"
                class="btn btn-sm btn-dark fw-medium px-4 custom-btn-primary d-flex align-items-center gap-2">
                <span wire:loading.remove wire:target="store">
                    <i class="bi bi-check2"></i> Create Task
                </span>
                <span wire:loading wire:target="store">
                    <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                    Saving...
                </span>
            </button>
        </div>
    </form>

    <style>
        .custom-task-modal {
            font-family: 'Inter', system-ui, -apple-system, "Segoe UI", Roboto, sans-serif;
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
            box-shadow: inset 0 1px 2px rgba(0, 0, 0, 0.01);
        }

        .custom-input:focus {
            background-color: #ffffff;
            border-color: #94a3b8;
            box-shadow: 0 0 0 3px rgba(241, 245, 249, 0.8);
            outline: none;
        }

        .custom-input::placeholder {
            color: #94a3b8;
        }

        select.custom-input {
            cursor: pointer;
        }

        .custom-btn-primary {
            background-color: #0f172a;
            border-color: #0f172a;
            border-radius: 6px;
            transition: all 0.2s ease;
            box-shadow: 0 2px 4px rgba(15, 23, 42, 0.1);
        }

        .custom-btn-primary:hover,
        .custom-btn-primary:focus {
            background-color: #1e293b;
            border-color: #1e293b;
            transform: translateY(-1px);
            box-shadow: 0 4px 6px rgba(15, 23, 42, 0.15);
        }

        .custom-btn-primary:active {
            transform: translateY(0);
        }

        .custom-btn-cancel {
            border-radius: 6px;
            background-color: #ffffff;
            color: #64748b;
            transition: all 0.2s ease;
        }

        .custom-btn-cancel:hover {
            background-color: #f8fafc;
            color: #0f172a;
            border-color: #cbd5e1 !important;
        }

        .modal-header .btn-close {
            opacity: 0.4;
            transition: opacity 0.2s;
        }

        .modal-header .btn-close:hover {
            opacity: 1;
        }

        /* Custom scrollbar for textarea if needed */
        textarea.custom-input::-webkit-scrollbar {
            width: 6px;
        }

        textarea.custom-input::-webkit-scrollbar-track {
            background: transparent;
        }

        textarea.custom-input::-webkit-scrollbar-thumb {
            background-color: #cbd5e1;
            border-radius: 10px;
        }
    </style>
</div>
