<?php

namespace App\Livewire;

use App\Models\Task;
use App\Models\TaskStatus;
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
        $projectQuery = \App\Models\Project::query();
        
        // If no project selected, use first one or show empty
        if (!$this->selectedProjectId) {
            $this->selectedProjectId = \App\Models\Project::first()->id ?? null;
        }

        $selectedProject = \App\Models\Project::find($this->selectedProjectId);

        // Stats for selected project
        $tasks = \App\Models\Task::where('project_id', $this->selectedProjectId);
        $totalTasks = (clone $tasks)->count();
        
        $completedCount = (clone $tasks)->whereHas('statusRecord', function($q) {
            $q->where('name', 'Completed');
        })->count();

        $inProgressCount = (clone $tasks)->whereHas('statusRecord', function($q) {
            $q->where('name', 'In Progress');
        })->count();

        $todoCount = (clone $tasks)->whereHas('statusRecord', function($q) {
            $q->where('name', 'To Do');
        })->count();

        // Project Health (Overdue)
        $overdueTasks = (clone $tasks)->where('due_date', '<', now()->format('Y-m-d'))
            ->whereHas('statusRecord', function($q) {
                $q->where('name', '!=', 'Completed');
            })->count();

        // Team distribution
        $team = \App\Models\User::whereHas('projects', function($q) {
            $q->where('project_id', $this->selectedProjectId);
        })->limit(5)->get();

        // Project List Summary
        $projects = \App\Models\Project::withCount(['tasks', 'tasks as completed_tasks_count' => function($q) {
            $q->whereHas('statusRecord', function($sq) { $sq->where('name', 'Completed'); });
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
