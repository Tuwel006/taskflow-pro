<?php

namespace App\Livewire\TaskStatus;

use App\Models\TaskStatus;
use Livewire\Component;

class Edit extends Component
{
    public $id;

    public $name;

    public $color;

    public $order_index;

    public function mount($id)
    {
        $status = TaskStatus::find($id);
        $this->id = $status->id;
        $this->name = $status->name;
        $this->color = $status->color;
        $this->order_index = $status->order_index;
    }

    public function render()
    {
        return view('livewire.task-status.edit');
    }

    public function update()
    {
        $validated = $this->validate([
            'name' => 'required|min:2|unique:task_statuses,name,' . $this->id,
            'color' => 'required|string',
        ]);

        $status = TaskStatus::find($this->id);
        $status->update($validated);

        session()->flash('message', 'Task status updated successfully');

        return $this->redirect('/task-statuses', navigate: true);
    }
}