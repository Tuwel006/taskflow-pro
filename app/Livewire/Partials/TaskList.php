<?php

namespace App\Livewire\Partials;

use Livewire\Component;
use App\Models\Task;

class TaskList extends Component
{
    public $tasks;
    public $scope = 'all'; // Keep scope for UI conditional logic like the dropdown

    public function render()
    {
        return view('livewire.partials.task-list');
    }

    public function updateStatus($taskId, $newStatus)
    {
        $task = Task::findOrFail($taskId);
        $task->status = $newStatus;
        $task->save();
        
        session()->flash('success', 'Status updated successfully!');
    }
}
