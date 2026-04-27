<?php

namespace App\Livewire\MyTasks;

use App\Models\Task;
use App\Models\TaskStatus;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;

    protected $paginationTheme = 'bootstrap';

    public $search = '';

    public $status = '';

    public $priority = '';

    public $viewMode = 'kanban'; // 'list' or 'kanban'

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function updatingStatus()
    {
        $this->resetPage();
    }

    public function updatingPriority()
    {
        $this->resetPage();
    }

    protected $listeners = [
        'taskMoved' => 'updateStatus',
    ];

    public function setViewMode($mode)
    {
        $this->viewMode = $mode;
    }

    public function render()
    {
        if ($this->viewMode === 'list') {
            $tasks = Task::with(['assignee', 'creator', 'statusRecord'])
                ->where('assigned_to', auth()->id())
                ->when($this->search, function ($query) {
                    $query->where(function ($q) {
                        $q->where('title', 'like', '%'.$this->search.'%')
                            ->orWhere('description', 'like', '%'.$this->search.'%');
                    });
                })
                ->when($this->status && $this->status !== '', function ($query) {
                    $query->whereHas('statusRecord', function ($q) {
                        $q->where('name', $this->status);
                    });
                })
                ->when($this->priority && $this->priority !== '', function ($query) {
                    $query->where('priority', $this->priority);
                })
                ->latest()
                ->paginate(10);

            return view('livewire.my-tasks.index', compact('tasks'));
        }

        // Kanban Mode
        $statuses = TaskStatus::with(['tasks' => function ($query) {
            $query->where('assigned_to', auth()->id())
                ->with('assignee')
                ->orderBy('priority', 'desc');
        }])->orderBy('order_index')->get();

        return view('livewire.my-tasks.index', compact('statuses'));
    }

    public function updateStatus($taskId, $statusId)
    {
        $task = Task::findOrFail($taskId);
        $task->update(['task_status_id' => $statusId]);

        $this->dispatch('notification', [
            'type' => 'success',
            'message' => 'Task status updated.',
        ]);

        $this->dispatch('taskUpdated');
    }
}
