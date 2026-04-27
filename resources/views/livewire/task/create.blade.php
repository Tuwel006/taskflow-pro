<div class="jira-v5-container">
    {{-- Header Content --}}
    <div class="d-flex justify-content-between align-items-center px-4 py-2 bg-light border-bottom">
        <div class="d-flex align-items-center gap-2">
            @php $selectedType = $taskTypes->firstWhere('id', $task_type_id); @endphp
            <div class="type-badge bg-primary-subtle px-2 py-1 rounded d-flex align-items-center gap-2">
                <i class="bi {{ $selectedType->icon ?? 'bi-tag-fill' }} text-primary"></i>
                <span class="fw-bold x-small text-primary uppercase ls-1">{{ $selectedType->name ?? 'TASK' }}</span>
            </div>
            <span class="text-muted small">/ Create Issue</span>
        </div>
        <div class="d-flex gap-2">
            <button type="button" class="btn btn-icon-sm"><i class="bi bi-eye"></i></button>
            <button type="button" class="btn btn-icon-sm"><i class="bi bi-share"></i></button>
            <button type="button" class="btn btn-icon-sm"><i class="bi bi-three-dots"></i></button>
        </div>
    </div>

    <div class="row g-0 flex-grow-1" style="min-height: 500px;">
        {{-- Main Area --}}
        <div class="col-lg-8 border-end bg-white p-4">
            {{-- Summary --}}
            <div class="mb-3">
                <input type="text" wire:model="title" class="jira-summary-h1" placeholder="What needs to be done?">
                @error('title')
                    <div class="text-danger mt-1 small">{{ $message }}</div>
                @enderror
            </div>

            {{-- Toolbar --}}
            <div class="d-flex align-items-center gap-2 mb-4">
                <div class="btn-group shadow-xs rounded overflow-hidden">
                    <button type="button" class="btn btn-light btn-sm border-end"><i class="bi bi-paperclip me-1"></i>
                        Attach</button>
                    <button type="button" class="btn btn-light btn-sm border-end"><i class="bi bi-list-check me-1"></i>
                        Subtask</button>
                    <button type="button" class="btn btn-light btn-sm"><i class="bi bi-link-45deg me-1"></i>
                        Link</button>
                </div>
                <div class="dropdown">
                    <button class="btn btn-light btn-sm border" type="button">
                        <i class="bi bi-three-dots"></i>
                    </button>
                </div>
            </div>

            {{-- Description --}}
            <div class="mb-4">
                <label class="form-label fw-bold text-muted small text-uppercase">Description</label>
                <textarea wire:model="description" class="form-control jira-desc-box" placeholder="Add a more detailed description..."
                    rows="6"></textarea>
            </div>

            {{-- Activity --}}
            <div class="activity-block mt-auto">
                <label class="form-label fw-bold text-muted small text-uppercase mb-3">Activity</label>
                <div class="d-flex gap-3">
                    <x-user-avatar :user="auth()->user()" size="32px" />
                    <div class="flex-grow-1">
                        <div class="comment-input-box">
                            <input type="text" class="form-control border-0 shadow-none"
                                placeholder="Add a comment...">
                            <div class="mt-1 x-small text-muted px-2">Pro-tip: press <span
                                    class="badge bg-light text-dark border fw-normal">M</span> to comment</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Sidebar Details --}}
        <div class="col-lg-4 bg-white p-4 d-flex flex-column">
            {{-- Status Pill (Top) --}}
            <div class="mb-4">
                <div class="status-dropdown-wrapper">
                    <select wire:model="status_id" class="form-select jira-status-pill">
                        @foreach ($statuses as $status)
                            <option value="{{ $status->id }}">{{ strtoupper($status->name) }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="details-section">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <span class="fw-bold text-dark small">Details</span>
                    <i class="bi bi-chevron-up text-muted"></i>
                </div>

                <div class="field-list">
                    {{-- Assignee --}}
                    <div class="field-row py-2 border-bottom">
                        <div class="field-label">Assignee</div>
                        <div class="field-control">
                            <div class="d-flex align-items-center gap-2 assignee-trigger">
                                @php $assignee = $users->firstWhere('id', $assigned_to); @endphp
                                <x-user-avatar :user="$assignee" size="24px" />
                                <div class="flex-grow-1">
                                    <select wire:model.live="assigned_to" class="form-select select-clean fw-medium">
                                        <option value="">Unassigned</option>
                                        @foreach ($users as $user)
                                            <option value="{{ $user->id }}">{{ $user->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Priority --}}
                    <div class="field-row py-2 border-bottom">
                        <div class="field-label">Priority</div>
                        <div class="field-control">
                            <select wire:model="priority" class="form-select select-clean text-primary fw-bold">
                                <option value="Low">Low</option>
                                <option value="Medium">Medium</option>
                                <option value="High">High</option>
                                <option value="Urgent">Urgent</option>
                            </select>
                        </div>
                    </div>

                    {{-- Due Date --}}
                    <div class="field-row py-2 border-bottom">
                        <div class="field-label">Due Date</div>
                        <div class="field-control">
                            <input type="date" wire:model="due_date"
                                class="form-control border-0 p-0 shadow-none small fw-medium">
                        </div>
                    </div>

                    {{-- Task Type --}}
                    <div class="field-row py-2 border-bottom">
                        <div class="field-label">Type</div>
                        <div class="field-control">
                            <select wire:model.live="task_type_id" class="form-select select-clean fw-medium">
                                @foreach ($taskTypes as $type)
                                    <option value="{{ $type->id }}">{{ $type->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Create Button (Fixed at Bottom) --}}
            <div class="mt-auto pt-4">
                <button type="submit" class="btn btn-primary w-100 py-2 fw-bold jira-btn-primary">
                    <span wire:loading.remove wire:target="store">Create Task</span>
                    <span wire:loading wire:target="store" class="spinner-border spinner-border-sm me-2"></span>
                    <span wire:loading wire:target="store">Saving...</span>
                </button>
                @if ($inModal)
                    <button type="button" @click="open = false"
                        class="btn btn-link w-100 text-muted small text-decoration-none mt-2">Dismiss</button>
                @endif
            </div>
        </div>
    </div>

    <style>
        .jira-v5-container {
            background: #ffffff;
            border-radius: 8px;
            font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif;
            display: flex;
            flex-direction: column;
        }

        .x-small {
            font-size: 0.7rem;
        }

        .ls-1 {
            letter-spacing: 0.5px;
        }

        .type-badge {
            height: 24px;
        }

        .jira-summary-h1 {
            width: 100%;
            border: none;
            padding: 0;
            font-size: 1.5rem;
            font-weight: 700;
            color: #172B4D;
            outline: none;
            background: transparent;
        }

        .jira-summary-h1:focus {
            color: #0052CC;
        }

        .btn-icon-sm {
            background: transparent;
            border: none;
            padding: 4px 8px;
            color: #42526E;
            border-radius: 3px;
        }

        .btn-icon-sm:hover {
            background: #EBECF0;
        }

        .jira-desc-box {
            border: 2px solid #DFE1E6;
            border-radius: 3px;
            font-size: 0.9rem;
            padding: 12px;
            transition: border-color 0.2s;
        }

        .jira-desc-box:focus {
            border-color: #4C9AFF;
            box-shadow: none;
        }

        .comment-input-box {
            border: 2px solid #DFE1E6;
            border-radius: 3px;
            padding: 5px;
        }

        .jira-status-pill {
            background: #DEEBFF;
            color: #0052CC;
            border: none;
            font-size: 0.75rem;
            fw: 800;
            padding: 6px 12px;
            width: fit-content;
            border-radius: 3px;
            font-weight: 800;
        }

        .field-list {
            display: flex;
            flex-direction: column;
        }

        .field-row {
            display: grid;
            grid-template-columns: 100px 1fr;
            align-items: center;
            gap: 10px;
        }

        .field-label {
            font-size: 0.75rem;
            font-weight: 700;
            color: #6B778C;
        }

        .field-control {
            font-size: 0.8rem;
        }

        .select-clean {
            border: none;
            background: transparent;
            padding: 0;
            box-shadow: none !important;
            font-size: 0.8rem;
            cursor: pointer;
            color: #0052CC;
        }

        .select-clean:hover {
            background: #F4F5F7;
            border-radius: 3px;
            padding-left: 2px;
        }

        .jira-btn-primary {
            background: #0052CC;
            border: none;
            border-radius: 3px;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
        }

        .jira-btn-primary:hover {
            background: #0747A6;
        }

        .uppercase {
            text-transform: uppercase;
        }

        .shadow-xs {
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
        }
    </style>
</div>
