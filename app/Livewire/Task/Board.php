<?php

namespace App\Livewire\Task;

use App\Models\Stage;
use App\Models\Task;
use App\Models\TaskStatus;
use App\Models\Project;
use Livewire\Component;
use Livewire\WithPagination;

class Board extends Component
{
    use WithPagination;

    protected $paginationTheme = 'bootstrap';

    public $search = '';

    public $status = '';

    public $priority = '';

    public $selectedProject = '';

    public $viewMode = 'kanban'; // 'list' or 'kanban'

    public function mount()
    {
        $firstProject = Project::where('is_active', true)->first();
        if ($firstProject) {
            $this->selectedProject = $firstProject->id;
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

    public function updatingSelectedProject()
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
        $projects = Project::where('is_active', true)->get();

        if ($this->viewMode === 'list') {
            $tasks = Task::with(['assignee', 'creator', 'statusRecord', 'project', 'type'])
                ->when($this->selectedProject, function ($query) {
                    $query->where('project_id', $this->selectedProject);
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

            return view('livewire.task.board', compact('tasks', 'projects'));
        }

        // Kanban Mode
        $stages = Stage::where('project_id', $this->selectedProject)
            ->with(['status', 'tasks' => function ($query) {
                $query->when($this->selectedProject, function ($q) {
                    $q->where('project_id', $this->selectedProject);
                })
                ->with(['assignee', 'creator', 'project', 'type', 'statusRecord'])
                ->when($this->search, function ($q) {
                    $q->where(function ($sq) {
                        $sq->where('title', 'like', '%'.$this->search.'%')
                           ->orWhere('description', 'like', '%'.$this->search.'%');
                    });
                })
                ->orderBy('created_at', 'desc');
            }])->orderBy('position')->get();

        return view('livewire.task.board', compact('stages', 'projects'));
    }

    public function changeStatus($taskId, $statusId)
    {
        $task = Task::findOrFail($taskId);
        $status = TaskStatus::findOrFail($statusId);

        if (!$task->canTransitionTo($statusId)) {
            $this->dispatch('toast', [
                'type'    => 'danger',
                'message' => 'Transition to ' . $status->name . ' is not allowed.',
            ]);
            return;
        }

        $task->update(['task_status_id' => $statusId]);

        $this->dispatch('toast', [
            'type'    => 'success',
            'message' => 'Task updated to ' . $status->name . '.',
        ]);

        $this->dispatch('taskUpdated');
    }

    public function updateStatus($taskId, $stageId)
    {
        // stageId comes from the kanban drop-zone data-stage-id attribute.
        // We resolve the corresponding task_status_id from the Stage.
        $stage = Stage::find($stageId);
        if (! $stage) {
            return;
        }

        $task = Task::findOrFail($taskId);

        // Check if transition is allowed by workflow
        if (!$task->canTransitionTo($stage->status_id)) {
            $this->dispatch('toast', [
                'type'    => 'danger',
                'message' => 'Transition to ' . ($stage->status->name ?? 'new status') . ' is not allowed.',
            ]);
            return;
        }

        $task->update(['task_status_id' => $stage->status_id]);

        $this->dispatch('toast', [
            'type'    => 'success',
            'message' => 'Task moved to ' . ($stage->status->name ?? 'new stage') . '.',
        ]);

        $this->dispatch('taskUpdated');
    }
}
