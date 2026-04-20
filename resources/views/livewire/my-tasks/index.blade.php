<div class="container-fluid py-2">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="mb-0 fw-bold" style="color: #0f172a;">Personal Action Items</h4>
            <p class="text-muted mb-0" style="font-size: 0.8125rem;">Tasks specifically assigned to your profile</p>
        </div>
        <div class="d-flex gap-2">
            <div class="bg-white border rounded px-3 py-2 d-flex align-items-center shadow-sm">
                <span class="text-muted small me-2">Personal Efficiency:</span>
                <span class="fw-bold text-success">84%</span>
            </div>
        </div>
    </div>

    <!-- Reusable Task List Component -->
    <livewire:partials.task-list scope="my" />
</div>
