<?php

namespace App\Livewire\Task;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Task;

class Index extends Component
{
    use WithPagination;

    protected $paginationTheme = 'bootstrap';

    public $search = '';
    public $status = '';
    public $priority = '';

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

    public function render()
    {
        $tasks = Task::with(['assignee', 'creator', 'statusRecord'])
            ->when($this->search, function($query) {
                $query->where(function($q) {
                    $q->where('title', 'like', '%'.$this->search.'%')
                      ->orWhere('description', 'like', '%'.$this->search.'%');
                });
            })
            ->when($this->status && $this->status !== '', function($query) {
                $query->whereHas('statusRecord', function($q) {
                    $q->where('name', $this->status);
                });
            })
            ->when($this->priority && $this->priority !== '', function($query) {
                $query->where('priority', $this->priority);
            })
            ->latest()
            ->paginate(10);

        return view('livewire.task.index', compact('tasks'));
    }

    public function updateStatus($taskId, $statusId)
    {
        $task = Task::findOrFail($taskId);
        $task->update(['task_status_id' => $statusId]);
        
        $this->dispatch('notification', [
            'type' => 'success',
            'message' => 'Task status updated.'
        ]);
    }
}
