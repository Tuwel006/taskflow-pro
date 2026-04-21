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
                        <x-user-avatar :user="$task->assignee" size="24px" fontsize="0.65rem" />
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
                        $statusRecord = $task->statusRecord;
                        $color = $statusRecord->color ?? '#64748b';
                    @endphp
                    
                    @if($scope === 'my')
                        @php
                            $allStatuses = \App\Models\TaskStatus::orderBy('order_index')->get();
                        @endphp
                        <div class="dropdown" wire:key="status-{{ $task->id }}">
                            <button class="btn badge rounded-pill d-flex align-items-center gap-1 border-0 dropdown-toggle" 
                                    type="button" data-bs-toggle="dropdown" data-bs-boundary="viewport"
                                    style="font-size: 0.65rem; background: {{ $color }}15; color: {{ $color }}; border: 1px solid {{ $color }}44 !important;">
                                <span wire:loading.remove wire:target="updateStatus({{ $task->id }})">
                                    <i class="bi bi-circle-fill me-1" style="font-size: 0.4rem;"></i>
                                    {{ $statusRecord->name ?? 'Unknown' }}
                                </span>
                                <span wire:loading wire:target="updateStatus">
                                    <span class="spinner-border spinner-border-sm" role="status" style="width: 0.7rem; height: 0.7rem;"></span>
                                </span>
                            </button>
                            <ul class="dropdown-menu shadow-sm border-0" style="font-size: 0.75rem; border-radius: 8px;">
                                @foreach($allStatuses as $s)
                                    <li><button class="dropdown-item py-2" wire:click="updateStatus({{ $task->id }}, {{ $s->id }})">
                                        <i class="bi bi-circle-fill me-2" style="color: {{ $s->color }}; font-size: 0.5rem;"></i> {{ $s->name }}
                                    </button></li>
                                @endforeach
                            </ul>
                        </div>
                    @else
                        <span class="badge rounded-pill d-inline-flex align-items-center gap-1" 
                              style="font-size: 0.65rem; background: {{ $color }}15; color: {{ $color }}; border: 1px solid {{ $color }}44 !important;">
                            <i class="bi bi-circle-fill me-1" style="font-size: 0.4rem;"></i>
                            {{ $statusRecord->name ?? 'Unknown' }}
                        </span>
                    @endif
                </x-table.td>
            </x-table.row>
        @endforeach
    </x-data-table>

</div>
