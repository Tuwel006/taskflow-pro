<?php

namespace App\Models;

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
        'priority',
        'due_date',
        'assigned_to',
        'created_by',
    ];

    public function type()
    {
        return $this->belongsTo(TaskType::class, 'task_type_id');
    }

    public function statusRecord()
    {
        return $this->belongsTo(TaskStatus::class, 'task_status_id');
    }

    public function assignee()
    {
        return $this->belongsTo(User::class, 'assigned_to');
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}
