<?php

namespace App\Models;

use App\Models\Workflow;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Task extends Model
{
    use HasFactory;
    protected $table = 'task'; // Migration used singular 'task'

    protected $fillable = [
        'title',
        'description',
        'task_status_id',
        'task_type_id',
        'project_id',
        'task_number',
        'priority',
        'due_date',
        'assigned_to',
        'created_by',
    ];

    protected $casts = [
        'due_date' => 'date',
    ];

    protected static function booted()
    {
        static::creating(function ($task) {
            if (!$task->task_number && $task->project_id) {
                $maxNumber = static::where('project_id', $task->project_id)->max('task_number') ?? 0;
                $task->task_number = $maxNumber + 1;
            }
        });
    }

    public function getDisplayIdAttribute()
    {
        $prefix = $this->project ? $this->project->prefix : 'TASK';
        return "{$prefix}-{$this->task_number}";
    }

    public function type()
    {
        return $this->belongsTo(TaskType::class, 'task_type_id');
    }

    public function statusRecord()
    {
        return $this->belongsTo(TaskStatus::class, 'task_status_id');
    }

    public function project()
    {
        return $this->belongsTo(Project::class, 'project_id');
    }

    public function assignee()
    {
        return $this->belongsTo(User::class, 'assigned_to');
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function canTransitionTo($newStatusId)
    {
        if ($this->task_status_id == $newStatusId) {
            return true;
        }

        return Workflow::where('project_id', $this->project_id)
            ->where('from_status_id', $this->task_status_id)
            ->where('to_status_id', $newStatusId)
            ->exists();
    }

    public function getAllowedStatuses()
    {
        $toStatusIds = Workflow::where('project_id', $this->project_id)
            ->where('from_status_id', $this->task_status_id)
            ->pluck('to_status_id');

        return TaskStatus::whereIn('id', $toStatusIds)->get();
    }
}
