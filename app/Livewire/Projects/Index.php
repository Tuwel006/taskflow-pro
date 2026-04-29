<?php

namespace App\Livewire\Projects;

use App\Models\Project;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;

    protected $paginationTheme = 'bootstrap';

    public $status = '1';

    public $search;

    public $itemPerPage = 10;

    public function render()
    {
        $projects = Project::when($this->status !== '2', function($query) {
                $query->where('is_active', (bool)$this->status);
            })
            ->where('name', 'like', "%{$this->search}%")
            ->paginate($this->itemPerPage);

        return view('livewire.projects.index', compact('projects'));
    }

    public function delete($id)
    {
        $project = Project::findOrFail($id);
        
        // Prevent deletion if project has tasks? Maybe just delete.
        $project->delete();
        
        $this->dispatch('toast', ['message' => 'Project deleted successfully.', 'type' => 'success']);
    }
}
