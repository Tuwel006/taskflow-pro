<div class="container-fluid py-2">
    <x-page-header 
        title="Command Dashboard" 
        subtitle="Centralized intelligence and overview of all operations"
        :breadcrumbItems="[['label' => 'Analytics', 'url' => '#'], ['label' => 'Current Status']]"
    />
    <!-- Header Summary -->
    <div class="row g-3 mb-4">
        <div class="col-6 col-md-3">
            <div class="card border-0" style="background: #fff; border: 1px solid #e2e8f0 !important; border-radius: 8px;">
                <div class="card-body p-3">
                    <div class="text-uppercase text-muted fw-bold mb-1" style="font-size: 0.65rem; letter-spacing: 0.05em;">Total Assignments</div>
                    <div class="h4 fw-bold mb-0" style="color: #0f172a;">{{ str_pad($totalTasks, 2, '0', STR_PAD_LEFT) }}</div>
                    <div class="text-success fw-semibold mt-1" style="font-size: 0.75rem;">
                        Global count
                    </div>
                </div>
            </div>
        </div>
        <div class="col-6 col-md-3">
            <div class="card border-0" style="background: #fff; border: 1px solid #e2e8f0 !important; border-radius: 8px;">
                <div class="card-body p-3">
                    <div class="text-uppercase text-muted fw-bold mb-1" style="font-size: 0.65rem; letter-spacing: 0.05em;">In Progress</div>
                    <div class="h4 fw-bold mb-0" style="color: #0f172a;">{{ str_pad($inProgressCount, 2, '0', STR_PAD_LEFT) }}</div>
                    <div class="text-muted mt-1" style="font-size: 0.75rem;">Active status</div>
                </div>
            </div>
        </div>
        <div class="col-6 col-md-3">
            <div class="card border-0" style="background: #fff; border: 1px solid #e2e8f0 !important; border-radius: 8px;">
                <div class="card-body p-3">
                    <div class="text-uppercase text-muted fw-bold mb-1" style="font-size: 0.65rem; letter-spacing: 0.05em;">Completed</div>
                    <div class="h4 fw-bold mb-0" style="color: #0f172a;">{{ str_pad($completedCount, 2, '0', STR_PAD_LEFT) }}</div>
                    <div class="text-muted mt-1" style="font-size: 0.75rem;">Successfully finished</div>
                </div>
            </div>
        </div>
        <div class="col-6 col-md-3">
            <div class="card border-0" style="background: #fff; border: 1px solid #e2e8f0 !important; border-radius: 8px;">
                <div class="card-body p-3">
                    <div class="text-uppercase text-muted fw-bold mb-1" style="font-size: 0.65rem; letter-spacing: 0.05em;">Avg. Efficiency</div>
                    <div class="h4 fw-bold mb-0" style="color: #0f172a;">{{ $totalTasks > 0 ? round(($completedCount/$totalTasks)*100, 1) : 0 }}%</div>
                    <div class="text-muted mt-1" style="font-size: 0.75rem;">Completion rate</div>
                </div>
            </div>
        </div>
    </div>

    <div class="row g-4">
        <!-- Recent Activities Table -->
        <div class="col-lg-8">
            <x-data-table :items="$recentTasks" emptyText="No recent activities.">
                <x-slot name="header">
                    <div class="d-flex justify-content-between align-items-center">
                        <h6 class="mb-0 fw-bold" style="font-size: 0.875rem; color: #1e293b;">Recent Activity Log</h6>
                        <a href="/tasks" wire:navigate class="btn btn-sm btn-outline-secondary" style="font-size: 0.75rem;">View All</a>
                    </div>
                </x-slot>

                <x-slot name="columns">
                    <x-table.th>Task Detail</x-table.th>
                    <x-table.th>Assignee</x-table.th>
                    <x-table.th>Status</x-table.th>
                    <x-table.th align="end">Priority</x-table.th>
                </x-slot>

                @foreach($recentTasks as $task)
                    <x-table.row>
                        <x-table.td>
                            <div class="fw-semibold" style="font-size: 0.8125rem; color: #334155;">{{ $task->title }}</div>
                            <div style="font-size: 0.7rem; color: #94a3b8;">{{ \Carbon\Carbon::parse($task->created_at)->diffForHumans() }}</div>
                        </x-table.td>
                        <x-table.td>
                            <div class="d-flex align-items-center gap-2">
                                <x-user-avatar :user="$task->assignee" size="24px" fontsize="0.65rem" />
                                <span style="font-size: 0.8125rem; color: #475569;">{{ $task->assignee->name ?? 'System' }}</span>
                            </div>
                        </x-table.td>
                        <x-table.td>
                            <span class="badge rounded-pill" style="font-size: 0.65rem; background: {{ $task->statusRecord->color ?? '#64748b' }}15; color: {{ $task->statusRecord->color ?? '#64748b' }}; border: 1px solid {{ $task->statusRecord->color ?? '#64748b' }}44 !important;">
                                {{ $task->statusRecord->name ?? 'N/A' }}
                            </span>
                        </x-table.td>
                        <x-table.td align="end">
                            @php
                                $pColor = match($task->priority) {
                                    'Urgent' => '#ef4444',
                                    'High' => '#f59e0b',
                                    'Medium' => '#3b82f6',
                                    default => '#94a3b8'
                                };
                            @endphp
                            <span style="font-size: 0.75rem; font-weight: 600; color: {{ $pColor }};">
                                {{ $task->priority }}
                            </span>
                        </x-table.td>
                    </x-table.row>
                @endforeach
            </x-data-table>
        </div>


        <!-- Quick Entry / Context Sidebar -->
        <div class="col-lg-4">
            <div class="card border-0 mb-4" style="background: #fff; border: 1px solid #e2e8f0 !important; border-radius: 8px;">
                <div class="card-header bg-white py-3 border-0">
                    <h6 class="mb-0 fw-bold" style="font-size: 0.875rem; color: #1e293b;">New Task Entry</h6>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <label class="form-label mb-1" style="font-size: 0.75rem; font-weight: 600; color: #64748b;">Description</label>
                        <input type="text" class="form-control" placeholder="e.g. Weekly Report" style="font-size: 0.8125rem; border-radius: 6px;">
                    </div>
                    <div class="mb-3">
                        <label class="form-label mb-1" style="font-size: 0.75rem; font-weight: 600; color: #64748b;">Priority Level</label>
                        <select class="form-select" style="font-size: 0.8125rem; border-radius: 6px;">
                            <option>Standard</option>
                            <option>High Priority</option>
                            <option>Urgent</option>
                        </select>
                    </div>
                    <button class="btn btn-primary w-100" style="font-size: 0.8125rem; font-weight: 600; border-radius: 6px;">Create Task Record</button>
                </div>
            </div>

            <div class="card border-0" style="background: #f8fafc; border: 1px dashed #cbd5e1 !important; border-radius: 8px;">
                <div class="card-body p-3 text-center">
                    <div class="avatar-group mb-2 d-flex justify-content-center">
                        <div class="rounded-circle bg-secondary text-white d-flex align-items-center justify-content-center" style="width: 24px; height: 24px; font-size: 0.6rem;">JS</div>
                        <div class="rounded-circle bg-info text-white d-flex align-items-center justify-content-center ms-n2" style="width: 24px; height: 24px; font-size: 0.6rem; margin-left: -8px; border: 2px solid #fff;">RK</div>
                    </div>
                    <p class="mb-0" style="font-size: 0.75rem; color: #64748b;">Collaborate with your team</p>
                    <a href="#" class="text-decoration-none fw-bold" style="font-size: 0.75rem; color: #334155;">Invite Members</a>
                </div>
            </div>
        </div>
    </div>
</div>
