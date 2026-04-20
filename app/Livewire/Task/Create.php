<?php

namespace App\Livewire\Task;

use Livewire\Component;
use App\Models\User;
use App\Models\Task;

class Create extends Component
{
    public $title;
    public $description;
    public $status = 'Pending'; // Default status
    public $priority = 'Medium';
    public $due_date;
    public $assigned_to;
    public $users;
    public $inModal = false;

    public function mount()
    {
        $this->users = User::all();
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
            'status' => 'required',
            'priority' => 'required',
            'due_date' => 'required|date',
            'assigned_to' => 'required|exists:users,id',
        ]);

        Task::create([
            'title' => $this->title,
            'description' => $this->description,
            'status' => $this->status,
            'priority' => $this->priority,
            'due_date' => $this->due_date,
            'assigned_to' => $this->assigned_to,
            'created_by' => auth()->id(),
        ]);

        session()->flash('message', 'Task created successfully');

        return $this->redirect('/tasks', navigate: true);
    }
}
