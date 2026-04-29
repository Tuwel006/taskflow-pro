<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    protected $guarded = [];

    public function users()
    {
        return $this->belongsToMany(User::class, 'project_user', 'project_id', 'user_id');
    }

    public function tasks()
    {
        return $this->hasMany(Task::class, 'project_id');
    }

    public function stages()
    {
        return $this->hasMany(Stage::class)->orderBy('position');
    }

    public function getCompletedStatusId()
    {
        $lastStage = $this->getCompletedStage();
        return $lastStage ? $lastStage->status_id : null;
    }

    public function getCompletedStage()
    {
        return $this->stages()->latest('position')->first();
    }
}
