<div class="container-fluid py-3 min-vh-100 bg-light">
    {{-- Header Section (Compact) --}}
    <div class="row mb-3">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center bg-white px-3 py-2 rounded-3 shadow-sm border border-light">
                <div class="d-flex align-items-center gap-2">
                    <div class="bg-primary bg-opacity-10 p-1 rounded-2">
                        <i class="bi bi-diagram-3 text-primary fs-6"></i>
                    </div>
                    <div>
                        <h6 class="fw-bold text-dark mb-0 small">Workflow Designer</h6>
                        <p class="text-muted mb-0" style="font-size: 0.65rem;">Optimize your project movement</p>
                    </div>
                </div>
                <div class="d-flex align-items-center gap-2">
                    <label class="fw-bold text-muted text-uppercase mb-0" style="font-size: 0.6rem; letter-spacing: 0.5px;">Project</label>
                    <select wire:model.live="selectedProjectId" class="form-select form-select-sm border-0 bg-light shadow-none fw-semibold text-dark py-1" style="min-width: 150px; border-radius: 6px; font-size: 0.75rem;">
                        @foreach($projects as $project)
                            <option value="{{ $project->id }}">{{ $project->name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
        </div>
    </div>

    {{-- Tabs Section (Refined & Compact) --}}
    <div class="row mb-3">
        <div class="col-12">
            <div class="bg-white rounded-3 shadow-sm p-1 d-flex gap-1 border border-light">
                <button wire:click="setTab('stages')"
                    class="btn flex-grow-1 py-1 fw-bold rounded-2 transition small {{ $tab === 'stages' ? 'btn-dark' : 'btn-light text-muted' }}" style="font-size: 0.75rem;">
                    <i class="bi bi-layers-half me-1"></i>
                    Stages
                </button>
                <button wire:click="setTab('flow')"
                    class="btn flex-grow-1 py-1 fw-bold rounded-2 transition small {{ $tab === 'flow' ? 'btn-dark' : 'btn-light text-muted' }}" style="font-size: 0.75rem;">
                    <i class="bi bi-shuffle me-1"></i>
                    Flows
                </button>
            </div>
        </div>
    </div>

    @if ($tab === 'stages')
        {{-- Stages Tab Content (Refined & In-Page CRUD) --}}
        <div class="row g-3">
            <div class="col-lg-8">
                <div class="card border-0 rounded-3 shadow-sm border-top border-3 border-primary h-100">
                    <div class="card-header bg-white border-bottom px-3 py-2 d-flex justify-content-between align-items-center">
                        <h6 class="mb-0 fw-bold small d-flex align-items-center gap-2">
                            <i class="bi bi-layers-half text-primary"></i>
                            Column Configuration
                        </h6>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-hover align-middle mb-0" style="font-size: 0.75rem;">
                                <thead class="bg-light text-muted small text-uppercase fw-bold">
                                    <tr>
                                        <th class="px-3 py-2 border-0" style="font-size: 0.65rem;">Status</th>
                                        <th class="px-3 py-2 border-0" style="font-size: 0.65rem;">Position</th>
                                        <th class="px-3 py-2 border-0 text-end" style="font-size: 0.65rem;">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($stages as $stage)
                                        <tr class="{{ $editingStageId == $stage->id ? 'bg-primary bg-opacity-10' : '' }}">
                                            <td class="px-3 py-2">
                                                <div class="d-flex align-items-center gap-2">
                                                    <span class="dot" style="background-color: {{ $stage->status->color ?? '#64748b' }}; width: 6px; height: 6px; border-radius: 50%;"></span>
                                                    <span class="fw-semibold text-dark">{{ $stage->status->name }}</span>
                                                </div>
                                            </td>
                                            <td class="px-3 py-2">
                                                <span class="badge bg-light text-muted border-0 fw-bold" style="font-size: 0.65rem; padding: 2px 6px;">
                                                    Pos: {{ $stage->position }}
                                                </span>
                                            </td>
                                            <td class="px-3 py-2 text-end">
                                                <div class="d-flex justify-content-end gap-1">
                                                    <button wire:click="editStage({{ $stage->id }})"
                                                        class="btn btn-xs btn-light border-0 rounded-2 p-1 text-primary shadow-none transition hover-lift">
                                                        <i class="bi bi-pencil-square" style="font-size: 0.85rem;"></i>
                                                    </button>
                                                    <button wire:click="deleteStage({{ $stage->id }})"
                                                        wire:confirm="Remove this stage?"
                                                        class="btn btn-xs btn-light border-0 rounded-2 p-1 text-danger shadow-none transition hover-lift">
                                                        <i class="bi bi-trash-fill" style="font-size: 0.85rem;"></i>
                                                    </button>
                                                </div>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="3" class="text-center py-5">
                                                <div class="text-muted opacity-50">
                                                    <i class="bi bi-layers fs-2 mb-2 d-block"></i>
                                                    <p class="small mb-0">No stages defined.</p>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-4">
                <div class="card border-0 rounded-3 shadow-sm border-start border-4 {{ $editingStageId ? 'border-info' : 'border-primary' }}">
                    <div class="card-header bg-white border-bottom px-3 py-2 d-flex justify-content-between align-items-center">
                        <h6 class="mb-0 fw-bold small d-flex align-items-center gap-2">
                            <i class="bi {{ $editingStageId ? 'bi-pencil-square text-info' : 'bi-plus-circle-fill text-primary' }}"></i>
                            {{ $editingStageId ? 'Edit Stage' : 'Add Stage' }}
                        </h6>
                        @if($editingStageId)
                            <button wire:click="resetStageForm" class="btn btn-xs btn-light text-muted p-1">
                                <i class="bi bi-x-lg"></i>
                            </button>
                        @endif
                    </div>
                    <div class="card-body p-3">
                        @if(session('success') && $tab === 'stages')
                            <div class="alert alert-success border-0 rounded-2 small py-1 px-2 mb-3" style="font-size: 0.65rem;">
                                <i class="bi bi-check-circle me-1"></i> {{ session('success') }}
                            </div>
                        @endif
                        @if(session('error') && $tab === 'stages')
                            <div class="alert alert-danger border-0 rounded-2 small py-1 px-2 mb-3" style="font-size: 0.65rem;">
                                <i class="bi bi-exclamation-circle me-1"></i> {{ session('error') }}
                            </div>
                        @endif

                        <form wire:submit.prevent="saveStage">
                            <div class="mb-3">
                                <label class="form-label text-muted fw-bold text-uppercase mb-1" style="font-size: 0.6rem;">Status</label>
                                <select wire:model="stageStatusId" class="form-select form-select-sm compact-select">
                                    <option value="">Select Status</option>
                                    @php $allStatuses = \App\Models\TaskStatus::all(); @endphp
                                    @foreach($allStatuses as $status)
                                        <option value="{{ $status->id }}">{{ $status->name }}</option>
                                    @endforeach
                                </select>
                                @error('stageStatusId') <span class="text-danger x-small mt-1 d-block" style="font-size: 0.6rem;">{{ $message }}</span> @enderror
                            </div>

                            <div class="mb-3">
                                <label class="form-label text-muted fw-bold text-uppercase mb-1" style="font-size: 0.6rem;">Order Position</label>
                                <input type="number" wire:model="stagePosition" class="form-control form-control-sm compact-select" placeholder="e.g. 0, 1, 2...">
                                @error('stagePosition') <span class="text-danger x-small mt-1 d-block" style="font-size: 0.6rem;">{{ $message }}</span> @enderror
                            </div>

                            <button type="submit" class="btn {{ $editingStageId ? 'btn-info text-white' : 'btn-primary' }} btn-sm w-100 fw-bold rounded-2 shadow-sm py-2 transition" style="font-size: 0.75rem;">
                                {{ $editingStageId ? 'Update Stage' : 'Save Stage' }}
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    @else
        {{-- Flow Tab Content (Compact & Beautiful) --}}
        <div class="row g-3">
            <div class="col-lg-8">
                <div class="card border-0 rounded-3 shadow-sm border-top border-3 border-dark h-100">
                    <div class="card-header bg-white border-bottom px-3 py-2">
                        <h6 class="mb-0 fw-bold small d-flex align-items-center gap-2">
                            <i class="bi bi-shuffle text-dark"></i>
                            Allowed Movements
                        </h6>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-hover align-middle mb-0" style="font-size: 0.75rem;">
                                <thead class="bg-light text-muted text-uppercase fw-bold">
                                    <tr>
                                        <th class="px-3 py-2 border-0" style="font-size: 0.65rem;">Origin</th>
                                        <th class="px-3 py-2 border-0 text-center" style="width: 30px;"></th>
                                        <th class="px-3 py-2 border-0" style="font-size: 0.65rem;">Target</th>
                                        <th class="px-3 py-2 border-0 text-end" style="font-size: 0.65rem;"></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($workflows as $workflow)
                                        <tr>
                                            <td class="px-3 py-2">
                                                <div class="d-inline-flex align-items-center gap-1 bg-white border rounded-pill px-2 py-1 shadow-sm" style="border-left: 3px solid {{ $workflow->fromStatus->color ?? '#64748b' }} !important;">
                                                    <span class="fw-bold" style="font-size: 0.7rem; color: #1e293b;">{{ $workflow->fromStatus->name }}</span>
                                                </div>
                                            </td>
                                            <td class="px-3 py-2 text-center text-muted opacity-50">
                                                <i class="bi bi-chevron-right small"></i>
                                            </td>
                                            <td class="px-3 py-2">
                                                <div class="d-inline-flex align-items-center gap-1 bg-white border rounded-pill px-2 py-1 shadow-sm" style="border-left: 3px solid {{ $workflow->toStatus->color ?? '#64748b' }} !important;">
                                                    <span class="fw-bold" style="font-size: 0.7rem; color: #1e293b;">{{ $workflow->toStatus->name }}</span>
                                                </div>
                                            </td>
                                            <td class="px-3 py-2 text-end">
                                                <button wire:click="deleteTransition({{ $workflow->id }})"
                                                    class="btn btn-xs btn-light border-0 rounded-2 p-1 text-danger shadow-none transition hover-lift">
                                                    <i class="bi bi-x-circle-fill" style="font-size: 0.85rem;"></i>
                                                </button>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="4" class="text-center py-4">
                                                <p class="text-muted small mb-0 opacity-50">No flows defined.</p>
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-4">
                <div class="card border-0 rounded-3 shadow-sm border-start border-4 border-primary">
                    <div class="card-header bg-white border-bottom px-3 py-2">
                        <h6 class="mb-0 fw-bold small d-flex align-items-center gap-2">
                            <i class="bi bi-plus-circle-fill text-primary"></i>
                            New Rule
                        </h6>
                    </div>
                    <div class="card-body p-3">
                        @if (session('success'))
                            <div class="alert alert-success border-0 rounded-2 small py-1 px-2 mb-2" style="font-size: 0.65rem;">
                                <i class="bi bi-check-circle me-1"></i> {{ session('success') }}
                            </div>
                        @endif

                        <form wire:submit.prevent="addTransition">
                            <div class="mb-2">
                                <label class="form-label text-muted fw-bold text-uppercase mb-1" style="font-size: 0.6rem;">Source Status</label>
                                <select wire:model="fromStatusId" class="form-select form-select-sm compact-select">
                                    <option value="">Choose status</option>
                                    @foreach ($availableStatuses as $status)
                                        <option value="{{ $status->id }}">{{ $status->name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="text-center my-1">
                                <i class="bi bi-arrow-down-short text-muted opacity-50"></i>
                            </div>

                            <div class="mb-3">
                                <label class="form-label text-muted fw-bold text-uppercase mb-1" style="font-size: 0.6rem;">Target Status</label>
                                <select wire:model="toStatusId" class="form-select form-select-sm compact-select">
                                    <option value="">Choose status</option>
                                    @foreach ($availableStatuses as $status)
                                        <option value="{{ $status->id }}">{{ $status->name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <button type="submit" class="btn btn-primary btn-sm w-100 fw-bold rounded-2 shadow-sm py-2" style="font-size: 0.75rem;">
                                Save Flow Rule
                            </button>
                        </form>
                    </div>
                </div>

                {{-- Hint Card --}}
                <div class="card border-0 rounded-3 shadow-sm mt-3 bg-dark bg-opacity-10">
                    <div class="card-body p-3">
                        <h6 class="fw-bold mb-2 small d-flex align-items-center gap-2">
                            <i class="bi bi-info-circle text-primary"></i>
                            System Rules
                        </h6>
                        <p class="mb-0 text-muted" style="font-size: 0.65rem; line-height: 1.4;">
                            Rules defined here are strictly enforced on the Kanban board. Unauthorized moves will be automatically blocked with a warning.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    @endif

    <style>
        .transition { transition: all 0.2s cubic-bezier(0.4, 0, 0.2, 1); }
        .hover-lift:hover { transform: translateY(-2px); }
        .hover-scale:hover { transform: scale(1.1); }
        .btn-xs { padding: 0.15rem 0.4rem; font-size: 0.7rem; }
        .compact-select {
            font-size: 0.75rem;
            border-radius: 6px;
            background-color: #f8fafc;
            border-color: #e2e8f0;
        }
        .compact-select:focus {
            border-color: #3b82f6;
            box-shadow: 0 0 0 2px rgba(59, 130, 246, 0.1);
        }
        .dot { display: inline-block; }
    </style>
</div>
