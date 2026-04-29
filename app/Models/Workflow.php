<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Workflow extends Model
{
    protected $fillable = ['project_id', 'from_status_id', 'to_status_id'];

    public function project()
    {
        return $this->belongsTo(Project::class, 'project_id');
    }

    public function fromStatus()
    {
        return $this->belongsTo(TaskStatus::class, 'from_status_id');
    }

    public function toStatus()
    {
        return $this->belongsTo(TaskStatus::class, 'to_status_id');
    }
}
