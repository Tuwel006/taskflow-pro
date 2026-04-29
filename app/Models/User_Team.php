<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class User_Team extends Model
{
    protected $table = 'user_team';
    protected $guarded = [];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function team()
    {
        return $this->belongsTo(Teams::class);
    }
}
