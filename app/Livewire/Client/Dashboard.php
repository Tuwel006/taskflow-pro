<?php

namespace App\Livewire\Client;

use App\Models\Project;
use App\Models\Task;
use Livewire\Component;

class Dashboard extends Component
{
    public $selectedProjectId;

    public function mount()
    {
        $this->selectedProjectId = session('selected_project_id');
        
        // Ensure client only sees projects they are assigned to
        $clientProjects = auth()->user()->projects;
        
        if (!$this->selectedProjectId && $clientProjects->count() > 0) {
            $this->selectedProjectId = $clientProjects->first()->id;
            session(['selected_project_id' => $this->selectedProjectId]);
        }
    }

    public function render()
    {
        $clientProjects = auth()->user()->projects()->withCount(['tasks', 'tasks as completed_tasks' => function($q) {
            $q->whereHas('statusRecord', function($sq) { $sq->where('name', 'Completed'); });
        }])->get();

        $selectedProject = $clientProjects->firstWhere('id', $this->selectedProjectId);

        $tasks = Task::where('project_id', $this->selectedProjectId);
        $totalTasks = (clone $tasks)->count();
        $completedTasks = (clone $tasks)->whereHas('statusRecord', function($q) {
            $q->where('name', 'Completed');
        })->count();

        $recentUpdates = (clone $tasks)->with(['statusRecord', 'assignee'])
            ->latest('updated_at')
            ->limit(5)
            ->get();

        return view('livewire.client.dashboard', [
            'projects' => $clientProjects,
            'selectedProject' => $selectedProject,
            'totalTasks' => $totalTasks,
            'completedTasks' => $completedTasks,
            'recentUpdates' => $recentUpdates,
        ])->layout('components.layouts.client');
    }
}
