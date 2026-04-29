<?php

namespace App\Livewire\Task;

use App\Models\Task;
use App\Models\TaskStatus;
use App\Models\Teams;
use Livewire\Component;
use Livewire\WithPagination;

class Board extends Component
{
    use WithPagination;

    protected $paginationTheme = 'bootstrap';

    public $search = '';

    public $status = '';

    public $priority = '';

    public $selectedTeam = '';

    public $viewMode = 'list'; // 'list' or 'kanban'

    public function mount()
    {
        $firstTeam = Teams::where('is_active', true)->first();
        if ($firstTeam) {
            $this->selectedTeam = $firstTeam->id;
        }
    }

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

    public function updatingSelectedTeam()
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
        $teams = Teams::where('is_active', true)->get();

        if ($this->viewMode === 'list') {
            $tasks = Task::with(['assignee', 'creator', 'statusRecord', 'team'])
                ->when($this->selectedTeam, function ($query) {
                    $query->where('team_id', $this->selectedTeam);
                })
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

            return view('livewire.task.board', compact('tasks', 'teams'));
        }

        // Kanban Mode
        $statuses = TaskStatus::with(['tasks' => function ($query) {
            $query->when($this->selectedTeam, function ($q) {
                $q->where('team_id', $this->selectedTeam);
            })
            ->with('assignee', 'team')
            ->orderBy('priority', 'desc');
        }])->orderBy('order_index')->get();

        return view('livewire.task.board', compact('statuses', 'teams'));
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
