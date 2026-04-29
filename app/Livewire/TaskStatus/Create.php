<?php

namespace App\Livewire\TaskStatus;

use App\Models\TaskStatus;
use Livewire\Component;

class Create extends Component
{
    public $name;

    public $color = '#64748b';

    public $order_index = 0;

    public function render()
    {
        return view('livewire.task-status.create');
    }

    public function store()
    {
        $validated = $this->validate([
            'name' => 'required|min:2|unique:task_statuses,name',
            'color' => 'required|string',
        ]);

        TaskStatus::create($validated);

        session()->flash('success', 'Task status created successfully');

        return $this->redirect('/task-statuses', navigate: true);
    }
}