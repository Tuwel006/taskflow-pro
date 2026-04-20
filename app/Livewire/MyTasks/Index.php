<?php

namespace App\Livewire\MyTasks;

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
        $tasks = Task::with(['assignee', 'creator'])
            ->where('assigned_to', auth()->id())
            ->when($this->search, function($query) {
                $query->where(function($q) {
                    $q->where('title', 'like', '%'.$this->search.'%')
                      ->orWhere('description', 'like', '%'.$this->search.'%');
                });
            })
            ->when($this->status && $this->status !== 'All Status', function($query) {
                $query->where('status', $this->status);
            })
            ->when($this->priority && $this->priority !== 'All Priorities', function($query) {
                $query->where('priority', $this->priority);
            })
            ->latest()
            ->paginate(10);

        return view('livewire.my-tasks.index', compact('tasks'));
    }
}
