<?php

namespace App\Livewire;

use App\Models\Task;
use App\Models\Project;
use App\Models\User;
use Livewire\Component;

class Dashboard extends Component
{
    public $selectedProjectId;

    public function mount()
    {
        $this->selectedProjectId = session('selected_project_id');
    }

    public function render()
    {
        // If no project selected, use first one or show empty
        if (!$this->selectedProjectId) {
            $this->selectedProjectId = Project::first()->id ?? null;
        }

        $selectedProject = Project::find($this->selectedProjectId);

        // Stats for selected project using new dynamic completion logic
        $tasks = Task::where('project_id', $this->selectedProjectId);
        $totalTasks = (clone $tasks)->count();
        
        $completedCount = (clone $tasks)->completed()->count();

        // We'll keep In Progress and To Do based on status name for now as they are less project-dependent
        // but could also be mapped to stage positions if needed.
        $inProgressCount = (clone $tasks)->whereHas('statusRecord', function($q) {
            $q->where('name', 'In Progress');
        })->count();

        $todoCount = (clone $tasks)->whereHas('statusRecord', function($q) {
            $q->where('name', 'To Do');
        })->count();

        // Project Health (Overdue): Use notCompleted scope
        $overdueTasks = (clone $tasks)
            ->where('due_date', '<', now()->format('Y-m-d'))
            ->notCompleted()
            ->count();

        // Team distribution
        $team = User::whereHas('projects', function($q) {
            $q->where('project_id', $this->selectedProjectId);
        })->limit(5)->get();

        // Project List Summary with dynamic completion count
        $projects = Project::withCount(['tasks', 'tasks as completed_tasks_count' => function($q) {
            $q->completed();
        }])->limit(3)->get();

        $recentTasks = (clone $tasks)->with(['statusRecord', 'assignee'])
            ->latest()
            ->limit(6)
            ->get();

        return view('livewire.dashboard', [
            'selectedProject' => $selectedProject,
            'totalTasks' => $totalTasks,
            'inProgressCount' => $inProgressCount,
            'completedCount' => $completedCount,
            'todoCount' => $todoCount,
            'overdueTasks' => $overdueTasks,
            'team' => $team,
            'projects' => $projects,
            'recentTasks' => $recentTasks,
        ]);
    }
}
