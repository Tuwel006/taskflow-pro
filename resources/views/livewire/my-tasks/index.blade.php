<div class="container-fluid py-2">
    <x-page-header title="Personal Action Items" subtitle="Tasks specifically assigned to your profile" :breadcrumbItems="[['label' => 'Tasks', 'url' => '/tasks'], ['label' => 'My Tasks']]">
        <x-slot name="actions">
            <div class="bg-white border rounded px-3 py-2 d-flex align-items-center shadow-sm">
                <span class="text-muted small me-2">Personal Efficiency:</span>
                <span class="fw-bold text-success">84%</span>
            </div>
        </x-slot>
    </x-page-header>

    <!-- Tabs & Filters Row -->
    <div class="d-flex flex-wrap gap-3 align-items-center mb-4">
        <!-- View Toggle (Tabs) -->
        <div class="nav nav-pills bg-white p-1 rounded shadow-sm border"
            style="background: #fff; border: 1px solid #e2e8f0 !important;">
            <button wire:click="setViewMode('list')"
                class="nav-link py-1 px-3 {{ $viewMode === 'list' ? 'active' : '' }}"
                style="font-size: 0.75rem; font-weight: 600; {{ $viewMode === 'list' ? 'background: #0f172a;' : 'color: #64748b;' }}">
                <i class="bi bi-list-task me-1"></i> List View
            </button>
            <button wire:click="setViewMode('kanban')"
                class="nav-link py-1 px-3 {{ $viewMode === 'kanban' ? 'active' : '' }}"
                style="font-size: 0.75rem; font-weight: 600; {{ $viewMode === 'kanban' ? 'background: #0f172a;' : 'color: #64748b;' }}">
                <i class="bi bi-kanban me-1"></i> Kanban Board
            </button>
        </div>

        @if ($viewMode === 'list')
            <div class="input-group input-group-sm" style="width: 240px;">
                <span class="input-group-text bg-white border-end-0 text-muted shadow-sm"
                    style="border: 1px solid #e2e8f0;"><i class="bi bi-search"></i></span>
                <input wire:model.live.debounce.500ms="search" type="text"
                    class="form-control border-start-0 shadow-sm" style="border: 1px solid #e2e8f0;"
                    placeholder="Search my tasks...">
            </div>
            <select wire:model.live="status" class="form-select form-select-sm shadow-sm"
                style="width: 140px; border: 1px solid #e2e8f0;">
                <option value="">All Status</option>
                @foreach (\App\Models\TaskStatus::all() as $s)
                    <option>{{ $s->name }}</option>
                @endforeach
            </select>
            <select wire:model.live="priority" class="form-select form-select-sm shadow-sm"
                style="width: 140px; border: 1px solid #e2e8f0;">
                <option value="">All Priorities</option>
                <option>Urgent</option>
                <option>High</option>
                <option>Medium</option>
                <option>Low</option>
            </select>

            <div class="ms-auto" wire:loading.remove wire:target="search, status, priority, setViewMode">
                <span class="text-muted" style="font-size: 0.75rem;">Showing matches</span>
            </div>
        @endif

        <div class="ms-auto" wire:loading wire:target="search, status, priority, setViewMode">
            <span class="spinner-border spinner-border-sm text-primary" role="status"
                style="width: 0.8rem; height: 0.8rem;"></span>
        </div>
    </div>

    @if ($viewMode === 'list')
        <!-- Reusable Task List Component -->
        <x-task-list :tasks="$tasks" scope="my" />
    @else
        <!-- Kanban Layout (Customized for Personal Tasks) -->
        <div class="kanban-container pb-4" x-data="{
            initSortable() {
                const columns = this.$el.querySelectorAll('.kanban-column-content');
                columns.forEach(column => {
                    if (column.sortable) {
                        column.sortable.destroy();
                    }
                    column.sortable = new Sortable(column, {
                        group: 'my-tasks',
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
            <div class="kanban-wrapper d-flex overflow-auto"
                style="min-height: calc(100vh - 300px); align-items: flex-start;">
                @foreach ($statuses as $status)
                    <div class="kanban-column px-3 border-end" wire:key="status-{{ $status->id }}"
                        style="min-width: 200px; flex: 1; max-width: 400px; border-color: #f1f5f9 !important;">
                        <div class="d-flex align-items-center mb-3 px-1 justify-content-between">
                            <div class="d-flex align-items-center gap-2">
                                <span class="fw-bold text-uppercase"
                                    style="font-size: 0.75rem; color: #5e6c84; letter-spacing: 0.02em;">{{ $status->name }}</span>
                                <span class="text-muted fw-semibold"
                                    style="font-size: 0.75rem; background: #ebecf0; padding: 2px 8px; border-radius: 10px;">{{ $status->tasks->count() }}</span>
                            </div>
                            <button class="btn btn-sm text-muted p-0 border-0" style="font-size: 1rem;"><i
                                    class="bi bi-three-dots"></i></button>
                        </div>

                        <div class="kanban-column-content d-flex flex-column gap-3" data-status-id="{{ $status->id }}"
                            style="min-height: 150px; padding-bottom: 20px;">
                            @foreach ($status->tasks as $task)
                                <div class="card kanban-card border-0 shadow-sm" data-id="{{ $task->id }}"
                                    wire:key="task-{{ $task->id }}"
                                    style="cursor: grab; border-radius: 4px; background: #fff; transition: all 0.2s ease;">
                                    <div class="card-body p-3">
                                        <div class="mb-2">
                                            <h6 class="mb-1 fw-semibold text-wrap"
                                                style="font-size: 0.85rem; color: #172b4d; line-height: 1.4;">
                                                {{ $task->title }}</h6>
                                            @if ($task->description)
                                                <p class="text-muted mb-0 text-truncate"
                                                    style="font-size: 0.75rem; color: #5e6c84 !important;">
                                                    {{ $task->description }}</p>
                                            @endif
                                        </div>

                                        <div class="d-flex justify-content-between align-items-center mt-3">
                                            <div class="d-flex align-items-center gap-2">
                                                <!-- Task Type & Key -->
                                                <div class="d-flex align-items-center text-muted" title="Task Key">
                                                    <i class="bi bi-check2-square text-primary me-1"
                                                        style="font-size: 0.85rem;"></i>
                                                    <span
                                                        style="font-size: 0.7rem; font-weight: 600; color: #6b778c;">TF-{{ $task->id }}</span>
                                                </div>
                                            </div>

                                            <div class="d-flex align-items-center gap-2">
                                                <!-- Priority Icon -->
                                                @php
                                                    $pData = match ($task->priority) {
                                                        'Urgent' => [
                                                            'color' => '#ef4444',
                                                            'icon' => 'bi-chevron-double-up',
                                                        ],
                                                        'High' => ['color' => '#f59e0b', 'icon' => 'bi-chevron-up'],
                                                        'Medium' => ['color' => '#3b82f6', 'icon' => 'bi-dash-lg'],
                                                        default => ['color' => '#94a3b8', 'icon' => 'bi-chevron-down'],
                                                    };
                                                @endphp
                                                <i class="bi {{ $pData['icon'] }} fw-bold"
                                                    style="font-size: 0.9rem; color: {{ $pData['color'] }};"
                                                    title="{{ $task->priority }} Priority"></i>

                                                <!-- Assignee -->
                                                <div title="Assigned to {{ $task->assignee->name ?? 'Unassigned' }}">
                                                    <x-user-avatar :user="$task->assignee" size="24px" fontsize="0.6rem" />
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

        <style>
            .kanban-wrapper::-webkit-scrollbar {
                height: 8px;
            }

            .kanban-wrapper::-webkit-scrollbar-track {
                background: #f1f5f9;
            }

            .kanban-wrapper::-webkit-scrollbar-thumb {
                background: #cbd5e1;
                border-radius: 4px;
            }

            .kanban-ghost {
                opacity: 0.5;
                background: #ebecf0 !important;
                border: 2px dashed #42526e !important;
                box-shadow: none !important;
            }

            .kanban-card {
                border: 1px solid #dfe1e6 !important;
                box-shadow: 0 1px 2px 0 rgba(9, 30, 66, 0.25) !important;
            }

            .kanban-card:hover {
                background-color: #f4f5f7 !important;
                border-color: #dfe1e6 !important;
            }

            .kanban-column {
                background-color: #f4f5f7;
                border-radius: 6px;
                margin-right: 12px;
                padding: 12px 8px !important;
                display: flex;
                flex-direction: column;
                height: 100%;
                border: none !important;
            }

            .kanban-column-content {
                flex-grow: 1;
            }

            .kanban-wrapper {
                padding: 10px 0;
                display: flex;
                align-items: flex-start;
            }
        </style>
    @endif
</div>
