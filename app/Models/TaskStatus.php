<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TaskStatus extends Model
{
    protected $fillable = ['name', 'color', 'order_index'];

    public function tasks()
    {
        return $this->hasMany(Task::class);
    }
}
