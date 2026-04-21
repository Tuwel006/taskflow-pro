<?php

namespace App\Livewire\Task;

use Livewire\Component;
use App\Models\User;
use App\Models\Task;

class Create extends Component
{
    public $title;
    public $description;
    public $status_id;
    public $priority = 'Medium';
    public $due_date;
    public $assigned_to;
    public $users;
    public $statuses;
    public $inModal = false;

    public function mount()
    {
        $this->users = User::all();
        $this->statuses = \App\Models\TaskStatus::orderBy('order_index')->get();
        $this->status_id = $this->statuses->first()->id ?? null;
    }

    public function render()
    {
        return view('livewire.task.create');
    }

    public function store()
    {
        // $this->validate([
        //     // 'title' => 'required|min:3',
        //     'description' => 'nullable',
        //     'status_id' => 'required|exists:task_statuses,id',
        //     'priority' => 'required',
        //     'due_date' => 'required|date',
        //     'assigned_to' => 'required|exists:users,id',
        // ]);

        $status = \App\Models\TaskStatus::find($this->status_id);

        $task = Task::create([
            'title' => $this->title,
            'description' => $this->description,
            'task_status_id' => $this->status_id,
            'priority' => $this->priority,
            'due_date' => $this->due_date,
            'assigned_to' => $this->assigned_to,
            'created_by' => auth()->id(),
        ]);

        event(new \App\Events\TaskCreated($task));

        session()->flash('message', 'Task created successfully');

        return $this->redirect('/tasks', navigate: true);
    }
}
