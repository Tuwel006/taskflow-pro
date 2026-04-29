<?php

namespace App\Http\Middleware;

use App\Models\Task;
use App\Models\Workflow;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckWorkflowTransition
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $taskId = $request->route('task') ?? $request->input('task_id');
        $newStatusId = $request->input('task_status_id');

        if ($taskId && $newStatusId) {
            $task = Task::find($taskId);
            if ($task && $task->task_status_id != $newStatusId) {
                if (!$task->canTransitionTo($newStatusId)) {
                    if ($request->expectsJson()) {
                        return response()->json([
                            'error' => 'Invalid transition',
                            'message' => 'This status transition is not allowed for your team.'
                        ], 403);
                    }
                    
                    return back()->with('warning', 'This status transition is not allowed for your team.');
                }
            }
        }

        return $next($request);
    }
}
