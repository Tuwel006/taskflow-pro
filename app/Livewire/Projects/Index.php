<?php

namespace App\Livewire\Projects;

use App\Models\Project;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;

    protected $paginationTheme = 'bootstrap';

    public $status = true;

    public $search;

    public $itemPerPage = 10;

    public function render()
    {
        $projects = Project::where('is_active', $this->status)
            ->where('name', 'like', "%{$this->search}%")
            ->paginate($this->itemPerPage);

        return view('livewire.projects.index', compact('projects'));
    }
}
