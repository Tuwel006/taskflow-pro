<div class="container-fluid py-4 bg-slate-50 min-vh-100">
    {{-- Client Welcome Section --}}
    <div class="row align-items-center mb-4">
        <div class="col-md-8">
            <h4 class="fw-bold text-slate-900 mb-1">Welcome, {{ auth()->user()->name }}</h4>
            <div class="d-flex align-items-center gap-2 text-muted small">
                <i class="bi bi-shield-check text-emerald-500"></i>
                Stakeholder Portal &bull; {{ $selectedProject->name ?? 'Select a Project' }}
            </div>
        </div>
        <div class="col-md-4 text-md-end mt-3 mt-md-0">
            <div class="btn-group shadow-sm">
                <a href="/tasks" wire:navigate class="btn btn-white border btn-sm fw-semibold px-3">
                    <i class="bi bi-list-task me-2"></i>My Tasks
                </a>
                <a href="/projects" wire:navigate class="btn btn-indigo btn-sm fw-semibold px-3">
                    <i class="bi bi-folder2 me-2"></i>All Projects
                </a>
            </div>
        </div>
    </div>

    {{-- Main Insight Row --}}
    <div class="row g-4 mb-4">
        {{-- Progress Visualizer --}}
        <div class="col-lg-7">
            <div class="card border-0 shadow-sm h-100" style="border-radius: 12px; background: #fff;">
                <div class="card-body p-4 d-flex flex-column justify-content-between">
                    <div>
                        <div class="d-flex justify-content-between align-items-start mb-4">
                            <div>
                                <h6 class="fw-bold text-slate-800 mb-1">Project Delivery Status</h6>
                                <p class="text-muted x-small mb-0">Aggregate progress across all milestones</p>
                            </div>
                            <div class="text-end">
                                <span class="h3 fw-bold text-indigo-600 mb-0">{{ $totalTasks > 0 ? round(($completedTasks / $totalTasks) * 100) : 0 }}%</span>
                                <div class="x-small text-muted fw-bold">COMPLETED</div>
                            </div>
                        </div>
                        <div class="progress mb-4" style="height: 12px; border-radius: 20px; background: #f1f5f9;">
                            <div class="progress-bar bg-indigo-500 shadow-sm" style="width: {{ $totalTasks > 0 ? ($completedTasks / $totalTasks) * 100 : 0 }}%"></div>
                        </div>
                    </div>
                    <div class="row g-3">
                        <div class="col-4">
                            <div class="bg-slate-50 rounded-3 p-3 text-center border">
                                <div class="fw-bold text-slate-900 fs-5">{{ $totalTasks }}</div>
                                <div class="x-small text-slate-400 fw-bold">TOTAL TASKS</div>
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="bg-emerald-50 rounded-3 p-3 text-center border border-emerald-100">
                                <div class="fw-bold text-emerald-600 fs-5">{{ $completedTasks }}</div>
                                <div class="x-small text-emerald-500 fw-bold">DELIVERED</div>
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="bg-amber-50 rounded-3 p-3 text-center border border-amber-100">
                                <div class="fw-bold text-amber-600 fs-5">{{ $totalTasks - $completedTasks }}</div>
                                <div class="x-small text-amber-500 fw-bold">PENDING</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Project Portfolio Sidebar --}}
        <div class="col-lg-5">
            <div class="card border-0 shadow-sm h-100" style="border-radius: 12px;">
                <div class="card-header bg-white py-3 border-bottom border-light">
                    <h6 class="mb-0 fw-bold text-slate-800">My Projects</h6>
                </div>
                <div class="card-body p-0">
                    <div class="list-group list-group-flush">
                        @foreach ($projects as $project)
                            <div class="list-group-item border-light px-4 py-3 {{ $project->id == $selectedProjectId ? 'bg-indigo-50 border-start border-indigo-500 border-4' : '' }}">
                                <div class="d-flex justify-content-between align-items-center mb-2">
                                    <span class="fw-bold text-slate-800 small">{{ $project->name }}</span>
                                    <span class="badge bg-white border text-slate-600 x-small">{{ $project->prefix }}</span>
                                </div>
                                @php $pPct = $project->tasks_count > 0 ? ($project->completed_tasks / $project->tasks_count) * 100 : 0; @endphp
                                <div class="progress" style="height: 4px; background: #f1f5f9;">
                                    <div class="progress-bar bg-indigo-500" style="width: {{ $pPct }}%"></div>
                                </div>
                                <div class="d-flex justify-content-between mt-1">
                                    <span class="x-small text-muted">{{ round($pPct) }}% complete</span>
                                    <span class="x-small text-muted">{{ $project->tasks_count }} milestones</span>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Activity Row --}}
    <div class="row g-4">
        <div class="col-lg-12">
            <div class="card border-0 shadow-sm" style="border-radius: 12px;">
                <div class="card-header bg-white py-3 border-bottom border-light">
                    <h6 class="mb-0 fw-bold text-slate-800">Latest Project Updates</h6>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead class="bg-slate-50 text-slate-500 x-small text-uppercase fw-bold">
                                <tr>
                                    <th class="px-4 py-3 border-0">Milestone / Task</th>
                                    <th class="px-3 py-3 border-0">Current Stage</th>
                                    <th class="px-3 py-3 border-0">Handled By</th>
                                    <th class="px-4 py-3 border-0 text-end">Last Updated</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($recentUpdates as $task)
                                    <tr>
                                        <td class="px-4 py-3">
                                            <div class="fw-bold text-slate-800 mb-0" style="font-size: 0.8125rem;">{{ $task->title }}</div>
                                            <div class="text-muted x-small">{{ $task->display_id }}</div>
                                        </td>
                                        <td class="px-3 py-3">
                                            <span class="badge rounded-pill fw-bold" 
                                                style="font-size: 0.6rem; background: {{ $task->statusRecord->color ?? '#64748b' }}12; color: {{ $task->statusRecord->color ?? '#64748b' }}; border: 1px solid {{ $task->statusRecord->color ?? '#64748b' }}25 !important;">
                                                {{ strtoupper($task->statusRecord->name ?? 'N/A') }}
                                            </span>
                                        </td>
                                        <td class="px-3 py-3">
                                            <div class="d-flex align-items-center gap-2">
                                                <x-user-avatar :user="$task->assignee" size="24px" />
                                                <span class="text-slate-600 x-small fw-semibold">{{ $task->assignee->name ?? 'System' }}</span>
                                            </div>
                                        </td>
                                        <td class="px-4 py-3 text-end">
                                            <span class="text-slate-400 x-small">{{ $task->updated_at->diffForHumans() }}</span>
                                        </td>
                                    </tr>
                                @empty
                                    <tr><td colspan="4" class="text-center py-5 text-muted small">No recent updates recorded.</td></tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <style>
        body { background-color: #f8fafc; color: #334155; }
        .text-slate-900 { color: #0f172a; }
        .text-slate-800 { color: #1e293b; }
        .text-indigo-600 { color: #4f46e5; }
        .bg-indigo-500 { background-color: #6366f1; }
        .bg-indigo-50 { background-color: #eef2ff; }
        .bg-emerald-50 { background-color: #ecfdf5; }
        .text-emerald-600 { color: #059669; }
        .bg-amber-50 { background-color: #fffbeb; }
        .text-amber-600 { color: #d97706; }
        .x-small { font-size: 0.7rem; }
        .btn-white { background: white; color: #475569; }
    </style>
</div>
