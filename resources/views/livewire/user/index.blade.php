<div class="container-fluid py-2">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="mb-0 fw-bold" style="color: #0f172a;">User Directory</h4>
            <p class="text-muted mb-0" style="font-size: 0.8125rem;">Manage team members, roles, and access credentials</p>
        </div>
        <a href="/users/create" wire:navigate class="btn btn-primary px-3" style="font-size: 0.8125rem; font-weight: 600; border-radius: 6px;">
            <i class="bi bi-person-plus me-1"></i> Add User
        </a>
    </div>

    <!-- Stats summary -->
    <div class="row g-3 mb-4">
        <div class="col-6 col-md-3">
            <div class="card border-0" style="background: #fff; border: 1px solid #e2e8f0 !important; border-radius: 8px;">
                <div class="card-body p-3">
                    <div class="text-uppercase text-muted fw-bold mb-1" style="font-size: 0.65rem; letter-spacing: 0.05em;">Total Users</div>
                    <div class="h5 fw-bold mb-0">124</div>
                </div>
            </div>
        </div>
        <div class="col-6 col-md-3">
            <div class="card border-0" style="background: #fff; border: 1px solid #e2e8f0 !important; border-radius: 8px;">
                <div class="card-body p-3">
                    <div class="text-uppercase text-muted fw-bold mb-1" style="font-size: 0.65rem; letter-spacing: 0.05em;">Active Now</div>
                    <div class="h5 fw-bold mb-0 text-success">86</div>
                </div>
            </div>
        </div>
    </div>

    <!-- Filters & Table -->
    <div class="card border-0 shadow-sm" style="background: #fff; border: 1px solid #e2e8f0 !important; border-radius: 8px;">
        <div class="card-header bg-white border-0 py-3">
            <div class="row g-2 align-items-center">
                <div class="col-md-4">
                    <div class="input-group input-group-sm">
                        <span class="input-group-text bg-white border-end-0 text-muted"><i class="bi bi-search"></i></span>
                        <input type="text" class="form-control border-start-0" placeholder="Search by name, email or phone...">
                    </div>
                </div>
                <div class="col-md-auto ms-auto d-flex gap-2">
                    <select class="form-select form-select-sm" style="width: 130px;">
                        <option>All Roles</option>
                        <option>Admin</option>
                        <option>Manager</option>
                        <option>User</option>
                    </select>
                    <select class="form-select form-select-sm" style="width: 130px;">
                        <option>All Status</option>
                        <option>Active</option>
                        <option>Inactive</option>
                    </select>
                    <button class="btn btn-sm btn-outline-secondary"><i class="bi bi-filter"></i></button>
                </div>
            </div>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table align-middle mb-0" style="border-top: 1px solid #f1f5f9;">
                    <thead style="background: #f8fafc;">
                        <tr>
                            <th class="px-4" style="font-size: 0.7rem; font-weight: 600; text-transform: uppercase; color: #64748b;">Member</th>
                            <th style="font-size: 0.7rem; font-weight: 600; text-transform: uppercase; color: #64748b;">Role & Type</th>
                            <th style="font-size: 0.7rem; font-weight: 600; text-transform: uppercase; color: #64748b;">Contact Info</th>
                            <th style="font-size: 0.7rem; font-weight: 600; text-transform: uppercase; color: #64748b;">Status</th>
                            <th class="text-end px-4"></th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($users as $user)
                            {{-- Placeholder for actual data loops --}}
                        @empty
                            <tr>
                                <td colspan="5" class="py-5 text-center text-muted">
                                    <i class="bi bi-people mb-2 d-block" style="font-size: 2rem; opacity: 0.3;"></i>
                                    <div style="font-size: 0.875rem;">No user records found matching your criteria.</div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        <div class="card-footer bg-white border-0 py-3">
            <div class="d-flex align-items-center justify-content-between">
                <div class="text-muted" style="font-size: 0.75rem;">Showing 1 - 2 of 2 entries</div>
                <nav>
                    <ul class="pagination pagination-sm mb-0">
                        <li class="page-item disabled"><a class="page-link" href="#"><i class="bi bi-chevron-left"></i></a></li>
                        <li class="page-item active"><a class="page-link" href="#">1</a></li>
                        <li class="page-item disabled"><a class="page-link" href="#"><i class="bi bi-chevron-right"></i></a></li>
                    </ul>
                </nav>
            </div>
        </div>
    </div>
</div>