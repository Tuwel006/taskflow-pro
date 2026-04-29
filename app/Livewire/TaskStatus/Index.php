<?php

namespace App\Livewire\TaskStatus;

use App\Models\TaskStatus;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;

    protected $paginationTheme = 'bootstrap';

    public $search;

    public $itemPerPage = 10;

    public function render()
    {
        $taskStatuses = TaskStatus::where('name', 'like', "%{$this->search}%")
            ->paginate($this->itemPerPage);

        return view('livewire.task-status.index', compact('taskStatuses'));
    }
}