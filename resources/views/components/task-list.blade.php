<div>
    <x-data-table :items="$tasks" emptyIcon="bi-clipboard-x" emptyText="No tasks found">
        <x-slot name="columns">
            <x-table.th>Task Detail</x-table.th>
            <x-table.th>Assigned To</x-table.th>
            <x-table.th>Priority</x-table.th>
            <x-table.th>Due Date</x-table.th>
            <x-table.th>Status</x-table.th>
        </x-slot>

        @foreach($tasks as $task)
            <x-table.row wire:key="task-{{ $task->id }}">
                <x-table.td>
                    <div>
                        <div class="fw-bold mb-0" style="font-size: 0.8125rem; color: #1e293b;">{{ $task->title }}</div>
                        <div class="text-truncate" style="font-size: 0.7rem; color: #94a3b8; max-width: 250px;">{{ $task->description }}</div>
                    </div>
                </x-table.td>
                <x-table.td>
                    <div class="d-flex align-items-center gap-2">
                        <div class="rounded-circle bg-light d-flex align-items-center justify-content-center fw-bold" style="width: 24px; height: 24px; font-size: 0.65rem; color: #64748b;">
                            {{ strtoupper(substr($task->assignee->name ?? 'U', 0, 1)) }}
                        </div>
                        <span style="font-size: 0.8125rem; color: #475569;">{{ $task->assignee->name ?? 'Unassigned' }}</span>
                    </div>
                </x-table.td>
                <x-table.td>
                    @php
                        $pColor = match($task->priority) {
                            'Urgent' => '#ef4444',
                            'High' => '#f59e0b',
                            'Medium' => '#3b82f6',
                            default => '#94a3b8'
                        };
                    @endphp
                    <span class="d-flex align-items-center gap-1" style="font-size: 0.75rem; font-weight: 600; color: {{ $pColor }};">
                        <i class="bi bi-circle-fill" style="font-size: 0.4rem;"></i>
                        {{ $task->priority }}
                    </span>
                </x-table.td>
                <x-table.td>
                    <span style="font-size: 0.8125rem; color: #475569;">{{ \Carbon\Carbon::parse($task->due_date)->format('M d, Y') }}</span>
                </x-table.td>
                <x-table.td>
                    @php
                        $sColor = match($task->status) {
                            'Completed' => ['bg' => '#ecfdf5', 'text' => '#059669', 'border' => '#10b981'],
                            'In Progress' => ['bg' => '#eff6ff', 'text' => '#2563eb', 'border' => '#3b82f6'],
                            default => ['bg' => '#f8fafc', 'text' => '#64748b', 'border' => '#e2e8f0']
                        };
                    @endphp
                    
                    @if($scope === 'my')
                        <div class="dropdown" wire:key="status-{{ $task->id }}">
                            <button class="btn badge rounded-pill d-flex align-items-center gap-1 border-0 dropdown-toggle" 
                                    type="button" data-bs-toggle="dropdown" data-bs-boundary="viewport"
                                    style="font-size: 0.65rem; background: {{ $sColor['bg'] }}; color: {{ $sColor['text'] }}; border: 1px solid {{ $sColor['border'] }}44 !important;">
                                <span wire:loading.remove wire:target="updateStatus({{ $task->id }}, 'Pending'), updateStatus({{ $task->id }}, 'In Progress'), updateStatus({{ $task->id }}, 'Completed')">
                                    <i class="bi bi-circle-fill me-1" style="font-size: 0.4rem;"></i>
                                    {{ $task->status }}
                                </span>
                                <span wire:loading wire:target="updateStatus">
                                    <span class="spinner-border spinner-border-sm" role="status" style="width: 0.7rem; height: 0.7rem;"></span>
                                </span>
                            </button>
                            <ul class="dropdown-menu shadow-sm border-0" style="font-size: 0.75rem; border-radius: 8px;">
                                <li><button class="dropdown-item py-2" wire:click="updateStatus({{ $task->id }}, 'Pending')"><i class="bi bi-clock me-2 text-muted"></i> Pending</button></li>
                                <li><button class="dropdown-item py-2" wire:click="updateStatus({{ $task->id }}, 'In Progress')"><i class="bi bi-play-circle me-2 text-primary"></i> In Progress</button></li>
                                <li><hr class="dropdown-divider"></li>
                                <li><button class="dropdown-item py-2 text-success" wire:click="updateStatus({{ $task->id }}, 'Completed')"><i class="bi bi-check-circle-fill me-2"></i> Mark Completed</button></li>
                            </ul>
                        </div>
                    @else
                        <span class="badge rounded-pill d-inline-flex align-items-center gap-1" 
                              style="font-size: 0.65rem; background: {{ $sColor['bg'] }}; color: {{ $sColor['text'] }}; border: 1px solid {{ $sColor['border'] }}44 !important;">
                            <i class="bi bi-circle-fill me-1" style="font-size: 0.4rem;"></i>
                            {{ $task->status }}
                        </span>
                    @endif
                </x-table.td>
            </x-table.row>
        @endforeach
    </x-data-table>

</div>
