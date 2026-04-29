<?php

namespace App\Livewire\Task;

use App\Constants\TaskPriority;
use App\Events\TaskCreated;
use App\Models\Stage;
use App\Models\Task;
use App\Models\TaskStatus;
use App\Models\TaskType;
use App\Models\Teams;
use App\Models\User;
use Livewire\Component;

class Create extends Component
{
    public $title;

    public $description;

    public $status_id;

    public $task_type_id;

    public $priority;
    public $priorities;

    public $due_date;

    public $assigned_to;

    public $users;
    public $curr_team;

    public $statuses;

    public $taskTypes;

    public $team_id;

    public $inModal = false;

    public function mount($teamId)
    {
        $this->team_id = $teamId;
        $this->users = User::whereHas('teams', function ($query) {
            $query->where('team_id', $this->team_id)->where('is_active', true)->where('type', 1);
        })->get();
        $this->statuses = Stage::with('status')
            ->where('team_id', $this->team_id)
            ->orderBy('position')
            ->get()
            ->pluck('status')
            ->filter()
            ->values();
        $this->taskTypes = TaskType::where('is_active', true)->get();
        $this->priorities = TaskPriority::all();

        $this->status_id = $this->statuses->first()->id ?? null;
        $this->task_type_id = $this->taskTypes->first()->id ?? null;
        $this->priority = TaskPriority::MEDIUM;
        $this->due_date = now()->format('Y-m-d');
        $this->curr_team = Teams::where('id', $this->team_id)->first();
        // dd($this->curr_team->toJson(JSON_PRETTY_PRINT));
    }
    
    public function render()
    {
        return view('livewire.task.create');
    }

    public function store()
    {
        $this->validate([
            'title' => 'required|min:3',
            'description' => 'nullable',
            'status_id' => 'required|exists:task_statuses,id',
            'task_type_id' => 'required|exists:tasktypes,id',
            'priority' => 'required',
            'due_date' => 'required|date',
            'assigned_to' => 'required|exists:users,id',
        ]);

        $task = Task::create([
            'title' => $this->title,
            'description' => $this->description,
            'task_status_id' => $this->status_id,
            'task_type_id' => $this->task_type_id,
            'priority' => $this->priority,
            'team_id' => $this->team_id,
            'due_date' => $this->due_date,
            'assigned_to' => $this->assigned_to,
            'created_by' => auth()->id(),
        ]);

        event(new TaskCreated($task));

        session()->flash('message', 'Task created successfully');

        $this->dispatch('task-created');
        $this->dispatch('close-modal', name: 'create-task');

        if (! $this->inModal) {
            return $this->redirect('/tasks', navigate: true);
        }

        $this->reset(['title', 'description', 'due_date', 'assigned_to']);
    }
}
