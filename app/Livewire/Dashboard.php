<?php

namespace App\Livewire;

use App\Models\Task;
use App\Models\Project;
use App\Models\User;
use App\UserType;
use Livewire\Component;

class Dashboard extends Component
{
    public function render()
    {
        // Overall task counts
        $totalTasks     = Task::count();
        $pendingTasks   = Task::whereHas('statusRecord', fn($q) => $q->where('name', 'To Do'))->count();
        $inProgressTasks = Task::whereHas('statusRecord', fn($q) => $q->where('name', 'In Progress'))->count();
        $completedTasks = Task::completed()->count();
        $overdueTasks   = Task::where('due_date', '<', now()->format('Y-m-d'))
                              ->notCompleted()
                              ->count();

        // People
        $totalAgents  = User::where('type', UserType::Agent)->count();
        $totalClients = User::where('type', UserType::Client)->count();

        // Projects
        $totalProjects = Project::count();

        // Recent tasks with status + assignee
        $recentTasks = Task::with(['statusRecord', 'assignee', 'project'])
            ->latest()
            ->limit(8)
            ->get();

        // Projects list
        $projects = Project::withCount(['tasks', 'tasks as completed_tasks_count' => fn($q) => $q->completed()])
            ->latest()
            ->limit(5)
            ->get();

        return view('livewire.dashboard', compact(
            'totalTasks', 'pendingTasks', 'inProgressTasks', 'completedTasks',
            'overdueTasks', 'totalAgents', 'totalClients', 'totalProjects',
            'recentTasks', 'projects'
        ));
    }
}
