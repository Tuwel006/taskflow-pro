<x-layouts.app title="Dashboard">
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
                    <div class="h4 fw-bold mb-0" style="color: #0f172a;">24</div>
                    <div class="text-success fw-semibold mt-1" style="font-size: 0.75rem;">
                        <i class="bi bi-graph-up-arrow"></i> +12% vs last month
                    </div>
                </div>
            </div>
        </div>
        <div class="col-6 col-md-3">
            <div class="card border-0" style="background: #fff; border: 1px solid #e2e8f0 !important; border-radius: 8px;">
                <div class="card-body p-3">
                    <div class="text-uppercase text-muted fw-bold mb-1" style="font-size: 0.65rem; letter-spacing: 0.05em;">In Progress</div>
                    <div class="h4 fw-bold mb-0" style="color: #0f172a;">08</div>
                    <div class="text-muted mt-1" style="font-size: 0.75rem;">3 due today</div>
                </div>
            </div>
        </div>
        <div class="col-6 col-md-3">
            <div class="card border-0" style="background: #fff; border: 1px solid #e2e8f0 !important; border-radius: 8px;">
                <div class="card-body p-3">
                    <div class="text-uppercase text-muted fw-bold mb-1" style="font-size: 0.65rem; letter-spacing: 0.05em;">Completed</div>
                    <div class="h4 fw-bold mb-0" style="color: #0f172a;">126</div>
                    <div class="text-muted mt-1" style="font-size: 0.75rem;">Lifetime total</div>
                </div>
            </div>
        </div>
        <div class="col-6 col-md-3">
            <div class="card border-0" style="background: #fff; border: 1px solid #e2e8f0 !important; border-radius: 8px;">
                <div class="card-body p-3">
                    <div class="text-uppercase text-muted fw-bold mb-1" style="font-size: 0.65rem; letter-spacing: 0.05em;">Avg. Efficiency</div>
                    <div class="h4 fw-bold mb-0" style="color: #0f172a;">94.2%</div>
                    <div class="text-muted mt-1" style="font-size: 0.75rem;">Based on 30 days</div>
                </div>
            </div>
        </div>
    </div>

    <div class="row g-4">
        <!-- Recent Activities Table -->
        <div class="col-lg-8">
            <x-data-table :items="collect([1,2,3,4])" emptyText="No active tasks in queue.">
                <x-slot name="header">
                    <div class="d-flex justify-content-between align-items-center">
                        <h6 class="mb-0 fw-bold" style="font-size: 0.875rem; color: #1e293b;">Active Work Queue</h6>
                        <button class="btn btn-sm btn-outline-secondary" style="font-size: 0.75rem;">Export CSV</button>
                    </div>
                </x-slot>

                <x-slot name="columns">
                    <x-table.th>Task Detail</x-table.th>
                    <x-table.th>Stakeholder</x-table.th>
                    <x-table.th>Priority</x-table.th>
                    <x-table.th>Due Date</x-table.th>
                    <x-table.th align="end"></x-table.th>
                </x-slot>

                @foreach([
                    ['Infrastructure Upgrade', 'Engineering Dept', 'Urgent', 'Today', 'danger'],
                    ['Security Review', 'Compliance', 'High', 'Tomorrow', 'warning'],
                    ['API Documentation', 'Development', 'Medium', 'Apr 24', 'info'],
                    ['Client Presentation', 'Marketing', 'Low', 'Apr 26', 'secondary']
                ] as $task)
                    <x-table.row>
                        <x-table.td>
                            <div class="fw-semibold" style="font-size: 0.8125rem; color: #334155;">{{ $task[0] }}</div>
                            <div style="font-size: 0.7rem; color: #94a3b8;">System-wide update</div>
                        </x-table.td>
                        <x-table.td>
                            <span style="font-size: 0.8125rem; color: #475569;">{{ $task[1] }}</span>
                        </x-table.td>
                        <x-table.td>
                            <span class="badge" style="font-size: 0.65rem; border: 1px solid transparent; background-color: rgba(0,0,0,0.05); color: #475569;">
                                {{ $task[2] }}
                            </span>
                        </x-table.td>
                        <x-table.td>
                            <span style="font-size: 0.8125rem; color: #64748b;">{{ $task[3] }}</span>
                        </x-table.td>
                        <x-table.td align="end">
                            <button class="btn btn-sm" style="color: #64748b;"><i class="bi bi-three-dots"></i></button>
                        </x-table.td>
                    </x-table.row>
                @endforeach

                <x-slot name="footer">
                    <div class="text-center">
                        <a href="/tasks" class="text-decoration-none fw-bold" style="font-size: 0.75rem; color: #3b82f6;">View Full Registry <i class="bi bi-arrow-right"></i></a>
                    </div>
                </x-slot>
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
</x-layouts.app>
