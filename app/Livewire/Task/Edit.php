<?php

namespace App\Livewire\Task;

use App\Constants\TaskPriority;
use App\Models\Task;
use App\Models\TaskStatus;
use App\Models\TaskType;
use App\Models\Project;
use App\Models\User;
use Livewire\Component;

class Edit extends Component
{
    public Task $task;
    public $title;
    public $description;
    public $status_id;
    public $task_type_id;
    public $priority;
    public $due_date;
    public $assigned_to;

    public $users;
    public $statuses;
    public $taskTypes;
    public $priorities;

    public function mount(Task $task)
    {
        $this->task = $task;
        $this->title = $task->title;
        $this->description = $task->description;
        $this->status_id = $task->task_status_id;
        $this->task_type_id = $task->task_type_id;
        $this->priority = $task->priority;
        $this->due_date = $task->due_date ? $task->due_date->format('Y-m-d') : null;
        $this->assigned_to = $task->assigned_to;

        $this->users = User::whereHas('projects', function ($query) {
            $query->where('project_id', $this->task->project_id)->where('is_active', true);
        })->get();

        // Get allowed statuses + current status
        $allowed = $task->getAllowedStatuses();
        $current = TaskStatus::find($this->status_id);
        
        $this->statuses = collect([$current])->merge($allowed)->unique('id');

        $this->taskTypes = TaskType::where('is_active', true)->get();
        $this->priorities = TaskPriority::all();
    }

    public function update()
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

        $this->task->update([
            'title' => $this->title,
            'description' => $this->description,
            'task_status_id' => $this->status_id,
            'task_type_id' => $this->task_type_id,
            'priority' => $this->priority,
            'due_date' => $this->due_date,
            'assigned_to' => $this->assigned_to,
        ]);

        session()->flash('message', 'Task updated successfully');
        return $this->redirect('/tasks', navigate: true);
    }

    public function render()
    {
        return view('livewire.task.edit');
    }
}
