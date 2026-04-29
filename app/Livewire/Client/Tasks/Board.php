<?php

namespace App\Livewire\Client\Tasks;

use App\Models\Task;
use App\Models\Project;
use Livewire\Component;
use Livewire\WithPagination;

class Board extends Component
{
    use WithPagination;

    protected $paginationTheme = 'bootstrap';

    public $search = '';
    public $selectedProject = '';

    public function mount()
    {
        $this->selectedProject = request()->query('project', session('selected_project_id', ''));
        
        $clientProjectIds = auth()->user()->projects()->pluck('projects.id')->toArray();

        if (!$this->selectedProject || !in_array($this->selectedProject, $clientProjectIds)) {
            $firstProject = auth()->user()->projects()->where('is_active', true)->first();
            if ($firstProject) {
                $this->selectedProject = (string)$firstProject->id;
                session(['selected_project_id' => $this->selectedProject]);
            } else {
                $this->selectedProject = '';
            }
        }
    }

    public function updatedSelectedProject($value)
    {
        $clientProjectIds = auth()->user()->projects()->pluck('projects.id')->toArray();
        if (!in_array($value, $clientProjectIds)) {
            $this->selectedProject = '';
            return;
        }

        session(['selected_project_id' => $value]);
        $this->resetPage();
    }

    public function render()
    {
        $projects = auth()->user()->projects()->where('is_active', true)->get();

        $tasks = Task::with(['assignee', 'statusRecord', 'project', 'type'])
            ->whereIn('project_id', $projects->pluck('id'))
            ->when($this->selectedProject, function ($query) {
                $query->where('project_id', $this->selectedProject);
            })
            ->when($this->search, function ($query) {
                $query->where(function ($q) {
                    $q->where('title', 'like', '%'.$this->search.'%')
                        ->orWhere('description', 'like', '%'.$this->search.'%');
                });
            })
            ->latest()
            ->paginate(15);

        return view('livewire.client.tasks.board', compact('tasks', 'projects'))
            ->layout('components.layouts.client');
    }
}
