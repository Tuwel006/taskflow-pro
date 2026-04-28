<?php

namespace App\Jobs;

use App\Models\Task;
use App\Models\User;
use App\Notifications\PendingTasksNotification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\Notification;

class CheckUserTasks implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new job instance.
     */
    public function __construct()
    {
        //
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $users = User::all();

        foreach ($users as $user) {
            $tasks = Task::join('task_status', 'task.status_id', '=', 'task_status.id')
                ->where('task.assigned_to', '$user->id')
                ->where('task_status.name', '!=', 'Completed')
                ->count();

            if ($tasks > 0) {
                Notification::send($user, new PendingTasksNotification($tasks));
            }
        }
    }
}
