<?php

namespace App\Livewire;

use App\Models\Task;
use App\Models\TaskStatus;
use Livewire\Component;

class Dashboard extends Component
{
    public function render()
    {
        $totalTasks = Task::count();
        $inProgressCount = Task::whereHas('statusRecord', function($q) {
            $q->where('name', 'In Progress');
        })->count();
        $completedCount = Task::whereHas('statusRecord', function($q) {
            $q->where('name', 'Completed');
        })->count();
        
        $recentTasks = Task::with(['statusRecord', 'assignee'])
            ->latest()
            ->limit(5)
            ->get();

        return view('livewire.dashboard', [
            'totalTasks' => $totalTasks,
            'inProgressCount' => $inProgressCount,
            'completedCount' => $completedCount,
            'recentTasks' => $recentTasks,
        ]);
    }
}
