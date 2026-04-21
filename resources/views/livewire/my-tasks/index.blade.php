<div class="container-fluid py-2">
    <x-page-header 
        title="Personal Action Items" 
        subtitle="Tasks specifically assigned to your profile"
        :breadcrumbItems="[['label' => 'Tasks', 'url' => '/tasks'], ['label' => 'My Tasks']]"
    >
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
        <div class="nav nav-pills bg-white p-1 rounded shadow-sm border" style="background: #fff; border: 1px solid #e2e8f0 !important;">
            <button wire:click="setViewMode('list')" class="nav-link py-1 px-3 {{ $viewMode === 'list' ? 'active' : '' }}" style="font-size: 0.75rem; font-weight: 600; {{ $viewMode === 'list' ? 'background: #0f172a;' : 'color: #64748b;' }}">
                <i class="bi bi-list-task me-1"></i> List View
            </button>
            <button wire:click="setViewMode('kanban')" class="nav-link py-1 px-3 {{ $viewMode === 'kanban' ? 'active' : '' }}" style="font-size: 0.75rem; font-weight: 600; {{ $viewMode === 'kanban' ? 'background: #0f172a;' : 'color: #64748b;' }}">
                <i class="bi bi-kanban me-1"></i> Kanban Board
            </button>
        </div>

        @if($viewMode === 'list')
            <div class="input-group input-group-sm" style="width: 240px;">
                <span class="input-group-text bg-white border-end-0 text-muted shadow-sm" style="border: 1px solid #e2e8f0;"><i class="bi bi-search"></i></span>
                <input wire:model.live.debounce.500ms="search" type="text" class="form-control border-start-0 shadow-sm" style="border: 1px solid #e2e8f0;" placeholder="Search my tasks...">
            </div>
            <select wire:model.live="status" class="form-select form-select-sm shadow-sm" style="width: 140px; border: 1px solid #e2e8f0;">
                <option value="">All Status</option>
                @foreach(\App\Models\TaskStatus::all() as $s)
                    <option>{{ $s->name }}</option>
                @endforeach
            </select>
            <select wire:model.live="priority" class="form-select form-select-sm shadow-sm" style="width: 140px; border: 1px solid #e2e8f0;">
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
            <span class="spinner-border spinner-border-sm text-primary" role="status" style="width: 0.8rem; height: 0.8rem;"></span>
        </div>
    </div>

    @if($viewMode === 'list')
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
        }" x-init="initSortable()" @taskUpdated.window="initSortable()">
            <div class="kanban-wrapper d-flex overflow-auto" style="min-height: calc(100vh - 300px); align-items: flex-start;">
                @foreach($statuses as $status)
                    <div class="kanban-column px-3 border-end" wire:key="status-{{ $status->id }}" style="min-width: 200px; flex: 1; max-width: 400px; border-color: #f1f5f9 !important;">
                        <div class="d-flex align-items-center mb-3 px-1 gap-2">
                            <span class="fw-bold text-uppercase" style="font-size: 0.7rem; color: #64748b; letter-spacing: 0.05em;">{{ $status->name }}</span>
                            <span class="badge rounded-pill bg-light text-muted border fw-normal" style="font-size: 0.65rem;">{{ $status->tasks->count() }}</span>
                        </div>

                        <div class="kanban-column-content d-flex flex-column gap-2" data-status-id="{{ $status->id }}" style="min-height: 100px;">
                            @foreach($status->tasks as $task)
                                <div class="card border shadow-sm kanban-card" data-id="{{ $task->id }}" wire:key="task-{{ $task->id }}"
                                     style="cursor: grab; border-radius: 8px; background: #fff; border: 1px solid #e2e8f0 !important;">
                                    <div class="card-body p-2">
                                        <div class="d-flex justify-content-between align-items-center mb-1">
                                            @php
                                                $pColor = match($task->priority) {
                                                    'Urgent' => '#ef4444',
                                                    'High' => '#f59e0b',
                                                    'Medium' => '#3b82f6',
                                                    default => '#94a3b8'
                                                };
                                            @endphp
                                            <span style="font-size: 0.6rem; font-weight: 700; color: {{ $pColor }}; text-transform: uppercase;">{{ $task->priority }}</span>
                                            <x-user-avatar :user="$task->assignee" size="18px" fontsize="0.5rem" />
                                        </div>
                                        <h6 class="mb-1 fw-bold" style="font-size: 0.75rem; color: #1e293b;">{{ $task->title }}</h6>
                                        <p class="text-muted mb-0 text-truncate" style="font-size: 0.65rem;">{{ $task->description }}</p>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

        <style>
            .kanban-ghost { opacity: 0.4; background: #f8fafc !important; border: 2px dashed #0f172a !important; }
            .kanban-card:hover { border-color: #cbd5e1 !important; transform: translateY(-1px); }
        </style>
    @endif
</div>