<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TaskType extends Model
{
    protected $table = 'tasktypes';

    protected $fillable = [
        'name',
        'description',
        'is_active',
        'icon',
    ];
}
