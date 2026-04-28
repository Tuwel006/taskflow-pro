<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class TaskCreatedNotification extends Notification implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new notification instance.
     */
    public $task;

    public function __construct($task)
    {
        $this->task = $task;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['database', 'mail', 'broadcast'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('New Task Assigned: '.$this->task->title)
            ->view('emails.task-created', [
                'name' => $notifiable->name,
                'taskTitle' => $this->task->title,
                'taskDescription' => $this->task->description,
                'taskPriority' => $this->task->priority,
                'taskDueDate' => $this->task->due_date,
                'url' => url('/tasks'), // Update to specific task URL if available
            ]);
    }

    public function toDatabase(object $notifiable): array
    {
        return [
            'task_id' => $this->task->id,
            'task_title' => $this->task->title,
            'task_description' => $this->task->description,
            'task_status' => $this->task->status,
            'task_priority' => $this->task->priority,
            'task_due_date' => $this->task->due_date,
            'task_created_at' => $this->task->created_at,
            'task_updated_at' => $this->task->updated_at,
        ];
    }

    public function toBroadcast(object $notifiable): BroadcastMessage
    {
        return new BroadcastMessage([
            'task_id' => $this->task->id,
            'task_title' => $this->task->title,
            'task_description' => $this->task->description,
            'task_status' => $this->task->status,
            'task_priority' => $this->task->priority,
            'task_due_date' => $this->task->due_date,
            'task_created_at' => $this->task->created_at,
            'task_updated_at' => $this->task->updated_at,
        ]);
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            //
        ];
    }
}
