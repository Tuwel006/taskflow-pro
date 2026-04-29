<div class="board-root" style="padding: 0 0.25rem;">

    {{-- ── Page Header ── --}}
    <x-page-header title="Task Board" subtitle="Manage and track all tasks across stages" :breadcrumbItems="[['label' => 'Tasks']]">
        <x-slot name="actions">
            <a href="/tasks/create/team/{{ $selectedTeam }}" wire:navigate
                class="btn btn-primary d-flex align-items-center gap-2"
                style="font-size:0.8125rem;font-weight:600;border-radius:6px;background:#4f46e5;border:none;padding:0.45rem 1rem;box-shadow:0 2px 6px rgba(79,70,229,.35);">
                <i class="bi bi-plus-lg"></i> Create Task
            </a>
        </x-slot>
    </x-page-header>

    {{-- ── Top bar: Team selector + View toggle + Filters ── --}}
    <div class="d-flex flex-wrap align-items-center gap-2 mb-3"
        style="background:#fff;border:1px solid #e8ecf0;border-radius:10px;padding:0.6rem 1rem;">

        {{-- Team Select --}}
        <div class="d-flex align-items-center gap-2 me-1">
            <i class="bi bi-people-fill text-muted" style="font-size:0.85rem;"></i>
            <select wire:model.live="selectedTeam" class="form-select form-select-sm"
                style="min-width:180px;font-size:0.8125rem;font-weight:600;border:1.5px solid #e2e8f0;color:#0f172a;background:#f8fafc;border-radius:6px;">
                @foreach ($teams as $team)
                    <option value="{{ $team->id }}" @selected($selectedTeam == $team->id)>
                        {{ $team->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="vr mx-1" style="opacity:.3;"></div>

        {{-- View mode tabs --}}
        <div class="d-flex gap-1 p-1 rounded" style="background:#f1f5f9;">
            <button wire:click="setViewMode('kanban')"
                class="btn btn-sm {{ $viewMode === 'kanban' ? 'btn-dark shadow-sm' : 'btn-link text-muted' }}"
                style="font-size:0.75rem;font-weight:600;padding:0.3rem 0.75rem;border-radius:5px;text-decoration:none;">
                <i class="bi bi-kanban me-1"></i>Board
            </button>
            <button wire:click="setViewMode('list')"
                class="btn btn-sm {{ $viewMode === 'list' ? 'btn-dark shadow-sm' : 'btn-link text-muted' }}"
                style="font-size:0.75rem;font-weight:600;padding:0.3rem 0.75rem;border-radius:5px;text-decoration:none;">
                <i class="bi bi-list-task me-1"></i>List
            </button>
        </div>

        <div class="vr mx-1" style="opacity:.3;"></div>

        {{-- Search --}}
        <div class="input-group input-group-sm" style="max-width:210px;">
            <span class="input-group-text bg-white border-end-0 text-muted"
                style="border:1px solid #e2e8f0;font-size:0.8rem;"><i class="bi bi-search"></i></span>
            <input wire:model.live.debounce.400ms="search" type="text" class="form-control border-start-0"
                style="border:1px solid #e2e8f0;font-size:0.8rem;" placeholder="Search tasks…">
        </div>

        @if ($viewMode === 'list')
            <select wire:model.live="status" class="form-select form-select-sm"
                style="max-width:120px;font-size:0.8rem;border:1px solid #e2e8f0;">
                <option value="">All Status</option>
                @foreach (\App\Models\TaskStatus::all() as $s)
                    <option>{{ $s->name }}</option>
                @endforeach
            </select>
            <select wire:model.live="priority" class="form-select form-select-sm"
                style="max-width:110px;font-size:0.8rem;border:1px solid #e2e8f0;">
                <option value="">Priority</option>
                <option>Urgent</option>
                <option>High</option>
                <option>Medium</option>
                <option>Low</option>
            </select>
        @endif

        {{-- Loading spinner --}}
        <div wire:loading wire:target="search,status,priority,selectedTeam,setViewMode" class="ms-auto">
            <span class="spinner-border spinner-border-sm text-primary" style="width:.8rem;height:.8rem;"></span>
        </div>
    </div>

    {{-- ═══════════════════════════════ LIST VIEW ═══════════════════════════════ --}}
    @if ($viewMode === 'list')
        <div class="card border-0 shadow-sm" style="border-radius:12px;overflow:hidden;">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0" style="font-size:0.8125rem;">
                    <thead>
                        <tr style="background:linear-gradient(135deg,#1e293b 0%,#334155 100%);color:#fff;">
                            <th
                                style="padding:0.85rem 1rem;font-size:0.7rem;font-weight:700;letter-spacing:.06em;text-transform:uppercase;white-space:nowrap;border:none;">
                                <i class="bi bi-hash me-1 opacity-75"></i>ID
                            </th>
                            <th
                                style="padding:0.85rem 1rem;font-size:0.7rem;font-weight:700;letter-spacing:.06em;text-transform:uppercase;white-space:nowrap;border:none;">
                                <i class="bi bi-card-text me-1 opacity-75"></i>Task
                            </th>
                            <th
                                style="padding:0.85rem 1rem;font-size:0.7rem;font-weight:700;letter-spacing:.06em;text-transform:uppercase;white-space:nowrap;border:none;">
                                <i class="bi bi-tag me-1 opacity-75"></i>Type
                            </th>
                            <th
                                style="padding:0.85rem 1rem;font-size:0.7rem;font-weight:700;letter-spacing:.06em;text-transform:uppercase;white-space:nowrap;border:none;">
                                <i class="bi bi-flag me-1 opacity-75"></i>Priority
                            </th>
                            <th
                                style="padding:0.85rem 1rem;font-size:0.7rem;font-weight:700;letter-spacing:.06em;text-transform:uppercase;white-space:nowrap;border:none;">
                                <i class="bi bi-circle-half me-1 opacity-75"></i>Status
                            </th>
                            <th
                                style="padding:0.85rem 1rem;font-size:0.7rem;font-weight:700;letter-spacing:.06em;text-transform:uppercase;white-space:nowrap;border:none;">
                                <i class="bi bi-person me-1 opacity-75"></i>Reporter
                            </th>
                            <th
                                style="padding:0.85rem 1rem;font-size:0.7rem;font-weight:700;letter-spacing:.06em;text-transform:uppercase;white-space:nowrap;border:none;">
                                <i class="bi bi-person-check me-1 opacity-75"></i>Assignee
                            </th>
                            <th
                                style="padding:0.85rem 1rem;font-size:0.7rem;font-weight:700;letter-spacing:.06em;text-transform:uppercase;white-space:nowrap;border:none;">
                                <i class="bi bi-people me-1 opacity-75"></i>Team
                            </th>
                            <th
                                style="padding:0.85rem 1rem;font-size:0.7rem;font-weight:700;letter-spacing:.06em;text-transform:uppercase;white-space:nowrap;border:none;">
                                <i class="bi bi-calendar3 me-1 opacity-75"></i>Due Date
                            </th>
                            <th
                                style="padding:0.85rem 1rem;font-size:0.7rem;font-weight:700;letter-spacing:.06em;text-transform:uppercase;white-space:nowrap;border:none;">
                                <i class="bi bi-clock-history me-1 opacity-75"></i>Created
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($tasks as $task)
                            @php
                                $statusColor = $task->statusRecord->color ?? '#64748b';
                                $priorityMap = [
                                    'Urgent' => [
                                        'color' => '#dc2626',
                                        'bg' => '#FEF2F2',
                                        'icon' => 'bi-arrow-up-circle-fill',
                                    ],
                                    'High' => ['color' => '#ea580c', 'bg' => '#FFF7ED', 'icon' => 'bi-arrow-up-circle'],
                                    'Medium' => ['color' => '#ca8a04', 'bg' => '#FEFCE8', 'icon' => 'bi-dash-circle'],
                                    'Low' => [
                                        'color' => '#16a34a',
                                        'bg' => '#F0FDF4',
                                        'icon' => 'bi-arrow-down-circle',
                                    ],
                                ];
                                $pInfo = $priorityMap[$task->priority] ?? [
                                    'color' => '#94a3b8',
                                    'bg' => '#f8fafc',
                                    'icon' => 'bi-dash-circle',
                                ];
                                $isOverdue = $task->due_date && \Carbon\Carbon::parse($task->due_date)->isPast();
                            @endphp
                            <tr wire:key="list-task-{{ $task->id }}"
                                style="border-bottom:1px solid #f1f5f9;transition:background .15s;"
                                class="task-list-row">
                                {{-- ID --}}
                                <td style="padding:0.75rem 1rem;color:#64748b;font-weight:700;font-size:0.75rem;">
                                    #{{ $task->id }}
                                </td>
                                {{-- Task Title + description snippet --}}
                                <td style="padding:0.75rem 1rem;max-width:260px;">
                                    <a href="/tasks/{{ $task->id }}/edit"
                                        class="text-dark text-decoration-none fw-semibold d-block"
                                        style="font-size:0.8125rem;line-height:1.3;">
                                        {{ $task->title }}
                                    </a>
                                    @if ($task->description)
                                        <div class="text-truncate text-muted mt-1"
                                            style="font-size:0.7rem;max-width:240px;">
                                            {{ $task->description }}
                                        </div>
                                    @endif
                                </td>
                                {{-- Type --}}
                                <td style="padding:0.75rem 1rem;white-space:nowrap;">
                                    @if ($task->type)
                                        <span class="d-inline-flex align-items-center gap-1 badge"
                                            style="font-size:0.68rem;background:#ede9fe;color:#7c3aed;padding:0.3rem 0.6rem;border-radius:5px;">
                                            <i class="{{ $task->type->icon ?? 'bi bi-bookmark' }}"
                                                style="font-size:0.65rem;"></i>
                                            {{ $task->type->name }}
                                        </span>
                                    @else
                                        <span class="text-muted" style="font-size:0.75rem;">—</span>
                                    @endif
                                </td>
                                {{-- Priority --}}
                                <td style="padding:0.75rem 1rem;white-space:nowrap;">
                                    <span class="d-inline-flex align-items-center gap-1"
                                        style="font-size:0.75rem;font-weight:600;color:{{ $pInfo['color'] }};background:{{ $pInfo['bg'] }};padding:0.25rem 0.6rem;border-radius:50px;">
                                        <i class="bi {{ $pInfo['icon'] }}" style="font-size:0.65rem;"></i>
                                        {{ $task->priority ?? '—' }}
                                    </span>
                                </td>
                                {{-- Status --}}
                                <td style="padding:0.75rem 1rem;white-space:nowrap;">
                                    <span class="d-inline-flex align-items-center gap-1 badge"
                                        style="font-size:0.68rem;background:{{ $statusColor }}18;color:{{ $statusColor }};border:1px solid {{ $statusColor }}44;padding:0.28rem 0.65rem;border-radius:50px;">
                                        <i class="bi bi-circle-fill" style="font-size:0.35rem;"></i>
                                        {{ $task->statusRecord->name ?? '—' }}
                                    </span>
                                </td>
                                {{-- Reporter --}}
                                <td style="padding:0.75rem 1rem;white-space:nowrap;">
                                    @if ($task->creator)
                                        <div class="d-flex align-items-center gap-2">
                                            <div class="avatar-circle"
                                                style="width:26px;height:26px;border-radius:50%;background:linear-gradient(135deg,#6366f1,#8b5cf6);color:#fff;font-size:0.6rem;font-weight:700;display:flex;align-items:center;justify-content:center;flex-shrink:0;">
                                                {{ strtoupper(substr($task->creator->name, 0, 2)) }}
                                            </div>
                                            <span
                                                style="font-size:0.8rem;color:#334155;">{{ $task->creator->name }}</span>
                                        </div>
                                    @else
                                        <span class="text-muted" style="font-size:0.75rem;">—</span>
                                    @endif
                                </td>
                                {{-- Assignee --}}
                                <td style="padding:0.75rem 1rem;white-space:nowrap;">
                                    @if ($task->assignee)
                                        <div class="d-flex align-items-center gap-2">
                                            <div class="avatar-circle"
                                                style="width:26px;height:26px;border-radius:50%;background:linear-gradient(135deg,#0ea5e9,#38bdf8);color:#fff;font-size:0.6rem;font-weight:700;display:flex;align-items:center;justify-content:center;flex-shrink:0;">
                                                {{ strtoupper(substr($task->assignee->name, 0, 2)) }}
                                            </div>
                                            <span
                                                style="font-size:0.8rem;color:#334155;">{{ $task->assignee->name }}</span>
                                        </div>
                                    @else
                                        <span class="text-muted d-flex align-items-center gap-1"
                                            style="font-size:0.75rem;">
                                            <i class="bi bi-person-dash"></i> Unassigned
                                        </span>
                                    @endif
                                </td>
                                {{-- Team --}}
                                <td style="padding:0.75rem 1rem;white-space:nowrap;">
                                    @if ($task->team)
                                        <span class="badge d-inline-flex align-items-center gap-1"
                                            style="font-size:0.68rem;background:#e0f2fe;color:#0369a1;padding:0.28rem 0.65rem;border-radius:5px;">
                                            <i class="bi bi-people-fill" style="font-size:0.6rem;"></i>
                                            {{ $task->team->name }}
                                            @if ($task->team->prefix)
                                                <span style="opacity:.7;">[{{ $task->team->prefix }}]</span>
                                            @endif
                                        </span>
                                    @else
                                        <span class="text-muted" style="font-size:0.75rem;">—</span>
                                    @endif
                                </td>
                                {{-- Due Date --}}
                                <td style="padding:0.75rem 1rem;white-space:nowrap;">
                                    @if ($task->due_date)
                                        <span class="d-inline-flex align-items-center gap-1"
                                            style="font-size:0.75rem;font-weight:600;color:{{ $isOverdue ? '#dc2626' : '#475569' }};">
                                            <i class="bi {{ $isOverdue ? 'bi-exclamation-circle-fill' : 'bi-calendar-event' }}"
                                                style="font-size:0.7rem;"></i>
                                            {{ \Carbon\Carbon::parse($task->due_date)->format('M d, Y') }}
                                        </span>
                                    @else
                                        <span class="text-muted" style="font-size:0.75rem;">—</span>
                                    @endif
                                </td>
                                {{-- Created --}}
                                <td style="padding:0.75rem 1rem;white-space:nowrap;color:#94a3b8;font-size:0.72rem;">
                                    {{ $task->created_at->format('M d, Y') }}
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="10" class="text-center py-5">
                                    <i class="bi bi-clipboard-x d-block mb-2"
                                        style="font-size:2.5rem;color:#cbd5e1;"></i>
                                    <span class="text-muted" style="font-size:0.875rem;">No tasks found</span>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            @if ($tasks->hasPages())
                <div class="px-3 py-2 border-top d-flex justify-content-end" style="background:#fafbfc;">
                    {{ $tasks->links() }}
                </div>
            @endif
        </div>

        {{-- ═══════════════════════════════ KANBAN VIEW ═══════════════════════════════ --}}
    @else
        <div class="kanban-root" x-data="{
            initSortable() {
                const columns = document.querySelectorAll('.kanban-drop-zone');
                columns.forEach(col => {
                    if (col._sortableInstance) col._sortableInstance.destroy();
                    col._sortableInstance = new Sortable(col, {
                        group: 'kb-tasks',
                        animation: 200,
                        ghostClass: 'kb-ghost',
                        dragClass: 'kb-dragging',
                        forceFallback: false,
                        onEnd: (evt) => {
                            const taskId = evt.item.dataset.id;
                            const newStageId = evt.to.dataset.stageId;
                            if (evt.from !== evt.to) {
                                $wire.updateStatus(taskId, newStageId);
                            }
                        }
                    });
                });
            }
        }" x-init="initSortable()"
            @taskUpdated.window="$nextTick(() => initSortable())">

            <div class="kanban-scroll-wrapper d-flex gap-2 pb-4"
                style="overflow-x:auto;align-items:flex-start;padding:0.25rem 0 1rem;min-height:calc(100vh - 260px);">

                @foreach ($stages as $stage)
                    @php
                        $stName = $stage->status->name ?? 'Stage ' . $stage->position;
                        $stColor = $stage->status->color ?? '#64748b';
                        $taskCount = $stage->tasks->count();
                    @endphp

                    <div class="kanban-column" wire:key="stage-{{ $stage->id }}"
                        style="flex: 1; min-width: 272px;">

                        {{-- ── Column Header ── --}}
                        <div class="kb-col-header"
                            style="background:#fff;border-radius:8px 8px 0 0;padding:0.6rem 0.75rem 0.55rem;border:1px solid #e8ecf0;border-bottom:none;">
                            <div class="d-flex align-items-center justify-content-between">
                                <div class="d-flex align-items-center gap-2">
                                    {{-- Color dot --}}
                                    <span
                                        style="width:10px;height:10px;border-radius:50%;background:{{ $stColor }};display:inline-block;flex-shrink:0;"></span>
                                    {{-- Stage name (prominent) --}}
                                    <span class="fw-bold text-dark"
                                        style="font-size:0.875rem;letter-spacing:0.01em;">{{ $stName }}</span>
                                </div>
                                <span class="badge"
                                    style="font-size:0.65rem;font-weight:700;background:{{ $stColor }}20;color:{{ $stColor }};padding:0.2rem 0.55rem;border-radius:50px;border:1px solid {{ $stColor }}40;">
                                    {{ $taskCount }}
                                </span>
                            </div>
                            {{-- Progress bar --}}
                            <div class="mt-2"
                                style="height:3px;background:#f1f5f9;border-radius:2px;overflow:hidden;">
                                @if ($taskCount > 0)
                                    <div
                                        style="height:100%;width:100%;background:{{ $stColor }};opacity:.5;border-radius:2px;">
                                    </div>
                                @endif
                            </div>
                        </div>

                        {{-- ── Drop zone ── --}}
                        <div class="kanban-drop-zone" data-stage-id="{{ $stage->id }}"
                            style="background:#f8fafc;border:1px solid #e8ecf0;border-top:none;border-radius:0 0 8px 8px;min-height:360px;padding:0.5rem 0.5rem 0.75rem;">

                            @forelse ($stage->tasks as $task)
                                @php
                                    $pMap = [
                                        'Urgent' => [
                                            'c' => '#dc2626',
                                            'b' => '#FEF2F2',
                                            'i' => 'bi-arrow-up-circle-fill',
                                        ],
                                        'High' => ['c' => '#ea580c', 'b' => '#FFF7ED', 'i' => 'bi-arrow-up-circle'],
                                        'Medium' => ['c' => '#ca8a04', 'b' => '#FEFCE8', 'i' => 'bi-dash-circle'],
                                        'Low' => ['c' => '#16a34a', 'b' => '#F0FDF4', 'i' => 'bi-arrow-down-circle'],
                                    ];
                                    $pI = $pMap[$task->priority] ?? [
                                        'c' => '#94a3b8',
                                        'b' => '#f8fafc',
                                        'i' => 'bi-dash-circle',
                                    ];
                                    $sColor = $task->statusRecord->color ?? $stColor;
                                    $isOverdue = $task->due_date && \Carbon\Carbon::parse($task->due_date)->isPast();
                                    $teamPrefix = $task->team->prefix ?? 'TF';
                                    $taskKey = strtoupper($teamPrefix) . '-' . $task->id;
                                @endphp

                                <div class="kb-card bg-white rounded shadow-sm"
                                    wire:key="kb-task-{{ $task->id }}" data-id="{{ $task->id }}"
                                    style="margin-bottom:0.55rem;border:1px solid #e8ecf0;border-radius:8px;cursor:grab;transition:box-shadow .2s,transform .15s;position:relative;">

                                    {{-- Card top band (stage color accent) --}}
                                    <div
                                        style="height:3px;background:{{ $stColor }};border-radius:8px 8px 0 0;opacity:.7;">
                                    </div>

                                    <div style="padding:0.7rem 0.8rem 0.6rem;">

                                        {{-- Row 1: task key + type badge + priority --}}
                                        <div class="d-flex align-items-center gap-1 mb-1 justify-content-between">
                                            <div class="d-flex align-items-center gap-1">
                                                <span
                                                    style="font-size:0.65rem;color:#94a3b8;font-weight:700;letter-spacing:.03em;">{{ $taskKey }}</span>
                                                @if ($task->type)
                                                    <span
                                                        style="font-size:0.6rem;background:#ede9fe;color:#7c3aed;padding:0.1rem 0.4rem;border-radius:4px;font-weight:600;">
                                                        <i class="{{ $task->type->icon ?? 'bi bi-bookmark' }}"
                                                            style="font-size:0.55rem;"></i>
                                                        {{ $task->type->name }}
                                                    </span>
                                                @endif
                                            </div>
                                            <span class="d-inline-flex align-items-center gap-1"
                                                style="font-size:0.62rem;font-weight:700;color:{{ $pI['c'] }};background:{{ $pI['b'] }};padding:0.12rem 0.45rem;border-radius:50px;">
                                                <i class="bi {{ $pI['i'] }}" style="font-size:0.6rem;"></i>
                                                {{ $task->priority }}
                                            </span>
                                        </div>

                                        {{-- Row 2: Title --}}
                                        <div class="fw-semibold text-dark mb-2"
                                            style="font-size:0.8125rem;line-height:1.35;word-break:break-word;">
                                            {{ $task->title }}
                                        </div>

                                        {{-- Row 3: Description snippet --}}
                                        @if ($task->description)
                                            <div class="text-muted mb-2"
                                                style="font-size:0.72rem;line-height:1.4;display:-webkit-box;-webkit-line-clamp:2;-webkit-box-orient:vertical;overflow:hidden;">
                                                {{ $task->description }}
                                            </div>
                                        @endif

                                        {{-- Divider --}}
                                        <div style="height:1px;background:#f1f5f9;margin:0.4rem 0;"></div>

                                        {{-- Row 4: Status chip + Due date --}}
                                        <div class="d-flex align-items-center justify-content-between mb-2">
                                            <span class="d-inline-flex align-items-center gap-1"
                                                style="font-size:0.62rem;font-weight:600;color:{{ $sColor }};background:{{ $sColor }}18;border:1px solid {{ $sColor }}35;padding:0.14rem 0.5rem;border-radius:50px;">
                                                <i class="bi bi-circle-fill" style="font-size:0.3rem;"></i>
                                                {{ $stName }}
                                            </span>
                                            @if ($task->due_date)
                                                <span class="d-inline-flex align-items-center gap-1"
                                                    style="font-size:0.65rem;font-weight:600;color:{{ $isOverdue ? '#dc2626' : '#64748b' }};">
                                                    <i class="bi {{ $isOverdue ? 'bi-alarm-fill' : 'bi-calendar2' }}"
                                                        style="font-size:0.6rem;"></i>
                                                    {{ \Carbon\Carbon::parse($task->due_date)->format('M d') }}
                                                </span>
                                            @endif
                                        </div>

                                        {{-- Divider --}}
                                        <div style="height:1px;background:#f1f5f9;margin:0.4rem 0;"></div>

                                        {{-- Row 5: Assignee --}}
                                        <div class="d-flex align-items-center">
                                            {{-- Assignee --}}
                                            <div class="d-flex align-items-center gap-1"
                                                title="Assignee: {{ $task->assignee->name ?? 'Unassigned' }}">
                                                <span
                                                    style="font-size:0.6rem;color:#94a3b8;letter-spacing:.03em;text-transform:uppercase;font-weight:600;">Asgn</span>
                                                @if ($task->assignee)
                                                    <div
                                                        style="width:22px;height:22px;border-radius:50%;background:linear-gradient(135deg,#0ea5e9,#38bdf8);color:#fff;font-size:0.55rem;font-weight:700;display:flex;align-items:center;justify-content:center;flex-shrink:0;border:1.5px solid #fff;box-shadow:0 0 0 1px #0ea5e940;">
                                                        {{ strtoupper(substr($task->assignee->name, 0, 2)) }}
                                                    </div>
                                                    <span
                                                        style="font-size:0.68rem;color:#475569;max-width:120px;overflow:hidden;white-space:nowrap;text-overflow:ellipsis;">
                                                        {{ $task->assignee->name }}
                                                    </span>
                                                @else
                                                    <span style="font-size:0.68rem;color:#94a3b8;">Unassigned</span>
                                                @endif
                                            </div>
                                        </div>

                                        {{-- Row 6: Team badge --}}
                                        @if ($task->team)
                                            <div class="mt-2 pt-1" style="border-top:1px solid #f1f5f9;">
                                                <span class="d-inline-flex align-items-center gap-1"
                                                    style="font-size:0.62rem;font-weight:600;background:#dbeafe;color:#1d4ed8;padding:0.15rem 0.5rem;border-radius:4px;">
                                                    <i class="bi bi-people-fill" style="font-size:0.55rem;"></i>
                                                    {{ $task->team->name }}
                                                </span>
                                            </div>
                                        @endif

                                    </div>{{-- end card body --}}
                                </div>{{-- end .kb-card --}}

                            @empty
                                <div class="text-center py-5" style="color:#cbd5e1;">
                                    <i class="bi bi-inbox d-block mb-2" style="font-size:1.75rem;"></i>
                                    <div style="font-size:0.78rem;">No tasks in <strong>{{ $stName }}</strong>
                                    </div>
                                </div>
                            @endforelse

                        </div>{{-- end drop-zone --}}
                    </div>{{-- end column --}}
                @endforeach

            </div>{{-- end scroll wrapper --}}
        </div>
    @endif

    <style>
        /* ── Kanban card hover & drag styles ── */
        .kb-card:hover {
            box-shadow: 0 4px 18px rgba(79, 70, 229, .13) !important;
            transform: translateY(-2px);
            border-color: #c7d2fe !important;
        }

        .kb-ghost {
            opacity: .4;
            background: #e0e7ff !important;
            border: 2px dashed #6366f1 !important;
        }

        .kb-dragging {
            box-shadow: 0 8px 30px rgba(79, 70, 229, .25) !important;
            transform: rotate(1.5deg) scale(1.03) !important;
            cursor: grabbing !important;
            z-index: 9999;
        }

        /* ── List row hover ── */
        .task-list-row:hover td {
            background: #f5f7ff;
        }

        /* ── Kanban scrollbar ── */
        .kanban-scroll-wrapper::-webkit-scrollbar {
            height: 6px;
        }

        .kanban-scroll-wrapper::-webkit-scrollbar-track {
            background: #f1f5f9;
            border-radius: 4px;
        }

        .kanban-scroll-wrapper::-webkit-scrollbar-thumb {
            background: #cbd5e1;
            border-radius: 4px;
        }

        .kanban-scroll-wrapper::-webkit-scrollbar-thumb:hover {
            background: #94a3b8;
        }
    </style>

</div>
