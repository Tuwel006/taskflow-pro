<?php

namespace App\Livewire\Partials;

use Livewire\Component;
use App\Models\Task;

class TaskList extends Component
{
    public $scope = 'all'; // 'all' or 'my'

    public function render()
    {
        $query = Task::with(['assignee', 'creator']);

        if ($this->scope === 'my') {
            $query->where('assigned_to', auth()->id());
        }

        $tasks = $query->latest()->get();

        return view('livewire.partials.task-list', compact('tasks'));
    }

    public function updateStatus($taskId, $newStatus)
    {
        $task = Task::findOrFail($taskId);
        $task->status = $newStatus;
        $task->save();
        
        session()->flash('success', 'Status updated successfully!');
    }
}
