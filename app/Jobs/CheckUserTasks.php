<?php

namespace App\Jobs;

use App\Models\Task;
use App\Models\User;
use App\Notifications\PendingTasksNotification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\Log;
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
        Log::info('CheckUserTasks job started at ' . now());

        $users = User::all();

        foreach ($users as $user) {
            $tasks = Task::join('task_statuses', 'task.task_status_id', '=', 'task_statuses.id')
                ->where('task.assigned_to', $user->id)          // ← fixed: was '$user->id' (string literal)
                ->where('task_statuses.name', '!=', 'Completed') // ← fixed: table was 'task_status', should be 'task_statuses'
                ->count();

            Log::info("User {$user->id} has {$tasks} pending tasks.");

            if ($tasks > 0) {
                Notification::send($user, new PendingTasksNotification($tasks));
            }
        }

        Log::info('CheckUserTasks job finished at ' . now());
    }
}
