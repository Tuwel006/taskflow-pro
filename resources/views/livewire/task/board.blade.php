<div class="container-fluid py-2">
    <x-page-header title="Tasks" subtitle="Manage all tasks within teams" :breadcrumbItems="[['label' => 'Tasks']]">
        <x-slot name="actions">
            <a href="/tasks/create" wire:navigate class="btn btn-primary px-3 shadow-sm d-flex align-items-center"
                style="font-size: 0.8125rem; font-weight: 600; border-radius: 6px; background: #0f172a; border: none;">
                <i class="bi bi-plus me-2"></i> Create Task
            </a>
        </x-slot>
    </x-page-header>

    <!-- Team Selection - Clean & Modern -->
    <div class="mb-3" style="background: linear-gradient(to right, #f8fafc, #f1f5f9); padding: 0.875rem 1.25rem; border-radius: 0.5rem; border-left: 4px solid #3b82f6;">
        <div class="row align-items-center g-2">
            <div class="col-auto">
                <label class="form-label fw-semibold mb-0" style="font-size: 0.7rem; color: #64748b; text-transform: uppercase; letter-spacing: 0.05em; margin-bottom: 0.3rem !important;">Team</label>
                <select wire:model.live="selectedTeam" class="form-select shadow-sm" 
                    style="font-size: 0.95rem; font-weight: 600; border: 2px solid #3b82f6; padding: 0.5rem 0.875rem; background: white; color: #0f172a; cursor: pointer; min-width: 240px; border-radius: 0.375rem; transition: all 0.2s ease;">
                    @foreach ($teams as $team)
                        <option value="{{ $team->id }}" @selected($selectedTeam == $team->id)>
                            {{ $team->name }}
                        </option>
                    @endforeach
                </select>
            </div>
            @if ($selectedTeam)
                @php
                    $currentTeam = $teams->find($selectedTeam);
                @endphp
                @if ($currentTeam)
                    <div class="col-auto ms-auto">
                        <div class="d-flex align-items-center gap-1 px-2 py-1" style="background: rgba(59, 130, 246, 0.08); border-radius: 0.3rem;">
                            <span class="fw-bold" style="font-size: 0.75rem; color: #3b82f6; background: white; padding: 0.2rem 0.5rem; border-radius: 0.2rem; min-width: 40px; text-align: center;">{{ $currentTeam->prefix }}</span>
                            <span style="font-size: 0.7rem; color: #3b82f6; font-weight: 500;">Active</span>
                        </div>
                    </div>
                @endif
            @endif
        </div>
    </div>

    <!-- Tabs & Filters Row -->
    <div class="d-flex flex-wrap gap-2 align-items-center mb-3">
        <!-- View Toggle (Tabs) -->
        <div class="nav nav-pills bg-white p-1 rounded shadow-sm border"
            style="background: #fff; border: 1px solid #e2e8f0 !important;">
            <button wire:click="setViewMode('list')"
                class="nav-link py-1 px-3 {{ $viewMode === 'list' ? 'active' : '' }}"
                style="font-size: 0.75rem; font-weight: 600; {{ $viewMode === 'list' ? 'background: #0f172a;' : 'color: #64748b;' }}">
                <i class="bi bi-list-task me-1"></i> List
            </button>
            <button wire:click="setViewMode('kanban')"
                class="nav-link py-1 px-3 {{ $viewMode === 'kanban' ? 'active' : '' }}"
                style="font-size: 0.75rem; font-weight: 600; {{ $viewMode === 'kanban' ? 'background: #0f172a;' : 'color: #64748b;' }}">
                <i class="bi bi-kanban me-1"></i> Kanban
            </button>
        </div>

        @if ($viewMode === 'list')
            <!-- Small Filters for List View -->
            <div class="input-group input-group-sm" style="max-width: 200px;">
                <span class="input-group-text bg-white border-end-0 text-muted" style="border: 1px solid #e2e8f0; font-size: 0.75rem;">
                    <i class="bi bi-search"></i>
                </span>
                <input wire:model.live.debounce.500ms="search" type="text"
                    class="form-control border-start-0" style="border: 1px solid #e2e8f0; font-size: 0.75rem;"
                    placeholder="Search...">
            </div>
            <select wire:model.live="status" class="form-select form-select-sm shadow-sm"
                style="max-width: 110px; border: 1px solid #e2e8f0; font-size: 0.75rem;">
                <option value="">Status</option>
                @foreach (\App\Models\TaskStatus::all() as $s)
                    <option>{{ $s->name }}</option>
                @endforeach
            </select>
            <select wire:model.live="priority" class="form-select form-select-sm shadow-sm"
                style="max-width: 100px; border: 1px solid #e2e8f0; font-size: 0.75rem;">
                <option value="">Priority</option>
                <option>Urgent</option>
                <option>High</option>
                <option>Medium</option>
                <option>Low</option>
            </select>

            <div class="ms-auto" wire:loading.remove wire:target="search, status, priority, selectedTeam, setViewMode">
                <span class="text-muted" style="font-size: 0.75rem;">Showing matches</span>
            </div>
        @else
            <!-- Kanban View Filters -->
            <div class="input-group input-group-sm ms-auto" style="max-width: 200px;">
                <span class="input-group-text bg-white border-end-0 text-muted" style="border: 1px solid #e2e8f0; font-size: 0.75rem;">
                    <i class="bi bi-search"></i>
                </span>
                <input wire:model.live.debounce.500ms="search" type="text"
                    class="form-control border-start-0" style="border: 1px solid #e2e8f0; font-size: 0.75rem;"
                    placeholder="Search...">
            </div>
        @endif

        <div wire:loading wire:target="search, status, priority, selectedTeam, setViewMode">
            <span class="spinner-border spinner-border-sm text-primary" role="status"
                style="width: 0.8rem; height: 0.8rem;"></span>
        </div>
    </div>

    @if ($viewMode === 'list')
        <!-- Reusable Task List Component -->
        <x-task-list :tasks="$tasks" scope="team" />
    @else
        <!-- Kanban Layout -->
        <div class="kanban-container pb-4" x-data="{
            initSortable() {
                const columns = this.$el.querySelectorAll('.kanban-column-content');
                columns.forEach(column => {
                    if (column.sortable) {
                        column.sortable.destroy();
                    }
                    column.sortable = new Sortable(column, {
                        group: 'tasks',
                        animation: 150,
                        ghostClass: 'kanban-ghost',
                        onEnd: (evt) => {
                            const taskId = evt.item.getAttribute('data-id');
                            const newStatusId = evt.to.getAttribute('data-status-id');
                            if (evt.from !== evt.to) {
                                $wire.updateStatus(taskId, newStatusId);
                            }
                        }
                    });
                });
            }
        }" x-init="initSortable()"
            @taskUpdated.window="initSortable()">
            <div class="kanban-wrapper d-flex gap-3 overflow-auto pb-3"
                style="min-height: calc(100vh - 280px); align-items: flex-start; padding: 0.5rem;">
                @foreach ($statuses as $status)
                    <div class="kanban-column flex-shrink-0" wire:key="status-{{ $status->id }}"
                        style="min-width: 350px; width: 350px;">
                        <!-- Column Header -->
                        <div class="bg-white rounded-top p-3 border-bottom shadow-sm"
                            style="border-bottom: 3px solid #0f172a;">
                            <div class="d-flex align-items-center justify-content-between mb-2">
                                <div class="d-flex align-items-center gap-2">
                                    <span class="fw-bold text-dark"
                                        style="font-size: 0.9375rem;">{{ $status->name }}</span>
                                    <span class="badge bg-secondary"
                                        style="font-size: 0.65rem; padding: 0.25rem 0.5rem;">{{ $status->tasks->count() }}</span>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Column Content -->
                        <div class="kanban-column-content rounded-bottom" data-status-id="{{ $status->id }}"
                            style="min-height: 400px; background: #f8fafc; padding: 1rem 0.75rem; border-radius: 0 0 0.375rem 0.375rem;">
                            @forelse ($status->tasks as $task)
                                <div class="kanban-card mb-3 bg-white rounded p-3 shadow-sm border"
                                    wire:key="task-{{ $task->id }}" data-id="{{ $task->id }}"
                                    style="cursor: grab; border: 1px solid #e2e8f0; transition: all 0.2s ease; min-height: auto;">
                                    <!-- Task Header -->
                                    <div class="d-flex justify-content-between align-items-start mb-2">
                                        <h6 class="fw-bold mb-0 text-dark flex-grow-1" style="font-size: 0.875rem; line-height: 1.3;">
                                            {{ $task->title }}
                                        </h6>
                                        <span class="badge ms-2 flex-shrink-0"
                                            style="font-size: 0.6rem; padding: 0.25rem 0.4rem; background: {{ $task->priority === 'Urgent' ? '#dc2626' : ($task->priority === 'High' ? '#ea580c' : ($task->priority === 'Medium' ? '#ca8a04' : '#16a34a')) }}; color: white;">
                                            {{ $task->priority }}
                                        </span>
                                    </div>

                                    <!-- Task Description -->
                                    @if ($task->description)
                                        <p class="text-muted mb-3" style="font-size: 0.8125rem; line-height: 1.4; margin-bottom: 0.75rem;">
                                            {{ Str::limit($task->description, 90) }}
                                        </p>
                                    @endif

                                    <!-- Task Meta Information -->
                                    <div class="border-top pt-2 mb-2" style="border-color: #f1f5f9;">
                                        <div class="d-flex justify-content-between align-items-center mb-2">
                                            @if ($task->assignee)
                                                <div class="d-flex align-items-center gap-2">
                                                    <img src="{{ $task->assignee->avatar ?? 'https://via.placeholder.com/28' }}"
                                                        alt="Assignee" class="rounded-circle" style="width: 28px; height: 28px; border: 1px solid #e2e8f0;">
                                                    <div style="flex: 1;">
                                                        <div class="text-muted" style="font-size: 0.7rem;">Assigned to</div>
                                                        <div class="fw-semibold text-dark" style="font-size: 0.75rem;">{{ $task->assignee->name }}</div>
                                                    </div>
                                                </div>
                                            @else
                                                <div class="text-muted" style="font-size: 0.75rem;">
                                                    <i class="bi bi-person-slash me-1"></i> Unassigned
                                                </div>
                                            @endif
                                        </div>
                                    </div>

                                    <!-- Team Badge -->
                                    @if ($task->team)
                                        <div class="d-flex justify-content-between align-items-center pt-2" style="border-top: 1px solid #f1f5f9;">
                                            <span class="badge bg-info text-white" style="font-size: 0.65rem; padding: 0.3rem 0.6rem;">
                                                <i class="bi bi-people me-1" style="font-size: 0.6rem;"></i>{{ $task->team->name }}
                                            </span>
                                        </div>
                                    @endif
                                </div>
                            @empty
                                <div class="text-center py-8 text-muted"
                                    style="padding: 2rem 0.75rem; color: #94a3b8;">
                                    <i class="bi bi-inbox" style="font-size: 2rem; display: block; margin-bottom: 0.5rem;"></i>
                                    <div style="font-size: 0.875rem;">No tasks here</div>
                                </div>
                            @endforelse
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    @endif
</div>
