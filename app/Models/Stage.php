<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Stage extends Model
{
    protected $fillable = ['team_id', 'status_id', 'position'];

    public function team()
    {
        return $this->belongsTo(Teams::class, 'team_id');
    }

    public function status()
    {
        return $this->belongsTo(TaskStatus::class, 'status_id');
    }

    public function tasks()
    {
        return $this->hasMany(Task::class, 'task_status_id', 'status_id');
    }
}
