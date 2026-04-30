<div class="container-fluid py-2">

    <style>
        .dash-stat-card {
            background: #fff;
            border: 1px solid #e2e8f0;
            border-radius: 12px;
            padding: 1.25rem 1.4rem;
            display: flex;
            align-items: center;
            gap: 1rem;
            transition: box-shadow .2s;
        }
        .dash-stat-card:hover {
            box-shadow: 0 4px 16px rgba(15,23,42,.07);
        }
        .dash-stat-icon {
            width: 44px;
            height: 44px;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.2rem;
            flex-shrink: 0;
        }
        .dash-stat-label {
            font-size: 0.72rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: .05em;
            color: #94a3b8;
            margin-bottom: 2px;
        }
        .dash-stat-value {
            font-size: 1.6rem;
            font-weight: 700;
            color: #0f172a;
            line-height: 1;
        }
        .dash-card {
            background: #fff;
            border: 1px solid #e2e8f0;
            border-radius: 12px;
            overflow: hidden;
        }
        .dash-card-header {
            padding: .85rem 1.25rem;
            border-bottom: 1px solid #f1f5f9;
            font-size: 0.8125rem;
            font-weight: 700;
            color: #0f172a;
            display: flex;
            align-items: center;
            gap: .5rem;
        }
        .task-row {
            display: flex;
            align-items: center;
            gap: .75rem;
            padding: .65rem 1.25rem;
            border-bottom: 1px solid #f8fafc;
            font-size: 0.8rem;
            transition: background .15s;
        }
        .task-row:last-child { border-bottom: none; }
        .task-row:hover { background: #f8fafc; }
        .task-title {
            font-weight: 600;
            color: #1e293b;
            flex: 1;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
            max-width: 220px;
        }
        .task-project {
            font-size: 0.72rem;
            color: #94a3b8;
            white-space: nowrap;
        }
        .status-pill {
            font-size: 0.68rem;
            font-weight: 600;
            padding: .2rem .55rem;
            border-radius: 20px;
            white-space: nowrap;
        }
        .project-row {
            padding: .7rem 1.25rem;
            border-bottom: 1px solid #f1f5f9;
        }
        .project-row:last-child { border-bottom: none; }
        .progress-thin {
            height: 5px;
            border-radius: 10px;
            background: #f1f5f9;
            overflow: hidden;
            margin-top: 5px;
        }
        .progress-thin-bar {
            height: 100%;
            background: linear-gradient(90deg, #0ea5e9, #0369a1);
            border-radius: 10px;
            transition: width .4s ease;
        }
    </style>

    {{-- Page greeting --}}
    <div class="mb-4">
        <h1 style="font-size: 1.3rem; font-weight: 700; color: #0f172a; margin-bottom: 2px;">
            👋 Welcome back, {{ auth()->user()->name }}
        </h1>
        <p class="text-muted mb-0" style="font-size: 0.8125rem;">
            Here's a quick overview of what's happening in your workspace today.
        </p>
    </div>

    {{-- ── Row 1: Summary Stats ── --}}
    <div class="row g-3 mb-4">

        {{-- Total Tasks --}}
        <div class="col-6 col-md-3">
            <div class="dash-stat-card">
                <div class="dash-stat-icon" style="background: #eff6ff; color: #2563eb;">
                    <i class="bi bi-list-task"></i>
                </div>
                <div>
                    <div class="dash-stat-label">Total Tasks</div>
                    <div class="dash-stat-value">{{ $totalTasks }}</div>
                </div>
            </div>
        </div>

        {{-- In Progress --}}
        <div class="col-6 col-md-3">
            <div class="dash-stat-card">
                <div class="dash-stat-icon" style="background: #fffbeb; color: #d97706;">
                    <i class="bi bi-arrow-clockwise"></i>
                </div>
                <div>
                    <div class="dash-stat-label">In Progress</div>
                    <div class="dash-stat-value">{{ $inProgressTasks }}</div>
                </div>
            </div>
        </div>

        {{-- Completed --}}
        <div class="col-6 col-md-3">
            <div class="dash-stat-card">
                <div class="dash-stat-icon" style="background: #f0fdf4; color: #16a34a;">
                    <i class="bi bi-check-circle"></i>
                </div>
                <div>
                    <div class="dash-stat-label">Completed</div>
                    <div class="dash-stat-value">{{ $completedTasks }}</div>
                </div>
            </div>
        </div>

        {{-- Overdue --}}
        <div class="col-6 col-md-3">
            <div class="dash-stat-card">
                <div class="dash-stat-icon" style="background: #fff1f2; color: #dc2626;">
                    <i class="bi bi-exclamation-circle"></i>
                </div>
                <div>
                    <div class="dash-stat-label">Overdue</div>
                    <div class="dash-stat-value" style="{{ $overdueTasks > 0 ? 'color:#dc2626;' : '' }}">
                        {{ $overdueTasks }}
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- ── Row 2: People + Projects quick stats ── --}}
    <div class="row g-3 mb-4">
        <div class="col-6 col-md-4">
            <div class="dash-stat-card">
                <div class="dash-stat-icon" style="background: #f0f9ff; color: #0369a1;">
                    <i class="bi bi-folder2-open"></i>
                </div>
                <div>
                    <div class="dash-stat-label">Active Projects</div>
                    <div class="dash-stat-value">{{ $totalProjects }}</div>
                </div>
            </div>
        </div>
        <div class="col-6 col-md-4">
            <div class="dash-stat-card">
                <div class="dash-stat-icon" style="background: #faf5ff; color: #7c3aed;">
                    <i class="bi bi-person-badge"></i>
                </div>
                <div>
                    <div class="dash-stat-label">Agents</div>
                    <div class="dash-stat-value">{{ $totalAgents }}</div>
                </div>
            </div>
        </div>
        <div class="col-6 col-md-4">
            <div class="dash-stat-card">
                <div class="dash-stat-icon" style="background: #fff7ed; color: #c2410c;">
                    <i class="bi bi-building"></i>
                </div>
                <div>
                    <div class="dash-stat-label">Clients</div>
                    <div class="dash-stat-value">{{ $totalClients }}</div>
                </div>
            </div>
        </div>
    </div>

    {{-- ── Row 3: Recent Tasks + Projects ── --}}
    <div class="row g-3">

        {{-- Recent Tasks --}}
        <div class="col-lg-7">
            <div class="dash-card">
                <div class="dash-card-header">
                    <i class="bi bi-clock-history text-muted"></i>
                    Latest Tasks
                    <a href="/tasks" wire:navigate class="ms-auto text-muted" style="font-size:.75rem; font-weight:500; text-decoration:none;">
                        View all <i class="bi bi-arrow-right"></i>
                    </a>
                </div>

                @forelse ($recentTasks as $task)
                    <div class="task-row">
                        {{-- Assignee avatar --}}
                        <x-user-avatar :user="$task->assignee" size="26px" fontsize="0.6rem" />

                        {{-- Title + project --}}
                        <div style="flex:1; min-width:0;">
                            <div class="task-title">{{ $task->title }}</div>
                            <div class="task-project">
                                <i class="bi bi-folder me-1"></i>{{ $task->project->name ?? '—' }}
                            </div>
                        </div>

                        {{-- Status --}}
                        @if ($task->statusRecord)
                            <span class="status-pill"
                                style="background: {{ $task->statusRecord->color ?? '#64748b' }}18; color: {{ $task->statusRecord->color ?? '#64748b' }}; border: 1px solid {{ $task->statusRecord->color ?? '#64748b' }}30;">
                                {{ $task->statusRecord->name }}
                            </span>
                        @endif

                        {{-- Due date --}}
                        <span style="font-size:.72rem; color:#94a3b8; white-space:nowrap;">
                            {{ $task->due_date ? $task->due_date->format('d M') : '—' }}
                        </span>
                    </div>
                @empty
                    <div class="text-center py-5 text-muted" style="font-size:.8rem;">
                        <i class="bi bi-inbox display-6 d-block mb-2 opacity-25"></i>
                        No tasks yet. <a href="/tasks" wire:navigate>Create one</a>.
                    </div>
                @endforelse
            </div>
        </div>

        {{-- Projects overview --}}
        <div class="col-lg-5">
            <div class="dash-card">
                <div class="dash-card-header">
                    <i class="bi bi-folder2 text-muted"></i>
                    Projects
                    <a href="/projects" wire:navigate class="ms-auto text-muted" style="font-size:.75rem; font-weight:500; text-decoration:none;">
                        View all <i class="bi bi-arrow-right"></i>
                    </a>
                </div>

                @forelse ($projects as $project)
                    @php
                        $pct = $project->tasks_count > 0
                            ? round(($project->completed_tasks_count / $project->tasks_count) * 100)
                            : 0;
                    @endphp
                    <div class="project-row">
                        <div class="d-flex justify-content-between align-items-center">
                            <span style="font-size:.8125rem; font-weight:600; color:#1e293b;">
                                {{ $project->name }}
                            </span>
                            <span style="font-size:.72rem; color:#94a3b8;">
                                {{ $project->completed_tasks_count }}/{{ $project->tasks_count }} done
                            </span>
                        </div>
                        <div class="progress-thin">
                            <div class="progress-thin-bar" style="width: {{ $pct }}%;"></div>
                        </div>
                    </div>
                @empty
                    <div class="text-center py-5 text-muted" style="font-size:.8rem;">
                        <i class="bi bi-folder-x display-6 d-block mb-2 opacity-25"></i>
                        No projects yet.
                    </div>
                @endforelse
            </div>
        </div>

    </div>

</div>
