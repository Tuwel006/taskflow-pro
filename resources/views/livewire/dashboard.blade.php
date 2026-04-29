<div class="container-fluid py-4 bg-slate-50 min-vh-100">
    {{-- Header: Professional & Clean --}}
    <div class="row align-items-center mb-4">
        <div class="col-md-8">
            <h4 class="fw-bold text-slate-900 mb-1">Project Command Center</h4>
            <div class="d-flex align-items-center gap-2">
                <span class="badge bg-indigo-100 text-indigo-700 border border-indigo-200 px-2 py-1" style="font-size: 0.65rem;">
                    <i class="bi bi-diagram-3 me-1"></i> {{ $selectedProject->name ?? 'All Projects' }}
                </span>
                <span class="text-muted small">Real-time performance analytics and team synchronization</span>
            </div>
        </div>
        <div class="col-md-4 text-md-end mt-3 mt-md-0">
            <div class="btn-group shadow-sm">
                <button class="btn btn-white border btn-sm fw-semibold px-3">
                    <i class="bi bi-cloud-download me-2"></i>Report
                </button>
                <a href="/tasks" wire:navigate class="btn btn-indigo btn-sm fw-semibold px-3">
                    <i class="bi bi-kanban me-2"></i>Board
                </a>
            </div>
        </div>
    </div>

    {{-- Metric Cards Grid: Top Row --}}
    <div class="row g-3 mb-4">
        <div class="col-xl-3 col-md-6">
            <div class="card border-0 shadow-sm h-100" style="border-radius: 10px;">
                <div class="card-body p-3">
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <div class="icon-shape bg-indigo-50 text-indigo-600 rounded-3 d-flex align-items-center justify-content-center" style="width: 38px; height: 38px;">
                            <i class="bi bi-briefcase fs-6"></i>
                        </div>
                        <span class="text-slate-400 fw-bold x-small">TOTAL</span>
                    </div>
                    <h4 class="fw-bold text-slate-900 mb-1">{{ number_format($totalTasks) }}</h4>
                    <div class="progress" style="height: 4px; border-radius: 10px; background: #f1f5f9;">
                        <div class="progress-bar bg-indigo-500" style="width: 100%"></div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6">
            <div class="card border-0 shadow-sm h-100" style="border-radius: 10px;">
                <div class="card-body p-3">
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <div class="icon-shape bg-amber-50 text-amber-600 rounded-3 d-flex align-items-center justify-content-center" style="width: 38px; height: 38px;">
                            <i class="bi bi-lightning-charge fs-6"></i>
                        </div>
                        <span class="text-slate-400 fw-bold x-small">ACTIVE</span>
                    </div>
                    <h4 class="fw-bold text-slate-900 mb-1">{{ number_format($inProgressCount) }}</h4>
                    <div class="progress" style="height: 4px; border-radius: 10px; background: #f1f5f9;">
                        @php $progPct = $totalTasks > 0 ? ($inProgressCount / $totalTasks) * 100 : 0; @endphp
                        <div class="progress-bar bg-amber-500" style="width: {{ $progPct }}%"></div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6">
            <div class="card border-0 shadow-sm h-100" style="border-radius: 10px;">
                <div class="card-body p-3">
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <div class="icon-shape bg-emerald-50 text-emerald-600 rounded-3 d-flex align-items-center justify-content-center" style="width: 38px; height: 38px;">
                            <i class="bi bi-check-circle fs-6"></i>
                        </div>
                        <span class="text-slate-400 fw-bold x-small">DONE</span>
                    </div>
                    <h4 class="fw-bold text-slate-900 mb-1">{{ number_format($completedCount) }}</h4>
                    <div class="progress" style="height: 4px; border-radius: 10px; background: #f1f5f9;">
                        @php $compPct = $totalTasks > 0 ? ($completedCount / $totalTasks) * 100 : 0; @endphp
                        <div class="progress-bar bg-emerald-500" style="width: {{ $compPct }}%"></div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6">
            <div class="card border-0 shadow-sm h-100" style="border-radius: 10px; background: #0f172a;">
                <div class="card-body p-3">
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <div class="icon-shape bg-white bg-opacity-10 text-white rounded-3 d-flex align-items-center justify-content-center" style="width: 38px; height: 38px;">
                            <i class="bi bi-exclamation-triangle fs-6"></i>
                        </div>
                        <span class="text-slate-400 fw-bold x-small">ALERT</span>
                    </div>
                    <h4 class="fw-bold text-white mb-1">{{ number_format($overdueTasks) }}</h4>
                    <div class="progress" style="height: 4px; border-radius: 10px; background: rgba(255,255,255,0.1);">
                        @php $overPct = $totalTasks > 0 ? ($overdueTasks / $totalTasks) * 100 : 0; @endphp
                        <div class="progress-bar bg-rose-500" style="width: {{ $overPct }}%"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Main Row: Balanced Activity & Progress --}}
    <div class="row g-4 mb-4">
        <div class="col-lg-8">
            <div class="card border-0 shadow-sm h-100" style="border-radius: 10px;">
                <div class="card-header bg-white py-3 border-bottom border-light">
                    <div class="d-flex justify-content-between align-items-center">
                        <h6 class="mb-0 fw-bold text-slate-800">Recent Stream Activity</h6>
                        <span class="badge bg-slate-100 text-slate-600 fw-semibold x-small">LIVE LOG</span>
                    </div>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead class="bg-slate-50 text-slate-500 x-small text-uppercase fw-bold">
                                <tr>
                                    <th class="px-4 py-3 border-0">Identifier & Title</th>
                                    <th class="px-3 py-3 border-0">Assignee</th>
                                    <th class="px-3 py-3 border-0">State</th>
                                    <th class="px-4 py-3 border-0 text-end">Due</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($recentTasks as $task)
                                    <tr wire:key="task-row-{{ $task->id }}">
                                        <td class="px-4 py-3">
                                            <div class="d-flex align-items-center gap-3">
                                                <div class="text-indigo-600 fw-bold bg-indigo-50 px-2 py-1 rounded" style="font-size: 0.7rem; font-family: 'JetBrains Mono', monospace;">
                                                    {{ $task->project->prefix }}-{{ $task->task_number }}
                                                </div>
                                                <div class="fw-semibold text-slate-800 text-truncate" style="font-size: 0.8125rem; max-width: 250px;">{{ $task->title }}</div>
                                            </div>
                                        </td>
                                        <td class="px-3 py-3">
                                            <x-user-avatar :user="$task->assignee" size="26px" />
                                        </td>
                                        <td class="px-3 py-3">
                                            <span class="badge rounded-pill fw-bold" 
                                                style="font-size: 0.55rem; background: {{ $task->statusRecord->color ?? '#64748b' }}12; color: {{ $task->statusRecord->color ?? '#64748b' }}; border: 1px solid {{ $task->statusRecord->color ?? '#64748b' }}25 !important;">
                                                {{ strtoupper($task->statusRecord->name ?? 'N/A') }}
                                            </span>
                                        </td>
                                        <td class="px-4 py-3 text-end">
                                            <span class="text-slate-500 x-small">
                                                {{ $task->due_date ? $task->due_date->format('d M') : '--' }}
                                            </span>
                                        </td>
                                    </tr>
                                @empty
                                    <tr><td colspan="4" class="text-center py-5 text-muted small">Initialization pending...</td></tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="card border-0 shadow-sm h-100 bg-indigo-600 text-white" style="border-radius: 10px;">
                <div class="card-body p-4 d-flex flex-column justify-content-between">
                    <div>
                        <h6 class="fw-bold mb-4 opacity-75">Workload Velocity</h6>
                        <div class="d-flex align-items-baseline gap-2 mb-2">
                            <h2 class="fw-bold mb-0" style="font-size: 2.5rem;">{{ $totalTasks > 0 ? round(($completedCount / $totalTasks) * 100) : 0 }}%</h2>
                            <span class="x-small opacity-75 fw-bold">EFFICIENCY</span>
                        </div>
                        <div class="progress bg-white bg-opacity-20 mb-4" style="height: 8px; border-radius: 10px;">
                            <div class="progress-bar bg-white shadow-sm" style="width: {{ $totalTasks > 0 ? ($completedCount / $totalTasks) * 100 : 0 }}%"></div>
                        </div>
                    </div>
                    <div class="row g-2 text-center">
                        <div class="col-6">
                            <div class="bg-white bg-opacity-10 rounded-3 py-3 border border-white border-opacity-10">
                                <div class="fw-bold fs-4">{{ $totalTasks }}</div>
                                <div class="x-small opacity-50 fw-bold">CAPACITY</div>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="bg-white bg-opacity-10 rounded-3 py-3 border border-white border-opacity-10">
                                <div class="fw-bold fs-4">{{ $team->count() }}</div>
                                <div class="x-small opacity-50 fw-bold">SQUAD</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Bottom Row: Balanced Details --}}
    <div class="row g-4">
        <div class="col-lg-4">
            <div class="card border-0 shadow-sm h-100" style="border-radius: 10px;">
                <div class="card-header bg-white py-3 border-bottom border-light">
                    <h6 class="mb-0 fw-bold text-slate-800">State Metrics</h6>
                </div>
                <div class="card-body py-4">
                    @foreach([
                        ['label' => 'BACKLOG / TODO', 'count' => $todoCount, 'color' => 'bg-slate-300'],
                        ['label' => 'IN EXECUTION', 'count' => $inProgressCount, 'color' => 'bg-amber-400'],
                        ['label' => 'DELIVERED', 'count' => $completedCount, 'color' => 'bg-emerald-500']
                    ] as $stat)
                        <div class="mb-3 last-child-mb-0">
                            <div class="d-flex justify-content-between mb-1">
                                <span class="x-small fw-bold text-slate-500">{{ $stat['label'] }}</span>
                                <span class="x-small fw-bold text-slate-900">{{ $stat['count'] }}</span>
                            </div>
                            <div class="progress" style="height: 5px; border-radius: 10px; background: #f1f5f9;">
                                @php $sPct = $totalTasks > 0 ? ($stat['count'] / $totalTasks) * 100 : 0; @endphp
                                <div class="progress-bar {{ $stat['color'] }}" style="width: {{ $sPct }}%"></div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="card border-0 shadow-sm h-100" style="border-radius: 10px;">
                <div class="card-header bg-white py-3 border-bottom border-light">
                    <h6 class="mb-0 fw-bold text-slate-800">Project Stakeholders</h6>
                </div>
                <div class="card-body py-3">
                    @foreach ($team->take(3) as $member)
                        <div class="d-flex align-items-center justify-content-between mb-3 last-child-mb-0">
                            <div class="d-flex align-items-center gap-3">
                                <x-user-avatar :user="$member" size="30px" />
                                <div>
                                    <div class="fw-bold text-slate-900 small mb-0">{{ $member->name }}</div>
                                    <div class="text-slate-400 x-small fw-semibold">{{ strtoupper($member->role) }}</div>
                                </div>
                            </div>
                            <div class="pulse-indicator bg-emerald-500"></div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="card border-0 shadow-sm h-100" style="border-radius: 10px;">
                <div class="card-header bg-white py-3 border-bottom border-light">
                    <h6 class="mb-0 fw-bold text-slate-800">Portfolio Overview</h6>
                </div>
                <div class="card-body p-0">
                    @foreach ($projects as $project)
                        <div class="px-4 py-2 border-bottom border-light transition">
                            <div class="d-flex justify-content-between align-items-center mb-1">
                                <span class="fw-bold text-slate-700 small text-truncate" style="max-width: 150px;">{{ $project->name }}</span>
                                <span class="text-indigo-600 fw-bold" style="font-size: 0.65rem;">{{ $project->tasks_count }}T</span>
                            </div>
                            @php $pPct = $project->tasks_count > 0 ? ($project->completed_tasks_count / $project->tasks_count) * 100 : 0; @endphp
                            <div class="progress" style="height: 3px; border-radius: 10px; background: #f1f5f9;">
                                <div class="progress-bar bg-indigo-500" style="width: {{ $pPct }}%"></div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>

    <style>
        @import url('https://fonts.googleapis.com/css2?family=JetBrains+Mono:wght@700&display=swap');
        
        body { background-color: #f8fafc; color: #334155; }
        .text-slate-900 { color: #0f172a; }
        .text-slate-800 { color: #1e293b; }
        .text-slate-700 { color: #334155; }
        .text-slate-500 { color: #64748b; }
        .text-slate-400 { color: #94a3b8; }
        
        .bg-indigo-500 { background-color: #6366f1; }
        .bg-indigo-600 { background-color: #4f46e5; }
        .bg-indigo-50 { background-color: #eef2ff; }
        .text-indigo-600 { color: #4f46e5; }
        .text-indigo-700 { color: #4338ca; }
        .btn-indigo { background-color: #4f46e5; color: white; border: none; }
        
        .bg-amber-500 { background-color: #f59e0b; }
        .bg-amber-400 { background-color: #fbbf24; }
        .bg-amber-50 { background-color: #fffbeb; }
        
        .bg-emerald-500 { background-color: #10b981; }
        .bg-emerald-50 { background-color: #ecfdf5; }
        
        .bg-rose-500 { background-color: #f43f5e; }

        .x-small { font-size: 0.65rem; letter-spacing: 0.5px; }
        .last-child-mb-0:last-child { margin-bottom: 0 !important; }
        .btn-white { background: white; color: #475569; }
        .transition { transition: all 0.2s ease; }
        
        .pulse-indicator {
            width: 7px;
            height: 7px;
            border-radius: 50%;
            animation: pulse 2s infinite;
        }
        
        @keyframes pulse {
            0% { box-shadow: 0 0 0 0 rgba(16, 185, 129, 0.4); }
            70% { box-shadow: 0 0 0 6px rgba(16, 185, 129, 0); }
            100% { box-shadow: 0 0 0 0 rgba(16, 185, 129, 0); }
        }
    </style>
</div>
