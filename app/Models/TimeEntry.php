<?php

namespace App\Models;

/**
 * @mixin IdeHelperTimeEntry
 */
class TimeEntry extends Model
{
    protected $fillable = [
        'task_id',
        'user_id',
        'start_time',
        'end_time',
        'duration',
    ];

    protected $casts = [
        'start_time' => 'datetime',
        'end_time' => 'datetime',
    ];

    public function task()
    {
        return $this->belongsTo(Task::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

}
