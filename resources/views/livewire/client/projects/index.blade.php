<div>
    <x-page-header title="Project Portfolio" subtitle="Overview of projects assigned to your account" :breadcrumbItems="[['label' => 'Projects', 'url' => '/projects'], ['label' => 'My Projects']]">
    </x-page-header>

    <div class="card border-0 shadow-sm" style="background: #fff; border: 1px solid #e2e8f0 !important; border-radius: 10px;">
        <div class="card-header bg-white py-3 border-0">
            <div class="row g-2 align-items-center">
                <div class="col-md-4">
                    <div class="input-group input-group-sm">
                        <span class="input-group-text bg-light border-0 text-muted">
                            <i class="bi bi-search"></i>
                        </span>
                        <input wire:model.live.debounce.500ms="search" type="text"
                            class="form-control bg-light border-0" placeholder="Search by name..." style="font-size: 0.8125rem;">
                    </div>
                </div>
            </div>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="bg-light text-slate-500 x-small text-uppercase fw-bold">
                        <tr>
                            <th class="px-4 py-3 border-0">Code</th>
                            <th class="px-3 py-3 border-0">Project Name</th>
                            <th class="px-3 py-3 border-0">Description</th>
                            <th class="px-3 py-3 border-0">Status</th>
                            <th class="px-4 py-3 border-0 text-end">Navigation</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($projects as $project)
                            <tr wire:key="client-project-{{ $project->id }}">
                                <td class="px-4 py-3">
                                    <span class="badge bg-indigo-50 text-indigo-600 border fw-bold" style="font-size: 0.75rem; font-family: monospace;">{{ $project->prefix }}</span>
                                </td>
                                <td class="px-3 py-3">
                                    <div class="fw-bold text-slate-800" style="font-size: 0.875rem;">{{ $project->name }}</div>
                                </td>
                                <td class="px-3 py-3">
                                    <div class="text-muted small text-truncate" style="max-width: 300px;">{{ $project->description ?? 'No description.' }}</div>
                                </td>
                                <td class="px-3 py-3">
                                    <span class="badge rounded-pill bg-emerald-50 text-emerald-600 border border-emerald-100 x-small px-3">Active Engagement</span>
                                </td>
                                <td class="px-4 py-3 text-end">
                                    <a href="/tasks?project={{ $project->id }}" wire:navigate class="btn btn-sm btn-indigo px-3 fw-bold" style="font-size: 0.75rem;">
                                        View Board <i class="bi bi-chevron-right ms-1"></i>
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr><td colspan="5" class="text-center py-5 text-muted small">You are not currently assigned to any active projects.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <style>
        .text-slate-500 { color: #64748b; }
        .text-slate-800 { color: #1e293b; }
        .bg-indigo-50 { background-color: #eef2ff; }
        .text-indigo-600 { color: #4f46e5; }
        .btn-indigo { background-color: #4f46e5; color: white; border: none; }
        .btn-indigo:hover { background-color: #4338ca; color: white; }
        .bg-emerald-50 { background-color: #ecfdf5; }
        .text-emerald-600 { color: #059669; }
        .x-small { font-size: 0.65rem; }
    </style>
</div>
