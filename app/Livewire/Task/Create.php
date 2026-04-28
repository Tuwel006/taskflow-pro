<?php

namespace App\Livewire\Task;

use App\Events\TaskCreated;
use App\Models\Task;
use App\Models\TaskStatus;
use App\Models\TaskType;
use App\Models\User;
use Livewire\Component;

class Create extends Component
{
    public $title;

    public $description;

    public $status_id;

    public $task_type_id;

    public $priority = 'Medium';

    public $due_date;

    public $assigned_to;

    public $users;

    public $statuses;

    public $taskTypes;

    public $inModal = false;

    public function mount()
    {
        $this->users = User::all();
        $this->statuses = TaskStatus::orderBy('order_index')->get();
        $this->taskTypes = TaskType::where('is_active', true)->get();

        $this->status_id = $this->statuses->first()->id ?? null;
        $this->task_type_id = $this->taskTypes->first()->id ?? null;
        $this->due_date = now()->format('Y-m-d');
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
