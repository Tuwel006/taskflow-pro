<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class TaskCreated
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * Create a new event instance.
     */
    public $task;

    public function __construct($task)
    {
        $this->task = $task;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return array<int, Channel>
     */
    // public function broadcastOn(): array
    // {
    //     return [
    //         new PrivateChannel('tasks-created'),
    //     ];
    // }

    // /**
    //  * The name of the queue on which to place the broadcasting job.
    //  */
    // public function broadcastQueue(): string
    // {
    //     return 'default';
    // }
}
