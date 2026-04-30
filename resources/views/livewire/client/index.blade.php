<div class="container-fluid py-3">
    <x-page-header title="Client Directory" subtitle="Manage external stakeholders and project clients"
        :breadcrumbItems="[['label' => 'Project', 'url' => '/clients'], ['label' => 'Client List']]">
        <x-slot name="actions">
            <div class="d-flex gap-2">

                <a href="/clients/create" wire:navigate class="btn btn-sm btn-primary px-3 shadow-sm d-flex align-items-center" style="font-weight: 600; border-radius: 6px; background: #3b82f6;">
                    <i class="bi bi-plus-lg me-2"></i> Register Client
                </a>
            </div>
        </x-slot>
    </x-page-header>

    @if (session()->has('message'))
        <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm mb-4" role="alert" style="border-left: 4px solid #10b981 !important; background: #ecfdf5; color: #065f46; font-size: 0.875rem;">
            <i class="bi bi-check-circle-fill me-2"></i> {{ session('message') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="card border-0 shadow-sm" style="background: #fff; border: 1px solid #e2e8f0 !important; border-radius: 10px;">
        <div class="card-header bg-white py-3 border-0">
            <div class="d-flex justify-content-between align-items-center">
                <div class="d-flex align-items-center gap-2">
                    <div class="input-group" style="width: 300px;">
                        <span class="input-group-text bg-light border-0"><i class="bi bi-search text-muted"></i></span>
                        <input type="text" class="form-control bg-light border-0" placeholder="Search clients..." style="font-size: 0.8125rem;" wire:model.live="search">
                    </div>
                    <select class="form-select form-select-sm border-0 bg-light" style="width: 120px; font-size: 0.8125rem;" wire:model.live="status">
                        <option value="">All Status</option>
                        <option value="1">Active</option>
                        <option value="0">Inactive</option>
                    </select>
                </div>
                <div class="d-flex align-items-center gap-2">
                    <span class="text-muted small">Show</span>
                    <select class="form-select form-select-sm border-0 bg-light" style="width: 70px; font-size: 0.8125rem;" wire:model.live="itemPerPage">
                        <option value="10">10</option>
                        <option value="25">25</option>
                        <option value="50">50</option>
                    </select>
                </div>
            </div>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="bg-light text-muted" style="font-size: 0.75rem; text-uppercase: uppercase; font-weight: 700;">
                        <tr>
                            <th class="px-4 py-3">Client Identity</th>
                            <th class="px-3 py-3 text-center">Status</th>
                            <th class="px-3 py-3">Phone</th>
                            <th class="px-3 py-3">Projects</th>
                            <th class="px-4 py-3 text-end">Action Management</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($clients as $client)
                            <tr wire:key="client-{{ $client->id }}">
                                <td class="px-4 py-3">
                                    <div class="d-flex align-items-center gap-3">
                                        <x-user-avatar :user="$client" size="38px" />
                                        <div>
                                            <div class="fw-bold text-dark mb-0" style="font-size: 0.875rem;">{{ $client->name }}</div>
                                            <div class="text-muted" style="font-size: 0.75rem;">{{ $client->email }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-3 py-3 text-center">
                                    @if($client->is_active)
                                        <span class="badge rounded-pill" style="background: #d1fae5; color: #065f46; font-size: 0.65rem; padding: 0.35em 0.8em; border: 1px solid #10b98133 !important;">Active</span>
                                    @else
                                        <span class="badge rounded-pill" style="background: #fee2e2; color: #991b1b; font-size: 0.65rem; padding: 0.35em 0.8em; border: 1px solid #ef444433 !important;">Inactive</span>
                                    @endif
                                </td>
                                <td class="px-3 py-3 text-muted" style="font-size: 0.8125rem;">{{ $client->phone ?? '--' }}</td>
                                <td class="px-3 py-3">
                                    <div class="d-flex flex-wrap gap-1">
                                        @foreach($client->projects as $project)
                                            <span class="badge bg-light text-dark border fw-normal" style="font-size: 0.65rem;">{{ $project->name }}</span>
                                        @endforeach
                                    </div>
                                </td>
                                <td class="px-4 py-3 text-end">
                                    <div class="dropdown">
                                        <button class="btn btn-link text-muted p-0" type="button" data-bs-toggle="dropdown">
                                            <i class="bi bi-three-dots-vertical"></i>
                                        </button>
                                        <ul class="dropdown-menu dropdown-menu-end shadow-sm border-0" style="font-size: 0.8125rem;">
                                            <li><a class="dropdown-item py-2" href="/clients/{{ $client->id }}/edit" wire:navigate><i class="bi bi-pencil me-2 text-primary"></i> Modify Profile</a></li>
                                            <li><hr class="dropdown-divider"></li>
                                            <li><button class="dropdown-item py-2 text-danger" wire:click="delete({{ $client->id }})" wire:confirm="Are you sure you want to delete this client?"><i class="bi bi-trash me-2"></i> Delete Client</button></li>
                                        </ul>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr><td colspan="5" class="text-center py-5 text-muted small">No clients found matching your criteria.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="px-4 py-3 border-top bg-light">
                {{ $clients->links() }}
            </div>
        </div>
    </div>
</div>
