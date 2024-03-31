<?php

namespace App\Models;

use App\Traits\Model\Blameable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use HasFactory, Blameable;

    protected $fillable = [
        'user_id',
        'task_id',
        'comment'
    ];

    public function user(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function task()
    {
        return $this->belongsTo(Task::class, 'task_id');
    }
}
