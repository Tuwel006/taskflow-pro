<div class="task-list-root">
    {{-- ── Header ── --}}
    <x-page-header title="Project Tasks" subtitle="Track progress and upcoming milestones" :breadcrumbItems="[['label' => 'Tasks']]">
    </x-page-header>

    {{-- ── Filters ── --}}
    <div class="row g-3 mb-4">
        <div class="col-md-4">
            <div class="card border-0 shadow-sm" style="border-radius: 10px;">
                <div class="card-body p-2 d-flex align-items-center gap-2">
                    <span class="ps-2 text-indigo-500"><i class="bi bi-folder2-open"></i></span>
                    <select wire:model.live="selectedProject" class="form-select border-0 shadow-none bg-transparent fw-bold" style="font-size: 0.85rem;">
                        <option value="">All Assigned Projects</option>
                        @foreach ($projects as $project)
                            <option value="{{ $project->id }}">{{ $project->name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
        </div>
        <div class="col-md-5">
            <div class="card border-0 shadow-sm" style="border-radius: 10px;">
                <div class="card-body p-2 d-flex align-items-center gap-2">
                    <span class="ps-2 text-slate-400"><i class="bi bi-search"></i></span>
                    <input wire:model.live.debounce.400ms="search" type="text" class="form-control border-0 shadow-none bg-transparent" placeholder="Search by task title or description..." style="font-size: 0.85rem;">
                </div>
            </div>
        </div>
        <div class="col-md-3 d-flex align-items-center justify-content-end">
            <div wire:loading class="spinner-border spinner-border-sm text-indigo-500" role="status"></div>
        </div>
    </div>

    {{-- ── Beautiful Task List ── --}}
    <div class="card border-0 shadow-sm overflow-hidden" style="border-radius: 12px;">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead>
                    <tr class="bg-slate-50 border-bottom">
                        <th class="px-4 py-3 text-slate-500 x-small text-uppercase fw-bold" style="width: 80px;">Ref</th>
                        <th class="px-3 py-3 text-slate-500 x-small text-uppercase fw-bold">Task Details</th>
                        <th class="px-3 py-3 text-slate-500 x-small text-uppercase fw-bold text-center">Status</th>
                        <th class="px-3 py-3 text-slate-500 x-small text-uppercase fw-bold text-center">Priority</th>
                        <th class="px-3 py-3 text-slate-500 x-small text-uppercase fw-bold">Assignee</th>
                        <th class="px-4 py-3 text-slate-500 x-small text-uppercase fw-bold text-end">Due Date</th>
                    </tr>
                </thead>
                <tbody class="border-top-0">
                    @forelse ($tasks as $task)
                        @php
                            $statusColor = $task->statusRecord->color ?? '#64748b';
                            $isOverdue = $task->due_date && \Carbon\Carbon::parse($task->due_date)->isPast();
                            $priorityColor = match($task->priority) {
                                'Urgent' => '#ef4444',
                                'High' => '#f59e0b',
                                'Medium' => '#6366f1',
                                'Low' => '#10b981',
                                default => '#64748b'
                            };
                        @endphp
                        <tr class="task-row">
                            <td class="px-4 py-4">
                                <span class="text-slate-400 fw-bold" style="font-size: 0.75rem;">{{ $task->display_id }}</span>
                            </td>
                            <td class="px-3 py-4">
                                <div class="d-flex align-items-start gap-3">
                                    <div class="p-2 rounded-3 bg-indigo-50 text-indigo-600" style="font-size: 1.1rem;">
                                        {!! $task->type->icon ?? '<i class="bi bi-bookmark-check"></i>' !!}
                                    </div>
                                    <div>
                                        <div class="fw-bold text-slate-800 mb-1" style="font-size: 0.9rem;">{{ $task->title }}</div>
                                        <div class="text-muted text-truncate x-small" style="max-width: 350px;">{{ $task->description ?? 'No description provided.' }}</div>
                                        <div class="mt-2">
                                            <span class="badge bg-slate-100 text-slate-500 border fw-normal" style="font-size: 0.65rem;">
                                                <i class="bi bi-folder2 me-1"></i> {{ $task->project->name }}
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-3 py-4 text-center">
                                <span class="badge rounded-pill" 
                                    style="font-size:0.65rem; padding: 0.4rem 0.8rem; background:{{ $statusColor }}12; color:{{ $statusColor }}; border:1px solid {{ $statusColor }}33 !important; letter-spacing: 0.02em; font-weight: 700;">
                                    {{ strtoupper($task->statusRecord->name ?? '—') }}
                                </span>
                            </td>
                            <td class="px-3 py-4 text-center">
                                <div class="d-inline-flex align-items-center gap-2 px-2 py-1 rounded border bg-light">
                                    <span style="width: 6px; height: 6px; border-radius: 50%; background: {{ $priorityColor }};"></span>
                                    <span class="fw-bold text-slate-600" style="font-size: 0.7rem;">{{ $task->priority ?? 'Medium' }}</span>
                                </div>
                            </td>
                            <td class="px-3 py-4">
                                <div class="d-flex align-items-center gap-2">
                                    <x-user-avatar :user="$task->assignee" size="28px" />
                                    <div>
                                        <div class="fw-bold text-slate-700" style="font-size: 0.75rem;">{{ $task->assignee->name ?? 'Pending' }}</div>
                                        <div class="text-muted x-small">Assigned Lead</div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-4 py-4 text-end">
                                @if ($task->due_date)
                                    <div class="fw-bold {{ $isOverdue ? 'text-rose-500' : 'text-slate-700' }}" style="font-size: 0.8rem;">
                                        {{ \Carbon\Carbon::parse($task->due_date)->format('M d, Y') }}
                                    </div>
                                    <div class="x-small {{ $isOverdue ? 'text-rose-400' : 'text-muted' }}">
                                        {{ $isOverdue ? 'Overdue' : \Carbon\Carbon::parse($task->due_date)->diffForHumans() }}
                                    </div>
                                @else
                                    <span class="text-slate-300 small">—</span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center py-5">
                                <div class="mb-3 text-slate-200"><i class="bi bi-clipboard2-check" style="font-size: 3rem;"></i></div>
                                <h6 class="text-slate-500 fw-bold">No tasks found</h6>
                                <p class="text-muted small">All milestones are currently up to date.</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="px-4 py-3 bg-slate-50 border-top">
            {{ $tasks->links() }}
        </div>
    </div>

    <style>
        .text-slate-700 { color: #334155; }
        .text-slate-500 { color: #64748b; }
        .text-slate-400 { color: #94a3b8; }
        .text-slate-300 { color: #cbd5e1; }
        .text-slate-200 { color: #e2e8f0; }
        .bg-slate-50 { background-color: #f8fafc; }
        .bg-indigo-50 { background-color: #eef2ff; }
        .text-indigo-600 { color: #4f46e5; }
        .text-rose-500 { color: #f43f5e; }
        .text-rose-400 { color: #fb7185; }
        .x-small { font-size: 0.7rem; }
        .task-row { transition: all 0.2s; }
        .task-row:hover { background-color: #fcfdfe !important; }
        .task-row:hover td { color: #000; }
    </style>
</div>
